<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            // Auto-pause settings
            $table->boolean('auto_pause')->default(false)->after('status');
            $table->integer('remaining_seconds')->nullable()->after('auto_pause');
            $table->timestamp('last_pause_at')->nullable()->after('remaining_seconds');
            $table->timestamp('last_resume_at')->nullable()->after('last_pause_at');
            
            // Time tracking for auto-pause calculation
            $table->integer('total_used_seconds')->default(0)->after('last_resume_at');
        });
    }

    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn([
                'auto_pause',
                'remaining_seconds',
                'last_pause_at',
                'last_resume_at',
                'total_used_seconds',
            ]);
        });
    }
};
