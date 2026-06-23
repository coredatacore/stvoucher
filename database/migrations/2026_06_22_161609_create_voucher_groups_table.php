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
        Schema::create('voucher_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->string('group_name');
            $table->string('batch_code')->unique();
            $table->foreignId('voucher_profile_id')->constrained('voucher_profiles')->onDelete('cascade');
            $table->integer('quantity');
            $table->string('prefix')->nullable();
            $table->string('generated_by')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_groups');
    }
};