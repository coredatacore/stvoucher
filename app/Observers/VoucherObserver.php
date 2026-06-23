<?php

namespace App\Observers;

use App\Models\Voucher;
use App\Services\VoucherTimeTrackingService;
use Illuminate\Support\Facades\Log;

class VoucherObserver
{
    protected VoucherTimeTrackingService $timeTrackingService;

    public function __construct(VoucherTimeTrackingService $timeTrackingService)
    {
        $this->timeTrackingService = $timeTrackingService;
    }

    /**
     * Handle the Voucher "creating" event.
     * Auto-set auto_pause based on price before creating
     */
    public function creating(Voucher $voucher): void
    {
        // Auto-set auto_pause based on price
        $price = (float) $voucher->price;

        // Only set auto_pause if the column exists (migration has been run)
        // This allows vouchers to be created before migration
        try {
            $voucher->auto_pause = $this->timeTrackingService->shouldAutoPause($price);
        } catch (\Exception $e) {
            // Column doesn't exist yet, skip setting auto_pause
            // Log this for debugging
            Log::debug("auto_pause column not available yet for voucher: " . $e->getMessage());
        }
    }

    /**
     * Handle the Voucher "updating" event.
     * Update auto_pause if price changes
     */
    public function updating(Voucher $voucher): void
    {
        // If price is being updated, recalculate auto_pause
        if ($voucher->isDirty('price')) {
            $price = (float) $voucher->price;
            $voucher->auto_pause = $this->timeTrackingService->shouldAutoPause($price);
        }
    }

    /**
     * Handle the Voucher "created" event.
     */
    public function created(Voucher $voucher): void
    {
        // Log the creation with auto_pause status
        $pauseType = $voucher->auto_pause ? 'auto-pause (paid)' : 'continuous (free)';
        Log::info("Voucher {$voucher->voucher_code} created with {$pauseType}, price: {$voucher->price}");
    }
}
