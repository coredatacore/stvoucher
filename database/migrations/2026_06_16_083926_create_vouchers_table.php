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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // the voucher code (e.g., 'abc123')
            $table->string('username')->unique()->nullable(); // hotspot username for MikroTik
            $table->string('password')->nullable(); // hotspot password (if different from code)
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('router_server_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['active', 'inactive', 'suspended', 'used', 'expired'])->default('inactive');
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->bigInteger('data_used_mb')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
