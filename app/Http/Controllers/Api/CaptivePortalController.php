<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CaptivePortalController extends Controller
{
    // Get plans for captive portal
    public function plans()
    {
        $plans = Plan::where('is_active', true)->latest()->get();
        
        // Format plans for frontend
        $formattedPlans = $plans->map(function ($plan) {
            $totalMinutes = 0;
            if ($plan->duration_days) $totalMinutes += $plan->duration_days * 24 * 60;
            if ($plan->duration_hours) $totalMinutes += $plan->duration_hours * 60;
            if ($plan->duration_minutes) $totalMinutes += $plan->duration_minutes;

            if ($totalMinutes >= 1440 && $totalMinutes % 1440 === 0) {
                $plan->duration = $totalMinutes / 1440;
                $plan->duration_unit = 'Days';
            } elseif ($totalMinutes >= 60 && $totalMinutes % 60 === 0) {
                $plan->duration = $totalMinutes / 60;
                $plan->duration_unit = 'Hours';
            } else {
                $plan->duration = $totalMinutes;
                $plan->duration_unit = 'Minutes';
            }
            
            return $plan;
        });
        
        return response()->json(['success' => true, 'data' => $formattedPlans]);
    }

    // Login to captive portal
    public function login(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $voucher = Voucher::where('code', strtoupper($request->code))->first();

        if (!$voucher) {
            return response()->json(['success' => false, 'message' => 'Invalid voucher code'], 404);
        }

        if (!in_array($voucher->status, ['active', 'inactive'])) {
            return response()->json(['success' => false, 'message' => 'Voucher is already used or expired'], 422);
        }

        // Check if expired
        if ($voucher->expires_at && $voucher->expires_at->isPast()) {
            return response()->json(['success' => false, 'message' => 'Voucher has expired'], 422);
        }

        // Update voucher status
        $voucher->load('plan');
        $updateData = ['status' => 'used'];
        
        // Set activation time
        $updateData['activated_at'] = now();
        
        // Set expiration time based on plan
        if ($voucher->plan) {
            if ($voucher->plan->duration_minutes) {
                $updateData['expires_at'] = now()->addMinutes($voucher->plan->duration_minutes);
            } elseif ($voucher->plan->duration_days) {
                $updateData['expires_at'] = now()->addDays($voucher->plan->duration_days);
            }
        }
        
        $voucher->update($updateData);

        return response()->json([
            'success' => true, 
            'message' => 'Connected successfully!',
            'data' => $voucher->fresh('plan')
        ]);
    }

    // Router status
    public function routerStatus()
    {
        // TODO: Get actual status from MikroTik
        return response()->json([
            'success' => true,
            'data' => [
                'status' => 'online',
                'cpu_usage' => rand(5, 30),
                'memory_usage' => rand(20, 50),
                'online_users' => rand(10, 100),
                'uptime' => '15d 4h 23m'
            ]
        ]);
    }

    // Announcements
    public function announcements()
    {
        // TODO: Get announcements from DB
        return response()->json([
            'success' => true,
            'data' => [
                [
                    'id' => 1,
                    'title' => 'System Maintenance',
                    'content' => 'Scheduled maintenance on Sunday from 2:00 AM to 4:00 AM. Expect temporary downtime.',
                    'date' => 'June 15, 2024'
                ],
                [
                    'id' => 2,
                    'title' => 'New Plans Available',
                    'content' => 'Introducing our new 5-hour plan for just ₱10! Connect now and enjoy longer internet access.',
                    'date' => 'June 10, 2024'
                ],
                [
                    'id' => 3,
                    'title' => 'Network Upgrade',
                    'content' => 'We\'ve upgraded our network for faster speeds! Your connection should be more stable now.',
                    'date' => 'June 5, 2024'
                ]
            ]
        ]);
    }
}
