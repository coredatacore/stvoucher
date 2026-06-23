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
            $table->string('voucher_code')->unique();
            $table->foreignId('profile_id')->constrained('voucher_profiles')->onDelete('cascade');
            $table->string('status')->default('unused'); // unused, active, used, expired, suspended
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('duration_seconds')->default(0);
            $table->string('generated_by')->nullable();
            $table->timestamp('used_at')->nullable();
            $table->timestamp('first_login_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('nas_id')->nullable();
            $table->text('notes')->nullable();
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