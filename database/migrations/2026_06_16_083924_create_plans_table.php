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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., '1 Hour', '3 Hours', '1 Day', etc.
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->integer('duration_minutes')->nullable(); // in minutes (for hour/day plans)
            $table->integer('duration_days')->nullable(); // in days (for longer plans)
            $table->bigInteger('data_limit_mb')->nullable(); // data limit in MB, null for unlimited
            $table->integer('download_speed_kbps')->nullable(); // download speed limit in kbps
            $table->integer('upload_speed_kbps')->nullable(); // upload speed limit in kbps
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
