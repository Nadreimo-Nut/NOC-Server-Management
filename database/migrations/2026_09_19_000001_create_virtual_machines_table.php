<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('virtual_machines', function (Blueprint $table) {
            $table->id();
            $table->integer('vmid')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('hostname');
            $table->string('node')->default('Alpha Pool Rack 01 (pve-01)');
            $table->string('os')->default('Ubuntu 22.04 LTS');
            $table->string('ip_address')->default('10.20.155.4');
            $table->string('status')->default('running'); // 'running' or 'stopped'
            $table->string('term')->default('ภาคเรียนที่ 1/2569');
            $table->string('cpu_load')->default('4.8%');
            $table->string('ram_load')->default('0.9 / 2.0 GB');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtual_machines');
    }
};
