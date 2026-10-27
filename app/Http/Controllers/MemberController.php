<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\VirtualMachine;
use App\Models\PublicAccess;

class MemberController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $vm = $user->virtualMachine;
        $accesses = $user->publicAccesses()->latest()->get();
        $customNodes = session('custom_nodes', []);
        $nodes = array_merge(config('noc.nodes'), $customNodes);
        $osTemplates = config('noc.os_templates');
        $currentTab = $request->query('tab', 'instances');

        return view('member.dashboard', compact('user', 'vm', 'accesses', 'nodes', 'osTemplates', 'currentTab'));
    }

    public function togglePower(Request $request)
    {
        $user = Auth::user();
        $vm = $user->virtualMachine;

        if (!$vm) {
            return back()->with('error', 'ไม่พบเครื่อง Server เสมือนของคุณในระบบ');
        }

        if ($vm->isRunning()) {
            $vm->update([
                'status' => 'stopped',
                'cpu_load' => '0.0%',
                'ram_load' => '0.0 / 2.0 GB',
            ]);
            return back()->with('success', "เครื่อง VMID: {$vm->vmid} ({$vm->hostname}) ปิดการทำงาน (Shutdown) เรียบร้อยแล้ว");
        } else {
            $vm->update([
                'status' => 'running',
                'cpu_load' => '3.8%',
                'ram_load' => '0.8 / 2.0 GB',
            ]);
            return back()->with('success', "เครื่อง VMID: {$vm->vmid} ({$vm->hostname}) เริ่มการทำงาน (Power On) สำเร็จ");
        }
    }

    public function rebootVm(Request $request)
    {
        $user = Auth::user();
        $vm = $user->virtualMachine;

        if (!$vm) {
            return back()->with('error', 'ไม่พบเครื่อง Server เสมือนของคุณ');
        }

        $vm->update([
            'status' => 'running',
            'cpu_load' => '6.5%',
            'ram_load' => '0.9 / 2.0 GB',
        ]);

        return back()->with('success', "ส่งสัญญาณ ACPI Reboot ไปยังเครื่อง VMID: {$vm->vmid} เรียบร้อยแล้ว");
    }

    public function deleteVm(Request $request)
    {
        $user = Auth::user();
        $vm = $user->virtualMachine;

        if (!$vm) {
            return back()->with('error', 'ไม่พบเครื่อง Server ที่ต้องการลบ');
        }

        $vmid = $vm->vmid;
        $hostname = $vm->hostname;

        $user->publicAccesses()->delete();
        $vm->delete();

        return redirect()->route('member.dashboard', ['tab' => 'new-vm'])
            ->with('success', "ลบเครื่อง {$hostname} (VMID: {$vmid}) เรียบร้อยแล้ว คืน Quota สำหรับเพิ่มเครื่องใหม่แล้ว");
    }

    public function deployVm(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasAvailableQuota()) {
            return back()->with('error', 'คุณได้ใช้ Quota ครบแล้ว (1/1) กรุณาลบเครื่องเดิมก่อนเพิ่มเครื่องใหม่');
        }

        $request->validate([
            'hostname' => ['required', 'string', 'max:50', 'alpha_dash'],
            'node' => ['required', 'string'],
            'os' => ['required', 'string'],
            'term' => ['required', 'string'],
        ], [
            'hostname.required' => 'กรุณาระบุชื่อ Hostname ประจำเครื่อง',
            'hostname.alpha_dash' => 'ชื่อ Hostname ต้องเป็นตัวอักษรภาษาอังกฤษ ตัวเลข และขีดกลางเท่านั้น',
        ]);

        $newVmid = 110 + VirtualMachine::count();
        $newIp = '10.20.155.' . (10 + VirtualMachine::count());

        $vm = VirtualMachine::create([
            'vmid' => $newVmid,
            'user_id' => $user->id,
            'hostname' => strtolower($request->hostname),
            'node' => $request->node,
            'os' => $request->os,
            'ip_address' => $newIp,
            'status' => 'running',
            'term' => $request->term,
            'cpu_load' => '2.4%',
            'ram_load' => '0.7 / 2.0 GB',
        ]);

        return redirect()->route('member.dashboard', ['tab' => 'instances'])
            ->with('success', "สั่งจัดสรรเครื่อง Proxmox VE สำเร็จ! เครื่อง {$vm->hostname} (VMID: {$vm->vmid}) เริ่มการทำงานบน {$vm->node} เรียบร้อยแล้ว");
    }

    public function storeDomainDnat(Request $request)
    {
        $user = Auth::user();
        $vm = $user->virtualMachine;

        if (!$vm) {
            return redirect()->route('member.dashboard', ['tab' => 'new-vm'])
                ->with('error', 'คุณยังไม่มีเครื่อง Cloud VPS ในระบบ กรุณา Deploy เครื่องก่อนขอเปิดบริการ Domain หรือ Port Forwarding');
        }

        $request->validate([
            'type' => ['required', 'in:subdomain,dnat'],
            'purpose' => ['required', 'string', 'max:255'],
        ], [
            'purpose.required' => 'กรุณาระบุวัตถุประสงค์ในการขอเปิดเส้นทางการเชื่อมต่อ',
        ]);

        $count = PublicAccess::count() + 1;
        $reqCode = sprintf('DNAT-2026-%03d', $count);

        if ($request->type === 'subdomain') {
            $request->validate([
                'subdomain_prefix' => ['required', 'string', 'alpha_dash', 'min:3', 'max:40'],
                'subdomain_port' => ['required', 'integer', 'between:1,65535'],
            ], [
                'subdomain_prefix.required' => 'กรุณาระบุชื่อ Subdomain ที่ต้องการ',
                'subdomain_prefix.alpha_dash' => 'ชื่อ Subdomain ต้องประกอบด้วยตัวอักษร ตัวเลข หรือเครื่องหมายขีด (-) เท่านั้น',
                'subdomain_prefix.min' => 'ชื่อ Subdomain ต้องมีความยาวอย่างน้อย 3 ตัวอักษร',
                'subdomain_port.required' => 'กรุณาเลือกหรือระบุพอร์ตปลายทาง',
            ]);

            $prefix = strtolower($request->subdomain_prefix);
            $endpoint = "https://{$prefix}.mut.ac.th";

            if (PublicAccess::where('endpoint', $endpoint)->exists()) {
                return back()->withErrors(['subdomain_prefix' => "ชื่อโดเมน {$endpoint} ถูกใช้งานหรืออยู่ระหว่างขออนุมัติแล้ว กรุณาเลือกชื่ออื่น"])->withInput();
            }

            $internal = "{$vm->ip_address}:{$request->subdomain_port}";
            $sslStatus = "Let's Encrypt (Pending NOC)";
        } else {
            $request->validate([
                'dnat_port' => ['required', 'integer', 'between:1,65535'],
            ], [
                'dnat_port.required' => 'กรุณาเลือกพอร์ตภายในที่ต้องการเปิดเชื่อมต่อ',
            ]);

            $usedPorts = PublicAccess::where('type', 'dnat')->pluck('endpoint')->map(function($ep) {
                $parts = explode(':', $ep);
                return isset($parts[1]) ? (int)$parts[1] : 0;
            })->toArray();

            $extPort = 22001;
            while (in_array($extPort, $usedPorts)) {
                $extPort++;
            }

            $endpoint = "202.28.15.20:{$extPort}";
            $internal = "{$vm->ip_address}:{$request->dnat_port}";
            $sslStatus = "OpenSSH / Direct TCP";
        }

        PublicAccess::create([
            'user_id' => $user->id,
            'req_code' => $reqCode,
            'type' => $request->type,
            'endpoint' => $endpoint,
            'internal_target' => $internal,
            'ssl_status' => $sslStatus,
            'purpose' => $request->purpose,
            'status' => 'pending',
        ]);

        return redirect()->route('member.dashboard', ['tab' => 'public-access'])
            ->with('success', "ส่งคำขอ {$reqCode} ({$endpoint} -> {$internal}) เรียบร้อยแล้ว เจ้าหน้าที่ NOC อาคาร Q ชั้น 1 จะดำเนินการอนุมัติเส้นทางให้");
    }

    public function resendVerification()
    {
        return back()->with('success', 'ระบบได้จัดส่งอีเมลทดสอบสำหรับยืนยันสถานะสถาบัน (@mut.ac.th) ไปยังกล่องข้อความของคุณแล้ว');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'academic_role' => ['nullable', 'string', 'max:100'],
        ], [
            'name.required' => 'กรุณาระบุชื่อ-นามสกุลจริง',
            'department.required' => 'กรุณาระบุสังกัดคณะ / สำนัก',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'department' => $request->department,
            'academic_role' => $request->academic_role ?? $user->academic_role,
        ]);

        return redirect()->route('member.dashboard', ['tab' => 'account'])
            ->with('success', 'บันทึกการแก้ไขข้อมูลโปรไฟล์สำเร็จ ข้อมูลส่วนตัวของคุณได้รับการอัปเดตเรียบร้อยแล้ว');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'กรุณาระบุรหัสผ่านปัจจุบัน',
            'password.required' => 'กรุณาระบุรหัสผ่านใหม่',
            'password.min' => 'รหัสผ่านใหม่ต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
            'password.confirmed' => 'การยืนยันรหัสผ่านใหม่ไม่ตรงกัน',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'เปลี่ยนรหัสผ่านสำเร็จ');
    }
}
