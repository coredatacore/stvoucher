<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ReportService;

class ReportController extends Controller
{
    public function index(ReportService $reportService)
    {
        $dailySales = $reportService->getSales('daily');
        $weeklySales = $reportService->getSales('weekly');
        $monthlySales = $reportService->getSales('monthly');

        return view('admin.reports.index', compact('dailySales', 'weeklySales', 'monthlySales'));
    }
}