<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== $role) {
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('member.dashboard')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงส่วนงานของผู้ดูแลระบบ (NOC Superuser)');
        }

        return $next($request);
    }
}
