<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NocAdminController;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('member.dashboard');
    }
    return redirect()->route('login');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.submit');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register')->name('register.submit');
    Route::post('/forgot-password', 'forgotPassword')->name('forgot-password.submit');
    Route::post('/logout', 'logout')->name('logout');
});

Route::middleware(['auth'])->prefix('member')->name('member.')->controller(MemberController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/vm/power', 'togglePower')->name('vm.power');
    Route::post('/vm/reboot', 'rebootVm')->name('vm.reboot');
    Route::post('/vm/delete', 'deleteVm')->name('vm.delete');
    Route::post('/vm/deploy', 'deployVm')->name('vm.deploy');
    Route::post('/dnat/store', 'storeDomainDnat')->name('dnat.store');
    Route::post('/profile/update', 'updateProfile')->name('profile.update');
    Route::post('/resend-verify', 'resendVerification')->name('resend-verify');
    Route::post('/change-password', 'changePassword')->name('change-password');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->controller(NocAdminController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/vm/{vm}/action', 'vmAction')->name('vm.action');
    Route::post('/queue/{access}/approve', 'approveDnatQueue')->name('queue.approve');
    Route::post('/queue/{access}/reject', 'rejectDnatQueue')->name('queue.reject');
    Route::post('/members/{member}/verify', 'toggleMemberVerify')->name('members.verify');
    Route::post('/members/{member}/reset-password', 'resetMemberPassword')->name('members.reset-password');
    Route::post('/members/{member}/suspend', 'toggleMemberSuspend')->name('members.suspend');
    Route::post('/members/{member}/remove', 'removeMember')->name('members.remove');
    Route::post('/members/add', 'addMember')->name('members.add');
    Route::post('/nodes/add', 'addNode')->name('nodes.add');
});
