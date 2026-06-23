<?php

namespace App\Services;

use App\Models\Radacct;
use App\Models\Voucher;
use App\Models\Nas;

class DashboardStatsService
{
    public function getStats()
    {
        return [
            'online_users' => Radacct::whereNull('acctstoptime')->count(),
            'active_sessions' => Radacct::whereNull('acctstoptime')->count(),
            'total_sites' => \App\Models\Site::count(),
            'total_profiles' => \App\Models\VoucherProfile::count(),
            'total_vouchers' => Voucher::count(),
            'used_vouchers' => Voucher::whereIn('status', ['used', 'active'])->count(),
            'unused_vouchers' => Voucher::where('status', 'unused')->count(),
            'expired_vouchers' => Voucher::where('status', 'expired')->count(),
            'total_nas' => Nas::count(),
            'today_revenue' => Voucher::whereIn('status', ['used', 'active'])->whereDate('used_at', \Carbon\Carbon::today())->sum('price'),
            'monthly_revenue' => Voucher::whereIn('status', ['used', 'active'])->whereMonth('used_at', \Carbon\Carbon::now()->month)->sum('price'),
            'total_data_usage' => $this->formatBytes((Radacct::sum('acctinputoctets') ?? 0) + (Radacct::sum('acctoutputoctets') ?? 0)),
            'average_session_time' => round((Radacct::whereNotNull('acctstoptime')->avg('acctsessiontime') ?? 0) / 60, 2) . ' Mins',
        ];
    }

    protected function formatBytes(int|float $bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . ($units[$i] ?? 'B');
    }
}