<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoucherProfile;

class VoucherProfileController extends Controller
{
    public function index()
    {
        $profiles = VoucherProfile::latest()->paginate(10);
        return view('admin.profiles.index', compact('profiles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'profile_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:0',
            'duration_unit' => 'required|in:Minutes,Hours,Days',
            'bandwidth_limit' => 'nullable|string|max:50',
            'upload_limit' => 'nullable|string|max:50',
            'download_limit' => 'nullable|string|max:50',
            'max_simultaneous_use' => 'required|integer|min:1',
            'expiration_type' => 'required|in:absolute,after_login',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        VoucherProfile::create($data);

        return redirect()->route('admin.profiles.index')->with('success', 'Profile created successfully.');
    }

    public function update(Request $request, string $id)
    {
        $profile = VoucherProfile::findOrFail($id);
        
        $data = $request->validate([
            'profile_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:0',
            'duration_unit' => 'required|in:Minutes,Hours,Days',
            'bandwidth_limit' => 'nullable|string|max:50',
            'upload_limit' => 'nullable|string|max:50',
            'download_limit' => 'nullable|string|max:50',
            'max_simultaneous_use' => 'required|integer|min:1',
            'expiration_type' => 'required|in:absolute,after_login',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $profile->update($data);

        return redirect()->route('admin.profiles.index')->with('success', 'Profile updated successfully.');
    }

    public function destroy(string $id)
    {
        $profile = VoucherProfile::findOrFail($id);
        $profile->delete();

        return redirect()->route('admin.profiles.index')->with('success', 'Profile deleted successfully.');
    }
}