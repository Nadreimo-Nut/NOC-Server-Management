<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'member_code',
        'name',
        'email',
        'password',
        'department',
        'academic_role',
        'role',
        'two_factor_enabled',
        'two_factor_secret',
        'quota_max',
        'status',
        'last_login_text',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'two_factor_enabled' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function virtualMachine(): HasOne
    {
        return $this->hasOne(VirtualMachine::class);
    }

    public function publicAccesses(): HasMany
    {
        return $this->hasMany(PublicAccess::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasActiveVm(): bool
    {
        return $this->virtualMachine()->exists();
    }

    public function getUsedQuotaAttribute(): int
    {
        return $this->virtualMachine()->exists() ? 1 : 0;
    }

    public function getRemainingQuotaAttribute(): int
    {
        return max(0, ($this->quota_max ?? 1) - $this->used_quota);
    }

    public function hasAvailableQuota(): bool
    {
        return $this->remaining_quota > 0;
    }

    public function isEmailVerified(): bool
    {
        return !is_null($this->email_verified_at);
    }
}
