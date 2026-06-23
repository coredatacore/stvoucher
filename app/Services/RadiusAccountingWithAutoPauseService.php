<?php

namespace App\Services;

use App\Models\Radacct;
use App\Models\Voucher;
use App\Models\Radcheck;
use Illuminate\Support\Facades\Log;

/**
 * Service for handling RADIUS accounting with auto-pause functionality
 * 
 * Integrates with FreeRADIUS accounting to:
 * - Pause paid vouchers on disconnect (usage-based)
 * - Keep free vouchers running (real-time countdown)
 */
class RadiusAccountingWithAutoPauseService
{
    protected VoucherTimeTrackingService $timeTrackingService;

    public function __construct(VoucherTimeTrackingService $timeTrackingService)
    {
        $this->timeTrackingService = $timeTrackingService;
    }

    /**
     * Process RADIUS Accounting-Start packet
     * 
     * @param array $data
     * @return void
     */
    public function handleAccountingStart(array $data): void
    {
        $username = $data['username'] ?? null;
        $acctSessionId = $data['acct_session_id'] ?? null;

        if (!$username || !$acctSessionId) {
            Log::warning('Accounting-Start: Missing username or session ID', $data);
            return;
        }

        // Find voucher by code (username)
        $voucher = Voucher::where('voucher_code', $username)->first();

        if (!$voucher) {
            Log::warning("Accounting-Start: Voucher not found for username: {$username}");
            return;
        }

        // Initialize time tracking on first use
        if (!$voucher->first_login_at) {
            $this->timeTrackingService->initializeTimeTracking($voucher);
        }

        // Resume voucher (update last_resume_at)
        $this->timeTrackingService->resumeVoucher($voucher);

        // Create or update radacct record
        Radacct::updateOrCreate(
            ['acctsessionid' => $acctSessionId],
            [
                'username' => $username,
                'acctstarttime' => now(),
                'framedipaddress' => $data['framed_ip_address'] ?? null,
                'callingstationid' => $data['calling_station_id'] ?? null,
                'nasipaddress' => $data['nas_ip_address'] ?? null,
                'nasidentifier' => $data['nas_identifier'] ?? null,
            ]
        );

        Log::info("Accounting-Start processed for voucher: {$username}, session: {$acctSessionId}");
    }

    /**
     * Process RADIUS Accounting-Stop packet
     * 
     * @param array $data
     * @return void
     */
    public function handleAccountingStop(array $data): void
    {
        $username = $data['username'] ?? null;
        $acctSessionId = $data['acct_session_id'] ?? null;

        if (!$username || !$acctSessionId) {
            Log::warning('Accounting-Stop: Missing username or session ID', $data);
            return;
        }

        // Find voucher by code
        $voucher = Voucher::where('voucher_code', $username)->first();

        if (!$voucher) {
            Log::warning("Accounting-Stop: Voucher not found for username: {$username}");
        } else {
            // Pause voucher (apply auto-pause logic based on price)
            $this->timeTrackingService->pauseVoucher($voucher);

            // Check if voucher has expired
            if ($this->timeTrackingService->hasExpired($voucher)) {
                $this->timeTrackingService->markAsExpired($voucher);
                
                // Optionally disable the voucher in radcheck
                $this->disableVoucherInRadius($username);
            }
        }

        // Update radacct record
        $radacct = Radacct::where('acctsessionid', $acctSessionId)->first();
        
        if ($radacct) {
            $acctStartTime = $radacct->acctstarttime;
            $acctStopTime = now();
            $sessionTime = $acctStopTime->diffInSeconds($acctStartTime);

            $radacct->update([
                'acctstoptime' => $acctStopTime,
                'acctsessiontime' => $sessionTime,
                'acctterminatecause' => $data['acct_terminate_cause'] ?? 'User-Request',
            ]);
        }

        Log::info("Accounting-Stop processed for voucher: {$username}, session: {$acctSessionId}");
    }

    /**
     * Process RADIUS Accounting-Update (Interim-Update) packet
     * 
     * @param array $data
     * @return void
     */
    public function handleAccountingUpdate(array $data): void
    {
        $username = $data['username'] ?? null;
        $acctSessionId = $data['acct_session_id'] ?? null;

        if (!$username || !$acctSessionId) {
            return;
        }

        // Find voucher
        $voucher = Voucher::where('voucher_code', $username)->first();

        if (!$voucher) {
            return;
        }

        // For auto-pause vouchers, check remaining time
        if ($voucher->auto_pause) {
            $remainingTime = $this->timeTrackingService->calculateRemainingTime($voucher);
            
            if ($remainingTime <= 0) {
                // Voucher has expired during this session
                $this->timeTrackingService->markAsExpired($voucher);
                $this->disableVoucherInRadius($username);
                
                // Note: The NAS should send Accounting-Stop after CoA Disconnect
            }
        }

        // Update radacct with current stats
        $radacct = Radacct::where('acctsessionid', $acctSessionId)->first();
        
        if ($radacct) {
            $acctStartTime = $radacct->acctstarttime;
            $sessionTime = now()->diffInSeconds($acctStartTime);

            $radacct->update([
                'acctsessiontime' => $sessionTime,
            ]);
        }

        Log::debug("Accounting-Update processed for voucher: {$username}");
    }

    /**
     * Disable voucher in RADIUS (radcheck)
     * 
     * @param string $username
     * @return void
     */
    private function disableVoucherInRadius(string $username): void
    {
        // Remove or disable the user in radcheck
        // This prevents further authentication
        Radcheck::where('username', $username)->delete();
        
        Log::info("Voucher {$username} disabled in RADIUS");
    }

    /**
     * Get session time remaining for a connected user
     * Used for Session-Timeout attribute in Access-Accept
     * 
     * @param string $username
     * @return int|null
     */
    public function getSessionTimeout(string $username): ?int
    {
        $voucher = Voucher::where('voucher_code', $username)->first();

        if (!$voucher || $voucher->status !== 'active') {
            return null;
        }

        $remainingTime = $this->timeTrackingService->calculateRemainingTime($voucher);
        
        return max(0, $remainingTime);
    }
}
