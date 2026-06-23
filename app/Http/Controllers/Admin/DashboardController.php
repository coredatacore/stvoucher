<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardStatsService;

class DashboardController extends Controller
{
    public function index(DashboardStatsService $statsService)
    {
        $stats = $statsService->getStats();
        return view('admin.dashboard', compact('stats'));
    }
}