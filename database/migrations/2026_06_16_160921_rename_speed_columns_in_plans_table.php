<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Plan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->decimal('download_speed_mbps', 8, 2)->nullable()->after('data_limit_mb');
            $table->decimal('upload_speed_mbps', 8, 2)->nullable()->after('download_speed_mbps');
        });

        // Convert existing kbps to Mbps
        Plan::each(function ($plan) {
            if ($plan->download_speed_kbps) {
                $plan->download_speed_mbps = $plan->download_speed_kbps / 1000;
            }
            if ($plan->upload_speed_kbps) {
                $plan->upload_speed_mbps = $plan->upload_speed_kbps / 1000;
            }
            $plan->save();
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['download_speed_kbps', 'upload_speed_kbps']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('download_speed_kbps')->nullable()->after('data_limit_mb');
            $table->integer('upload_speed_kbps')->nullable()->after('download_speed_kbps');
        });

        // Convert back Mbps to kbps
        Plan::each(function ($plan) {
            if ($plan->download_speed_mbps) {
                $plan->download_speed_kbps = $plan->download_speed_mbps * 1000;
            }
            if ($plan->upload_speed_mbps) {
                $plan->upload_speed_kbps = $plan->upload_speed_mbps * 1000;
            }
            $plan->save();
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['download_speed_mbps', 'upload_speed_mbps']);
        });
    }
};
