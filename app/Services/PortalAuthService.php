<?php

namespace App\Services;

use App\Models\Voucher;

class PortalAuthService
{
    public function validateVoucher(string $code)
    {
        $voucher = Voucher::where('voucher_code', $code)->first();

        if (!$voucher) {
            return ['status' => 'error', 'message' => 'Invalid voucher code'];
        }

        if ($voucher->status === 'expired') {
            return ['status' => 'error', 'message' => 'Voucher is expired'];
        }

        if ($voucher->status === 'suspended') {
            return ['status' => 'error', 'message' => 'Voucher is suspended'];
        }

        return ['status' => 'success', 'voucher' => $voucher];
    }
}