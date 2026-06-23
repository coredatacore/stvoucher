<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\Plan;
use App\Models\RouterServer;
use App\Services\VoucherService;
use App\Repositories\VoucherRepository;
use Exception;

class VoucherController extends Controller
{
    protected VoucherService $voucherService;
    protected VoucherRepository $voucherRepository;

    public function __construct(VoucherService $voucherService, VoucherRepository $voucherRepository)
    {
        $this->voucherService = $voucherService;
        $this->voucherRepository = $voucherRepository;
    }

    public function index()
    {
        $vouchers = Voucher::with(['plan', 'createdBy'])->latest()->paginate(20);
        return view('vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        $plans = Plan::where('is_active', true)->get();
        $routerServers = RouterServer::where('is_active', true)->get();
        return view('vouchers.create', compact('plans', 'routerServers'));
    }

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

        try {
            if ($count > 1) {
                $vouchers = $this->voucherService->generateBulkVouchers($plan, $request->user(), $count, $routerServerId);
                return view('vouchers.generated', compact('vouchers'));
            } else {
                $voucher = $this->voucherService->generateVoucher($plan, $request->user(), $routerServerId);
                return view('vouchers.generated', ['vouchers' => [$voucher]]);
            }
        } catch (Exception $e) {
            return redirect()->route('vouchers.create')->with('error', 'Failed to create voucher: ' . $e->getMessage());
        }
    }

    public function show(Voucher $voucher)
    {
        return view('vouchers.show', compact('voucher'));
    }

    public function destroy(Voucher $voucher)
    {
        try {
            // Try to remove from MikroTik first
            if ($voucher->router_server_id) {
                $routerServer = \App\Models\RouterServer::find($voucher->router_server_id);
            }
            
            if (empty($routerServer)) {
                $routerServer = \App\Models\RouterServer::first();
            }

            if ($routerServer && !empty($routerServer->ip_address)) {
                $mikrotikService = new \App\Services\MikroTikService($routerServer);
                $mikrotikService->removeHotspotUser($voucher);
            }
        } catch (Exception $e) {
            // Ignore errors if MikroTik remove fails
        }

        $voucher->delete();
        return redirect()->route('vouchers.index')->with('success', 'Voucher deleted successfully!');
    }

    public function print(Request $request)
    {
        $request->validate([
            'voucher_ids' => 'required|string'
        ]);

        $ids = explode(',', $request->voucher_ids);
        $vouchers = Voucher::with('plan')->whereIn('id', $ids)->get();

        return view('vouchers.print', compact('vouchers'));
    }
}
