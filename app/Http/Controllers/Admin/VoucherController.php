<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Services\VoucherService;

class VoucherController extends Controller
{
    protected VoucherService $voucherService;

    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    public function index(Request $request)
    {
        $query = Voucher::with(['site', 'profile']);

        if ($request->filled('site_id')) {
            $query->where('site_id', $request->site_id);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $query->where('voucher_code', 'like', '%' . $request->search . '%');
        }

        $vouchers = $query->latest()->paginate(20);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'profile_id' => 'required|exists:voucher_profiles,id',
            'format' => 'required|string',
            'prefix' => 'nullable|string',
            'site_id' => 'nullable|exists:sites,id'
        ]);

        $profile = \App\Models\VoucherProfile::findOrFail($data['profile_id']);
        $this->voucherService->generateSingle($profile, $data['format'], $data['prefix'] ?? null, $data['site_id'] ?? null);

        return back()->with('success', 'Voucher generated successfully.');
    }

    public function bulk(Request $request)
    {
        $data = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'profile_id' => 'required|exists:voucher_profiles,id',
            'quantity' => 'required|integer|min:1|max:1000',
            'format' => 'required|string',
            'prefix' => 'nullable|string',
        ]);

        $profile = \App\Models\VoucherProfile::findOrFail($data['profile_id']);
        $this->voucherService->generateBulk($profile, $data['quantity'], $data['format'], $data['prefix'] ?? null, $data['site_id']);

        return back()->with('success', $data['quantity'] . ' vouchers generated successfully.');
    }

    public function destroy($id)
    {
        Voucher::findOrFail($id)->delete();
        return back()->with('success', 'Voucher deleted successfully.');
    }

    public function print(Request $request)
    {
        $query = Voucher::with(['site', 'profile']);

        if ($request->filled('site_id')) {
            $query->where('site_id', $request->site_id);
        }

        $vouchers = $query->latest()->get();
        return view('admin.vouchers.print', compact('vouchers'));
    }
}