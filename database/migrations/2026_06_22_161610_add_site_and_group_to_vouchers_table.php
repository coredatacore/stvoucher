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
        Schema::table('vouchers', function (Blueprint $table) {
            $table->foreignId('site_id')->nullable()->after('id')->constrained('sites')->onDelete('cascade');
            $table->foreignId('voucher_group_id')->nullable()->after('site_id')->constrained('voucher_groups')->onDelete('cascade');
            
            // Rename generated_by to created_by if needed, or just leave it. The instructions say "created_by", we'll add it or rename it.
            if (!Schema::hasColumn('vouchers', 'created_by')) {
                $table->string('created_by')->nullable()->after('last_seen_at');
            }
            if (!Schema::hasColumn('vouchers', 'nas_ip')) {
                $table->string('nas_ip')->nullable()->after('ip_address');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropForeign(['site_id']);
            $table->dropForeign(['voucher_group_id']);
            $table->dropColumn(['site_id', 'voucher_group_id']);
            
            if (Schema::hasColumn('vouchers', 'created_by')) {
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('vouchers', 'nas_ip')) {
                $table->dropColumn('nas_ip');
            }
        });
    }
};