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
        Schema::create('voucher_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('profile_name');
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('duration')->default(0);
            $table->string('duration_unit')->default('Hours'); // Minutes, Hours, Days
            $table->string('bandwidth_limit')->nullable(); // e.g. 5M/5M
            $table->string('upload_limit')->nullable();
            $table->string('download_limit')->nullable();
            $table->integer('max_simultaneous_use')->default(1);
            $table->string('expiration_type')->default('after_login'); // absolute, after_login
            $table->text('description')->nullable();
            $table->string('status')->default('active'); // active, inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_profiles');
    }
};