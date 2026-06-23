<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RouterServer;

class SettingsController extends Controller
{
    public function index()
    {
        $server = RouterServer::first();
        
        $mikrotikHost = $server->ip_address ?? '';
        $mikrotikPort = $server->api_port ?? '8728';
        $mikrotikUser = $server->api_username ?? '';
        $mikrotikPassword = $server->api_password ?? '';

        return view('settings.index', compact('mikrotikHost', 'mikrotikPort', 'mikrotikUser', 'mikrotikPassword'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mikrotik_host' => 'required|string',
            'mikrotik_port' => 'required|integer',
            'mikrotik_user' => 'required|string',
            'mikrotik_password' => 'nullable|string',
        ]);

        $server = RouterServer::first();
        if (!$server) {
            $server = new RouterServer();
            $server->name = 'Default Router';
            $server->is_active = true;
        }

        $server->ip_address = $validated['mikrotik_host'];
        $server->api_port = $validated['mikrotik_port'];
        $server->api_username = $validated['mikrotik_user'];
        if (isset($validated['mikrotik_password'])) {
            $server->api_password = $validated['mikrotik_password'];
        }

        $server->save();

        return redirect()->route('settings.index')->with('success', 'Router Server settings saved successfully!');
    }
}
