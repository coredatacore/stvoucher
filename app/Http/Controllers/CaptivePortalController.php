<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CaptivePortalController extends Controller
{
    // Landing Page
    public function index(Request $request)
    {
        if ($request->has('mac')) {
            session(['client_mac' => $request->mac]);
        }
        return view('captive.index');
    }

    // Login Page
    public function login(Request $request)
    {
        if ($request->has('mac')) {
            session(['client_mac' => $request->mac]);
        }
        return view('captive.login');
    }

    // Login Submit
    public function submitLogin(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $voucher = Voucher::where('code', strtoupper($request->code))->first();

        if (!$voucher) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Invalid voucher code'], 422);
            }
            return back()->withErrors(['code' => 'Invalid voucher code']);
        }

        if (!in_array($voucher->status, ['active', 'inactive', 'suspended', 'used'])) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Voucher is already expired or invalid'], 422);
            }
            return back()->withErrors(['code' => 'Voucher is already expired or invalid']);
        }

        // Check if expired
        if ($voucher->expires_at && $voucher->expires_at->isPast()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Voucher has expired'], 422);
            }
            return back()->withErrors(['code' => 'Voucher has expired']);
        }

        // Check if absolute validity has expired
        if ($voucher->valid_until && $voucher->valid_until->isPast()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Voucher validity has expired'], 422);
            }
            return back()->withErrors(['code' => 'Voucher validity has expired']);
        }

        $macAddress = $request->input('mac') ?? session('client_mac') ?? $request->ip();

        if (in_array($voucher->status, ['used', 'suspended'])) {
            if ($voucher->mac_address) {
                if ($voucher->mac_address !== $macAddress) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json(['success' => false, 'message' => 'Voucher is already use. Pls use another voucher!'], 422);
                    }
                    return back()->withErrors(['code' => 'Voucher is already use. Pls use another voucher!']);
                }
            } else {
                // Bind MAC if it was activated before the MAC tracking feature was added
                $voucher->update(['mac_address' => $macAddress]);
            }
        }

        $voucher->load('plan');
        
        // If voucher is suspended, resume it
        if ($voucher->status === 'suspended') {
            $remainingSeconds = $voucher->remaining_seconds_when_paused ?? 0;
            $voucher->update([
                'status' => 'used',
                'paused_at' => null,
                'remaining_seconds_when_paused' => null,
                'expires_at' => now()->addSeconds($remainingSeconds)
            ]);
        } 
        // If voucher is inactive/active (first use), activate it
        elseif (in_array($voucher->status, ['active', 'inactive'])) {
            $updateData = [
                'status' => 'used',
                'activated_at' => now(),
                'mac_address' => $macAddress
            ];
            
            // Set expiration time based on plan
            if ($voucher->plan) {
                $totalMinutes = 0;
                if ($voucher->plan->duration_days) {
                    $totalMinutes += $voucher->plan->duration_days * 24 * 60;
                }
                if ($voucher->plan->duration_hours) {
                    $totalMinutes += $voucher->plan->duration_hours * 60;
                }
                if ($voucher->plan->duration_minutes) {
                    $totalMinutes += $voucher->plan->duration_minutes;
                }

                if ($totalMinutes > 0) {
                    $updateData['expires_at'] = now()->addMinutes($totalMinutes);
                }

                // Set validity based on plan
                if ($voucher->plan->validity_days) {
                    $updateData['valid_until'] = now()->addDays($voucher->plan->validity_days);
                }
            }
            $voucher->update($updateData);
        }

        // Store voucher in session
        Session::put('captive_voucher', $voucher->id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Connected successfully!',
                'redirect' => route('captive.dashboard')
            ]);
        }

        return redirect()->route('captive.dashboard')->with('success', 'Connected successfully!');
    }

    // Coin Insert Page
    public function coin()
    {
        return view('captive.coin');
    }

    // Rates Page
    public function rates()
    {
        return view('captive.rates');
    }

    // User Dashboard
    public function dashboard()
    {
        $voucherId = Session::get('captive_voucher');
        $voucher = null;
        
        if ($voucherId) {
            $voucher = Voucher::with('plan')->find($voucherId);
        }
        
        return view('captive.dashboard', compact('voucher'));
    }

    // Announcements Page
    public function announcements()
    {
        return view('captive.announcements');
    }

    // Help Center
    public function help()
    {
        return view('captive.help');
    }

    // Router Status
    public function routerStatus()
    {
        return view('captive.router-status');
    }

    // Session History
    public function sessionHistory()
    {
        return view('captive.session-history');
    }

    // Logout
    public function logout()
    {
        Session::forget('captive_voucher');
        return redirect()->route('captive.index')->with('info', 'Disconnected successfully!');
    }

    // Pause Session
    public function pause()
    {
        $voucherId = Session::get('captive_voucher');
        if (!$voucherId) {
            return response()->json(['success' => false, 'message' => 'No active session']);
        }

        $voucher = Voucher::with('plan')->find($voucherId);
        if (!$voucher || $voucher->status !== 'used' || $voucher->status === 'suspended') {
            return response()->json(['success' => false, 'message' => 'Cannot pause this session']);
        }

        // Check if pause limit is reached
        if ($voucher->plan && $voucher->plan->pause_limit !== null) {
            if ($voucher->pause_count >= $voucher->plan->pause_limit) {
                return response()->json(['success' => false, 'message' => 'Pause limit reached for this voucher']);
            }
        }

        // Calculate remaining seconds
        $remainingSeconds = $voucher->expires_at ? now()->diffInSeconds($voucher->expires_at, false) : 0;
        
        // Prevent negative remaining time
        if ($remainingSeconds < 0) $remainingSeconds = 0;

        $voucher->update([
            'status' => 'suspended',
            'paused_at' => now(),
            'remaining_seconds_when_paused' => $remainingSeconds,
            'expires_at' => null // Clear expiration since it's paused
        ]);

        $voucher->increment('pause_count');

        return response()->json(['success' => true, 'message' => 'Session paused']);
    }

    // Resume Session
    public function resume()
    {
        $voucherId = Session::get('captive_voucher');
        if (!$voucherId) {
            return response()->json(['success' => false, 'message' => 'No active session']);
        }

        $voucher = Voucher::find($voucherId);
        if (!$voucher || $voucher->status !== 'suspended') {
            return response()->json(['success' => false, 'message' => 'Cannot resume this session']);
        }

        $remainingSeconds = $voucher->remaining_seconds_when_paused ?? 0;

        $voucher->update([
            'status' => 'used',
            'paused_at' => null,
            'remaining_seconds_when_paused' => null,
            'expires_at' => now()->addSeconds($remainingSeconds)
        ]);

        return response()->json(['success' => true, 'message' => 'Session resumed', 'expires_at' => $voucher->expires_at]);
    }
}
