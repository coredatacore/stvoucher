<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoucherGroup;

class VoucherGroupController extends Controller
{
    public function index()
    {
        $groups = VoucherGroup::with(['site', 'profile'])->latest()->paginate(20);
        return view('admin.groups.index', compact('groups'));
    }

    public function destroy(string $id)
    {
        $group = VoucherGroup::findOrFail($id);
        $group->delete(); // This will cascade delete vouchers in DB if setup, or we can leave them

        return redirect()->route('admin.groups.index')->with('success', 'Voucher group deleted successfully.');
    }
}