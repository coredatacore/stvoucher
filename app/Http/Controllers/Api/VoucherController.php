<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Plan;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    protected VoucherService $voucherService;

    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vouchers = Voucher::with(['plan', 'createdBy'])->latest()->paginate(20);
        return response()->json($vouchers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'router_server_id' => 'nullable|exists:router_servers,id',
            'count' => 'integer|min:1|max:100',
        ]);

        $plan = Plan::findOrFail($validated['plan_id']);
        $count = $validated['count'] ?? 1;
        $routerServerId = $validated['router_server_id'] ?? null;

        if ($count > 1) {
            $vouchers = $this->voucherService->generateBulkVouchers($plan, Auth::user(), $count, $routerServerId);
            return response()->json(['message' => 'Vouchers created successfully', 'vouchers' => $vouchers], 201);
        } else {
            $voucher = $this->voucherService->generateVoucher($plan, Auth::user(), $routerServerId);
            return response()->json(['message' => 'Voucher created successfully', 'voucher' => $voucher], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Voucher $voucher)
    {
        return response()->json($voucher->load(['plan', 'createdBy']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return response()->json(['message' => 'Voucher deleted successfully']);
    }
}
