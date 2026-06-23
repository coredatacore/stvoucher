<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::latest()->paginate(20);
        return view('admin.sites.index', compact('sites'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_code' => 'required|string|max:50|unique:sites,site_code',
            'location' => 'nullable|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:255',
            'ssid_name' => 'nullable|string|max:255',
            'ddns_hostname' => 'nullable|string|max:255',
            'current_public_ip' => 'nullable|ip',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Site::create($data);

        return redirect()->route('admin.sites.index')->with('success', 'Site created successfully.');
    }

    public function update(Request $request, string $id)
    {
        $site = Site::findOrFail($id);

        $data = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_code' => 'required|string|max:50|unique:sites,site_code,' . $id,
            'location' => 'nullable|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:255',
            'ssid_name' => 'nullable|string|max:255',
            'ddns_hostname' => 'nullable|string|max:255',
            'current_public_ip' => 'nullable|ip',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $site->update($data);

        return redirect()->route('admin.sites.index')->with('success', 'Site updated successfully.');
    }

    public function destroy(string $id)
    {
        $site = Site::findOrFail($id);
        $site->delete();

        return redirect()->route('admin.sites.index')->with('success', 'Site deleted successfully.');
    }
}