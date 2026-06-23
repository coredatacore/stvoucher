<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\Transaction;
use App\Models\RouterServer;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $totalSalesToday = Transaction::whereDate('created_at', $today)->where('status', 'completed')->sum('amount');
        $totalRevenue = Transaction::where('status', 'completed')->sum('amount');
        $activeUsers = Voucher::where('status', 'active')->count();
        $totalVouchers = Voucher::count();
        $recentTransactions = Transaction::latest()->take(5)->get();
        $routerServers = RouterServer::all();
        $recentVouchers = Voucher::with('plan', 'createdBy')->latest()->take(10)->get();

        return view('dashboard', compact(
            'totalSalesToday',
            'totalRevenue',
            'activeUsers',
            'totalVouchers',
            'recentTransactions',
            'routerServers',
            'recentVouchers'
        ));
    }
}
