<?php

namespace App\Services;

use App\Models\Voucher;
use App\Models\VoucherProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Service for handling voucher time tracking based on price
 * 
 * - Paid vouchers (price > 0): Auto-pause on disconnect (usage-based)
 * - Free vouchers (price = 0): Continuous countdown (real-time based)
 */
class VoucherTimeTrackingService
{
    /**
     * Determine if a voucher should have auto-pause enabled
     * 
     * @param float $price
     * @return bool
     */
    public function shouldAutoPause(float $price): bool
    {
        // Paid vouchers: auto-pause enabled (usage-based)
        // Free vouchers: auto-pause disabled (continuous countdown)
        return $price > 0;
    }

    /**
     * Initialize voucher time tracking when voucher is first used
     * 
     * @param Voucher $voucher
     * @return void
     */
    public function initializeTimeTracking(Voucher $voucher): void
    {
        $profile = $voucher->profile;
        
        if (!$profile) {
            Log::error("Cannot initialize time tracking: Profile not found for voucher {$voucher->id}");
            return;
        }

        $price = (float) $voucher->price;
        $autoPause = $this->shouldAutoPause($price);

        // Set up initial tracking values
        $voucher->update([
            'auto_pause' => $autoPause,
            'remaining_seconds' => $voucher->duration_seconds,
            'first_login_at' => now(),
            'last_resume_at' => now(),
            'total_used_seconds' => 0,
        ]);

        Log::info("Voucher {$voucher->voucher_code} initialized with auto_pause={$autoPause}, price={$price}");
    }

    /**
     * Handle voucher pause on disconnect
     * 
     * @param Voucher $voucher
     * @return void
     */
    public function pauseVoucher(Voucher $voucher): void
    {
        // Only pause if auto_pause is enabled (paid vouchers)
        if (!$voucher->auto_pause) {
            Log::debug("Voucher {$voucher->voucher_code}: Auto-pause disabled, continuing countdown");
            return;
        }

        // Calculate used time since last resume
        $lastResume = $voucher->last_resume_at;
        if ($lastResume) {
            $usedSeconds = now()->diffInSeconds($lastResume);
            $newTotalUsed = $voucher->total_used_seconds + $usedSeconds;
            $newRemaining = max(0, $voucher->duration_seconds - $newTotalUsed);

            $voucher->update([
                'total_used_seconds' => $newTotalUsed,
                'remaining_seconds' => $newRemaining,
                'last_pause_at' => now(),
            ]);

            Log::info("Voucher {$voucher->voucher_code} paused. Used: {$usedSeconds}s, Remaining: {$newRemaining}s");
        }
    }

    /**
     * Handle voucher resume on reconnect
     * 
     * @param Voucher $voucher
     * @return void
     */
    public function resumeVoucher(Voucher $voucher): void
    {
        // Update last resume time
        $voucher->update([
            'last_resume_at' => now(),
        ]);

        Log::info("Voucher {$voucher->voucher_code} resumed");
    }

    /**
     * Calculate remaining time for a voucher
     * 
     * @param Voucher $voucher
     * @return int
     */
    public function calculateRemainingTime(Voucher $voucher): int
    {
        // For free vouchers (no auto-pause), calculate based on first login time
        if (!$voucher->auto_pause && $voucher->first_login_at) {
            $elapsedSeconds = now()->diffInSeconds($voucher->first_login_at);
            return max(0, $voucher->duration_seconds - $elapsedSeconds);
        }

        // For paid vouchers (auto-pause), use the tracked remaining time
        if ($voucher->auto_pause) {
            // If currently connected, subtract current session time
            if ($voucher->last_resume_at && !$voucher->last_pause_at) {
                $currentSessionSeconds = now()->diffInSeconds($voucher->last_resume_at);
                return max(0, $voucher->remaining_seconds - $currentSessionSeconds);
            }
            return $voucher->remaining_seconds ?? 0;
        }

        return $voucher->duration_seconds;
    }

    /**
     * Check if voucher has expired
     * 
     * @param Voucher $voucher
     * @return bool
     */
    public function hasExpired(Voucher $voucher): bool
    {
        return $this->calculateRemainingTime($voucher) <= 0;
    }

    /**
     * Mark voucher as expired
     * 
     * @param Voucher $voucher
     * @return void
     */
    public function markAsExpired(Voucher $voucher): void
    {
        $voucher->update([
            'status' => 'expired',
            'remaining_seconds' => 0,
        ]);

        Log::info("Voucher {$voucher->voucher_code} marked as expired");
    }
}
