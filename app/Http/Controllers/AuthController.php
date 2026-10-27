<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin() 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('member.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'กรุณากรอกอีเมลสถาบัน',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ]);

        if (!str_ends_with(strtolower($request->email), '@mut.ac.th')) {
            return back()->withErrors(['email' => 'กรุณาใช้อีเมลสถาบันการศึกษาที่ลงท้ายด้วย @mut.ac.th เท่านั้น'])->withInput();
        }

        $user = User::where('email', strtolower($request->email))->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'อีเมลสถาบันหรือรหัสผ่านไม่ถูกต้อง'])->withInput();
        }

        if ($user->status === 'Suspended') {
            return back()->withErrors(['email' => 'บัญชีนี้ถูกระงับการใช้งาน กรุณาติดต่อห้อง NOC อาคาร Q ชั้น 1'])->withInput();
        }

        Auth::login($user, $request->boolean('remember'));
        $user->update(['last_login_text' => 'วันนี้ ' . now()->format('H:i') . ' น.']);

        $request->session()->regenerate();

        return $user->isAdmin() 
            ? redirect()->route('admin.dashboard')->with('success', 'เข้าสู่ระบบศูนย์บัญชาการ NOC เรียบร้อยแล้ว')
            : redirect()->route('member.dashboard')->with('success', 'ยินดีต้อนรับ ' . $user->name);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'academic_role' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'กรุณากรอกชื่อ - นามสกุล',
            'department.required' => 'กรุณากรอกสังกัดคณะ / ภาควิชา',
            'email.required' => 'กรุณากรอกอีเมลสถาบัน (@mut.ac.th)',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'email.unique' => 'อีเมลนี้ถูกลงทะเบียนไว้ในระบบแล้ว',
            'password.required' => 'กรุณากำหนดรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร',
            'password.confirmed' => 'การยืนยันรหัสผ่านไม่ตรงกัน',
        ]);

        if (!str_ends_with(strtolower($request->email), '@mut.ac.th')) {
            return back()->withErrors(['email' => 'อีเมลต้องลงท้ายด้วย @mut.ac.th เท่านั้น'])->withInput();
        }

        $nextCode = 'MUT-M0' . rand(800, 999);

        $user = User::create([
            'member_code' => $nextCode,
            'name' => $request->name,
            'email' => strtolower($request->email),
            'department' => $request->department,
            'academic_role' => $request->academic_role,
            'password' => Hash::make($request->password),
            'role' => 'member',
            'quota_max' => 1,
            'two_factor_enabled' => false,
            'status' => 'Active',
            'last_login_text' => 'เพิ่งสมัครใหม่',
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->route('member.dashboard')->with('success', "ลงทะเบียนสำเร็จ! ยินดีต้อนรับ {$user->name} คุณได้รับสิทธิ์โควตา 1 สิทธิ์เรียบร้อยแล้ว");
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'กรุณาระบุอีเมลสถาบัน',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
        ]);

        if (!str_ends_with(strtolower($request->email), '@mut.ac.th')) {
            return back()->withErrors(['forgot_email' => 'กรุณาระบุอีเมลสถาบันที่ลงท้ายด้วย @mut.ac.th เท่านั้น']);
        }

        return back()->with('status', "ระบบได้จัดส่งลิงก์รีเซ็ตรหัสผ่านชั่วคราวไปยัง {$request->email} เรียบร้อยแล้ว");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'ออกจากระบบเรียบร้อยแล้ว');
    }
}
