<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VoucherService;
use App\Services\PortalAuthService;
use App\Services\RadiusAccountingService;
use App\Services\DashboardStatsService;
use App\Models\VoucherProfile;

class VoucherApiController extends Controller
{
    public function generate(Request $request, VoucherService $voucherService)
    {
        $request->validate([
            'profile_id' => 'required|exists:voucher_profiles,id',
            'format' => 'required|string',
        ]);

        $profile = VoucherProfile::findOrFail($request->profile_id);
        $voucher = $voucherService->generateSingle($profile, $request->format, $request->prefix);
        
        return response()->json(['status' => 'success', 'voucher' => $voucher]);
    }

    public function bulkGenerate(Request $request, VoucherService $voucherService)
    {
        $request->validate([
            'profile_id' => 'required|exists:voucher_profiles,id',
            'quantity' => 'required|integer',
            'format' => 'required|string',
        ]);

        $profile = VoucherProfile::findOrFail($request->profile_id);
        $vouchers = $voucherService->generateBulk($profile, $request->quantity, $request->format, $request->prefix);
        
        return response()->json(['status' => 'success', 'vouchers' => $vouchers]);
    }

    public function validateVoucher(Request $request, PortalAuthService $portalAuthService)
    {
        $request->validate(['voucher_code' => 'required']);
        return response()->json($portalAuthService->validateVoucher($request->voucher_code));
    }

    public function status(string $code)
    {
        $voucher = \App\Models\Voucher::where('voucher_code', $code)->first();
        if (!$voucher) return response()->json(['status' => 'error', 'message' => 'Not found'], 404);
        return response()->json(['status' => 'success', 'voucher' => $voucher]);
    }

    public function activeSessions(RadiusAccountingService $accountingService)
    {
        return response()->json(['status' => 'success', 'sessions' => $accountingService->getActiveSessions()]);
    }

    public function dashboardStats(DashboardStatsService $statsService)
    {
        return response()->json(['status' => 'success', 'stats' => $statsService->getStats()]);
    }
}