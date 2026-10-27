<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VirtualMachine extends Model
{
    use HasFactory;

    protected $fillable = [
        'vmid',
        'user_id',
        'hostname',
        'node',
        'os',
        'ip_address',
        'status',
        'term',
        'cpu_load',
        'ram_load',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isRunning(): bool
    {
        return strtolower($this->status) === 'running';
    }

    public function getSshCommandAttribute(): string
    {
        return "ssh -i ~/.ssh/id_ed25519_mut root@{$this->ip_address}";
    }
}
