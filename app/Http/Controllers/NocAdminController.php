<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\VirtualMachine;
use App\Models\PublicAccess;

class NocAdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $customNodes = session('custom_nodes', []);
        $nodes = array_merge(config('noc.nodes'), $customNodes);
        $telemetry = config('noc.telemetry');
        $allVms = VirtualMachine::with('user')->get();
        $pendingDnat = PublicAccess::with('user')->where('status', 'pending')->get();
        $approvedRoutes = PublicAccess::with('user')->where('status', 'approved')->get();
        $members = User::where('role', 'member')->with('virtualMachine')->get();
        $currentTab = $request->query('tab', 'noc-dashboard');

        $totalMembers = $members->count();
        $verifiedCount = $members->filter(fn($m) => $m->isEmailVerified())->count();
        $activeCount = $members->filter(fn($m) => strtolower($m->status) === 'active')->count();
        $allocatedVms = $members->filter(fn($m) => $m->virtualMachine !== null)->count();

        $stats = [
            'total_members' => $totalMembers,
            'verified_count' => $verifiedCount,
            'verified_percent' => $totalMembers > 0 ? round(($verifiedCount / $totalMembers) * 100, 1) : 0,
            'active_count' => $activeCount,
            'active_percent' => $totalMembers > 0 ? round(($activeCount / $totalMembers) * 100, 1) : 0,
            'allocated_vms' => $allocatedVms,
        ];

        return view('admin.dashboard', compact(
            'nodes', 'telemetry', 'allVms', 'pendingDnat', 'approvedRoutes', 'members', 'stats', 'currentTab'
        ));
    }

    public function vmAction(Request $request, VirtualMachine $vm)
    {
        $action = $request->input('action');

        if ($action === 'power') {
            if ($vm->isRunning()) {
                $vm->update(['status' => 'stopped', 'cpu_load' => '0.0%', 'ram_load' => '0.0 / 2.0 GB']);
                return back()->with('success', "[NOC] Shutdown VMID: {$vm->vmid} ({$vm->hostname}) สำเร็จ");
            } else {
                $vm->update(['status' => 'running', 'cpu_load' => '3.5%', 'ram_load' => '0.8 / 2.0 GB']);
                return back()->with('success', "[NOC] Start VMID: {$vm->vmid} ({$vm->hostname}) สำเร็จ");
            }
        } elseif ($action === 'reboot') {
            $vm->update(['status' => 'running', 'cpu_load' => '5.2%']);
            return back()->with('success', "[NOC] Reboot VMID: {$vm->vmid} สำเร็จ");
        } elseif ($action === 'destroy') {
            $vmid = $vm->vmid;
            $hostname = $vm->hostname;
            $owner = $vm->user->name ?? 'สมาชิก';
            $vm->delete();
            return back()->with('success', "[NOC] ลบเครื่อง {$hostname} (VMID: {$vmid}) ของ {$owner} แล้ว");
        }

        return back();
    }

    public function approveDnatQueue(PublicAccess $access)
    {
        $access->update([
            'status' => 'approved',
            'ssl_status' => ($access->type === 'subdomain') ? 'Let\'s Encrypt SSL (Valid)' : 'OpenSSH Encrypted'
        ]);

        return back()->with('success', "อนุมัติคำขอ {$access->req_code} ({$access->endpoint}) สำเร็จ");
    }

    public function rejectDnatQueue(PublicAccess $access)
    {
        $code = $access->req_code;
        $access->delete();

        return back()->with('info', "ลบคำขอ {$code} เรียบร้อยแล้ว");
    }

    public function toggleMemberVerify(User $member)
    {
        if ($member->isEmailVerified()) {
            $member->update(['email_verified_at' => null]);
            return back()->with('info', "ปรับสถานะอีเมลของ {$member->name} เป็น Pending แล้ว");
        } else {
            $member->update(['email_verified_at' => now()]);
            return back()->with('success', "ยืนยันอีเมลให้แก่ {$member->name} สำเร็จ");
        }
    }

    public function resetMember2fa(User $member)
    {
        $member->update([
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
        ]);

        return back()->with('success', "รีเซ็ต 2FA ของ {$member->name} สำเร็จ");
    }

    public function resetMemberPassword(User $member)
    {
        $tempPwd = 'MUT-' . rand(100000, 999999) . '#MUT';
        $member->update([
            'password' => Hash::make($tempPwd),
        ]);

        return back()->with('temp_password', $tempPwd)->with('target_member', $member->name);
    }

    public function toggleMemberSuspend(User $member)
    {
        $isSuspended = ($member->status === 'Active');
        $newStatus = $isSuspended ? 'Suspended' : 'Active';

        $member->update(['status' => $newStatus]);

        $msg = $isSuspended 
            ? "ระงับการใช้งานบัญชี {$member->name} เรียบร้อยแล้ว" 
            : "เปิดใช้งานบัญชี {$member->name} สำเร็จ";

        return back()->with($isSuspended ? 'warning' : 'success', $msg);
    }

    public function removeMember(User $member)
    {
        $name = $member->name;
        $member->delete();

        return back()->with('success', "ลบบัญชี {$name} เรียบร้อยแล้ว");
    }

    public function addMember(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'department' => ['required', 'string'],
            'academic_role' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'name.required' => 'กรุณาระบุชื่อ-นามสกุล',
            'email.required' => 'กรุณาระบุอีเมลสถาบัน',
            'email.unique' => 'อีเมลนี้มีอยู่ในระบบแล้ว',
        ]);

        if (!str_ends_with(strtolower($request->email), '@mut.ac.th')) {
            return back()->withErrors(['add_member_email' => 'อีเมลต้องลงท้ายด้วย @mut.ac.th เท่านั้น']);
        }

        $nextCode = 'MUT-M0' . rand(700, 999);

        User::create([
            'member_code' => $nextCode,
            'name' => $request->name,
            'email' => strtolower($request->email),
            'department' => $request->department,
            'academic_role' => $request->academic_role,
            'password' => Hash::make($request->password),
            'role' => 'member',
            'quota_max' => 1,
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
            'status' => 'Active',
            'last_login_text' => 'สร้างโดย NOC',
            'email_verified_at' => $request->boolean('verify_email') ? now() : null,
        ]);

        return back()->with('success', "สร้างบัญชีสมาชิก {$request->name} (รหัส {$nextCode}) สำเร็จ");
    }

    public function addNode(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'ip' => ['required', 'string', 'max:50'],
            'cpu' => ['required', 'string', 'max:100'],
            'ram' => ['required', 'string', 'max:50'],
            'max_vms' => ['required', 'integer', 'min:5', 'max:100'],
            'location' => ['nullable', 'string', 'max:100'],
        ], [
            'name.required' => 'กรุณาระบุชื่อ Node Server',
            'ip.required' => 'กรุณาระบุหมายเลข IP ประจำโหนด',
            'cpu.required' => 'กรุณาระบุข้อมูลฮาร์ดแวร์ CPU',
            'ram.required' => 'กรุณาระบุขนาด RAM',
            'max_vms.required' => 'กรุณาระบุความจุรองรับ VM สูงสุด',
        ]);

        $customNodes = session('custom_nodes', []);
        $allNodes = array_merge(config('noc.nodes'), $customNodes);
        $nextIndex = count($allNodes) + 1;
        $nodeId = 'pve-0' . $nextIndex;
        $nodeName = $request->name . " ({$nodeId})";
        $poolName = $request->name . " Pool Rack 0{$nextIndex} ({$nodeId})";

        $newNode = [
            'id' => $nodeId,
            'name' => $nodeName,
            'pool_name' => $poolName,
            'location' => $request->location ?: "อาคาร Q ชั้น 1 (NOC Data Center Rack 0{$nextIndex})",
            'ip' => $request->ip,
            'cpu' => $request->cpu,
            'cpu_percent' => rand(5, 18),
            'ram_usage' => '8.0 GB / ' . $request->ram,
            'ram_percent' => rand(10, 25),
            'vms' => 0,
            'max_vms' => (int) $request->max_vms,
            'uptime' => '0d 01h',
            'status' => 'ONLINE',
            'kernel' => 'Linux 6.8.4-2-pve'
        ];

        $customNodes[$nodeId] = $newNode;
        session(['custom_nodes' => $customNodes]);

        return redirect()->route('admin.dashboard', ['tab' => 'noc-nodes'])
            ->with('success', "เพิ่ม Node Server ใหม่ [{$nodeName}] เข้าสู่ Proxmox VE Clustered Nodes อาคาร Q ชั้น 1 เรียบร้อยแล้ว");
    }
}
