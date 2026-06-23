<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PortalAuthService;
use Illuminate\Support\Facades\Auth;

class CaptivePortalController extends Controller
{
    public function index(Request $request)
    {
        // Pass omada params to view if available
        $params = $request->only(['client_mac', 'client_ip', 'ap_mac', 'ssid', 'site', 'redirect_url']);
        
        $theme = 'default';

        // Try to match site by SSID or Site name from Omada params
        if (!empty($params['ssid'])) {
            $site = \App\Models\Site::where('ssid_name', $params['ssid'])->first();
            if ($site && $site->theme) {
                $theme = $site->theme;
            }
        }

        // Fallback to check 'site' param if ssid didn't match
        if ($theme === 'default' && !empty($params['site'])) {
            $site = \App\Models\Site::where('site_name', $params['site'])->orWhere('site_code', $params['site'])->first();
            if ($site && $site->theme) {
                $theme = $site->theme;
            }
        }

        $viewName = "portal.themes.{$theme}.index";
        if (!view()->exists($viewName)) {
            $viewName = "portal.themes.default.index";
        }

        return view($viewName, compact('params'));
    }

    public function authenticate(Request $request, PortalAuthService $portalAuthService)
    {
        $request->validate([
            'voucher_code' => 'required|string',
        ]);

        $result = $portalAuthService->validateVoucher($request->voucher_code);

        if ($result['status'] === 'success') {
            // Omada external portal logic to authorize the user goes here.
            // Normally, you would post back to Omada's controller or FreeRADIUS would have already accepted them if it's purely RADIUS.
            // Since Omada handles WiFi hotspot enforcement and FreeRADIUS handles authentication, 
            // the portal just needs to redirect the user to Omada's auth endpoint with the voucher code.
            
            return redirect()->route('portal.success')->with('voucher', $result['voucher']);
        }

        return back()->withErrors(['voucher_code' => $result['message']]);
    }

    public function success()
    {
        if (!session()->has('voucher')) {
            return redirect()->route('portal.index');
        }
        return view('portal.success', ['voucher' => session('voucher')]);
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function adminLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}