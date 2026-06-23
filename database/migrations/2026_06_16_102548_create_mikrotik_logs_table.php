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
        Schema::create('mikrotik_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // e.g., 'connect', 'add_hotspot_user', 'print_hotspot_users', 'get_identity', 'get_version', 'remove_hotspot_user'
            $table->text('request_payload'); // JSON of request data
            $table->text('response_payload'); // JSON of response data
            $table->string('status'); // 'success', 'failed'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mikrotik_logs');
    }
};
