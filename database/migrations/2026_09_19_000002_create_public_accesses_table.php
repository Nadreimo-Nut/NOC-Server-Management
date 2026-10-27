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
        Schema::create('public_accesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('req_code')->unique();
            $table->string('type'); // 'subdomain' or 'dnat'
            $table->string('endpoint'); // e.g. 'https://cpe-ai-research.mut.ac.th' or '202.28.15.20:22004'
            $table->string('internal_target'); // e.g. '10.20.155.4:80'
            $table->string('ssl_status')->default('Let\'s Encrypt (Active)');
            $table->string('purpose')->nullable();
            $table->string('status')->default('pending'); // 'pending', 'approved', 'rejected'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_accesses');
    }
};
