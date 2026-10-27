<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VirtualMachine;
use App\Models\PublicAccess;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
    public function test_login_screen_renders_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('MUT CLOUD VPS PROVISIONING');
        $response->assertSee('เข้าสู่ระบบสถาบัน');
    }

    public function test_login_direct_without_2fa_prompt(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@mut.ac.th',
            'password' => 'AdminPass123!',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();
    }

    public function test_register_screen_renders_successfully(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('กรอกข้อมูลสมาชิกสถาบัน');
    }

    public function test_register_rejects_non_mut_email(): void
    {
        $response = $this->post('/register', [
            'name' => 'Tester User',
            'department' => 'วิศวกรรมคอมพิวเตอร์',
            'academic_role' => 'student',
            'email' => 'hacker@gmail.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_authenticated_member_can_view_dashboard(): void
    {
        $memberWithVm = User::where('role', 'member')->whereHas('virtualMachine')->first();
        if ($memberWithVm) {
            $response = $this->actingAs($memberWithVm)->get('/member/dashboard');
            $response->assertStatus(200);
            $response->assertSee('จัดการเครื่อง Server และบริการสถาบัน');
            $response->assertSee($memberWithVm->virtualMachine->hostname);
        }

        // Test member with available quota requesting new-vm tab
        $newMember = User::create([
            'name' => 'นายสมศักดิ์ รักเรียน',
            'member_code' => 'STU-650099',
            'email' => 'somsak@mut.ac.th',
            'password' => bcrypt('password123'),
            'department' => 'วิศวกรรมคอมพิวเตอร์',
            'academic_role' => 'student',
            'role' => 'member',
            'quota_max' => 1,
            'status' => 'active',
        ]);

        $provResponse = $this->actingAs($newMember)->get('/member/dashboard?tab=new-vm');
        $provResponse->assertStatus(200);
        $provResponse->assertSee('การเพิ่มเครื่อง Server');
    }

    public function test_admin_can_view_noc_command_center(): void
    {
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $this->markTestSkipped('No admin user seeded.');
        }

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Proxmox VE');
        $response->assertSee('Clustered CPU Allocation');

        // Test Member Directory Tab
        $memberTabResponse = $this->actingAs($admin)->get('/admin/dashboard?tab=noc-members');
        $memberTabResponse->assertStatus(200);
        $memberTabResponse->assertSee('ทำเนียบสมาชิกสถาบันและการจัดการความปลอดภัย');
    }

    public function test_regular_member_forbidden_from_admin_dashboard(): void
    {
        $member = User::where('role', 'member')->first();
        if (!$member) {
            $this->markTestSkipped('No member user seeded.');
        }

        $response = $this->actingAs($member)->get('/admin/dashboard');
        $response->assertRedirect('/member/dashboard');
        $response->assertSessionHas('error');
    }

    public function test_member_can_toggle_vm_power(): void
    {
        $member = User::where('role', 'member')->whereHas('virtualMachine')->first();
        $vm = $member->virtualMachine;

        $initialStatus = $vm->status;
        $response = $this->actingAs($member)->post('/member/vm/power');
        $response->assertRedirect();
        
        $vm->refresh();
        $this->assertNotEquals($initialStatus, $vm->status);
    }

    public function test_member_can_request_subdomain(): void
    {
        $member = User::where('role', 'member')->whereHas('virtualMachine')->first();

        $response = $this->actingAs($member)->post('/member/dnat/store', [
            'type' => 'subdomain',
            'subdomain_prefix' => 'research-lab',
            'subdomain_port' => 8080,
            'purpose' => 'Test research laboratory subdomain',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('public_accesses', [
            'user_id' => $member->id,
            'type' => 'subdomain',
            'endpoint' => 'https://research-lab.mut.ac.th',
            'status' => 'pending',
        ]);
    }

    public function test_admin_can_approve_subdomain_request(): void
    {
        $admin = User::where('role', 'admin')->first();
        $pending = PublicAccess::where('status', 'pending')->first();

        if ($pending) {
            $response = $this->actingAs($admin)->post("/admin/queue/{$pending->id}/approve");
            $response->assertRedirect();

            $pending->refresh();
            $this->assertEquals('approved', $pending->status);
        }
    }

    public function test_admin_can_toggle_member_email_verification(): void
    {
        $admin = User::where('role', 'admin')->first();
        $member = User::where('role', 'member')->first();

        $wasVerified = !is_null($member->email_verified_at);
        $response = $this->actingAs($admin)->post("/admin/members/{$member->id}/verify");
        $response->assertRedirect();

        $member->refresh();
        $isVerified = !is_null($member->email_verified_at);
        $this->assertNotEquals($wasVerified, $isVerified);
    }

    public function test_member_without_vm_cannot_request_subdomain(): void
    {
        $newMember = User::create([
            'name' => 'นายสมชาย ไร้เครื่อง',
            'member_code' => 'STU-650098',
            'email' => 'novm@mut.ac.th',
            'password' => bcrypt('password123'),
            'department' => 'วิศวกรรมคอมพิวเตอร์',
            'academic_role' => 'student',
            'role' => 'member',
            'quota_max' => 1,
            'status' => 'Active',
        ]);

        $response = $this->actingAs($newMember)->post('/member/dnat/store', [
            'type' => 'subdomain',
            'subdomain_prefix' => 'ghost-vm',
            'subdomain_port' => 80,
            'purpose' => 'Should fail due to no VM',
        ]);

        $response->assertRedirect('/member/dashboard?tab=new-vm');
        $response->assertSessionHas('error');
    }

    public function test_quota_meter_tracks_vm_lifecycle(): void
    {
        $member = User::create([
            'name' => 'นางสาวกานดา นคร',
            'member_code' => 'STU-650097',
            'email' => 'kanda@mut.ac.th',
            'password' => bcrypt('password123'),
            'department' => 'เทคโนโลยีสารสนเทศ',
            'academic_role' => 'student',
            'role' => 'member',
            'quota_max' => 1,
            'status' => 'Active',
        ]);

        // Initially has available quota
        $this->assertTrue($member->hasAvailableQuota());
        $this->assertEquals(0, $member->used_quota);

        // Deploy VM
        $this->actingAs($member)->post('/member/vm/deploy', [
            'hostname' => 'kanda-vps-01',
            'node' => 'pve-node-01',
            'os' => 'Ubuntu 24.04 LTS Server',
            'term' => '1 ภาคการศึกษา (4 เดือน)',
        ]);

        $member->refresh();
        $this->assertFalse($member->hasAvailableQuota());
        $this->assertEquals(1, $member->used_quota);
        $this->assertNotNull($member->virtualMachine);

        // Delete VM -> Quota restored
        $this->actingAs($member)->post('/member/vm/delete');

        $member->refresh();
        $this->assertTrue($member->hasAvailableQuota());
        $this->assertEquals(0, $member->used_quota);
        $this->assertNull($member->virtualMachine);
    }

    public function test_suspended_member_cannot_login(): void
    {
        $suspendedUser = User::create([
            'name' => 'ผู้ถูกระงับ สิทธิ์',
            'member_code' => 'STU-650096',
            'email' => 'suspended@mut.ac.th',
            'password' => bcrypt('password123'),
            'department' => 'วิศวกรรมคอมพิวเตอร์',
            'academic_role' => 'student',
            'role' => 'member',
            'quota_max' => 1,
            'status' => 'Suspended',
        ]);

        $response = $this->post('/login', [
            'email' => 'suspended@mut.ac.th',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_member_can_update_profile(): void
    {
        $member = User::where('role', 'member')->first();

        $response = $this->actingAs($member)->post('/member/profile/update', [
            'name' => 'ดร.กมลชัย เกียรติสกุลชัย (ฉบับปรับปรุง)',
            'department' => 'สำนักวิจัยและพัฒนาเครือข่าย',
            'academic_role' => 'อาจารย์ประจำภาควิชา',
        ]);

        $response->assertRedirect('/member/dashboard?tab=account');
        $response->assertSessionHas('success');

        $member->refresh();
        $this->assertEquals('ดร.กมลชัย เกียรติสกุลชัย (ฉบับปรับปรุง)', $member->name);
        $this->assertEquals('สำนักวิจัยและพัฒนาเครือข่าย', $member->department);
    }

    public function test_admin_can_add_node_server(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post('/admin/nodes/add', [
            'name' => 'Delta Compute Node',
            'ip' => '10.20.0.14',
            'cpu' => 'AMD EPYC 7742 (24 Cores)',
            'ram' => '128 GB',
            'max_vms' => 25,
            'location' => 'อาคาร Q ชั้น 1 (NOC Data Center Rack 04)',
        ]);

        $response->assertRedirect('/admin/dashboard?tab=noc-nodes');
        $response->assertSessionHas('success');

        $dashResponse = $this->actingAs($admin)->get('/admin/dashboard?tab=noc-nodes');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Delta Compute Node');
        $dashResponse->assertSee('10.20.0.14');
        $dashResponse->assertSee('Quorum: 4 Nodes');
    }
}
