<?php

namespace App\Services;

use App\Models\Voucher;
use Carbon\Carbon;

class ReportService
{
    public function getSales(string $period, ?int $siteId = null)
    {
        $query = Voucher::where('status', '!=', 'unused');
        
        if ($siteId) {
            $query->where('site_id', $siteId);
        }

        if ($period == 'daily') {
            $query->whereDate('used_at', Carbon::today());
        } elseif ($period == 'weekly') {
            $query->whereBetween('used_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($period == 'monthly') {
            $query->whereMonth('used_at', Carbon::now()->month);
        }

        return $query->sum('price');
    }
}