<?php

namespace App\Services;

use App\Models\Voucher;
use App\Models\VoucherProfile;
use App\Models\Radcheck;
use Illuminate\Support\Str;

class VoucherService
{
    public function generateSingle(VoucherProfile $profile, string $format, ?string $prefix = null, ?int $siteId = null)
    {
        $code = $this->generateCode($format, $prefix);

        // Add to vouchers table
        $voucher = Voucher::create([
            'site_id' => $siteId,
            'voucher_code' => $code,
            'profile_id' => $profile->id,
            'status' => 'unused',
            'price' => $profile->price,
            'duration_seconds' => $profile->duration * $this->getMultiplier($profile->duration_unit),
            'generated_by' => \Illuminate\Support\Facades\Auth::user()?->name ?? 'System',
            'created_by' => \Illuminate\Support\Facades\Auth::user()?->name ?? 'System',
        ]);

        // Add to radcheck
        Radcheck::create([
            'username' => $code,
            'attribute' => 'Cleartext-Password',
            'op' => ':=',
            'value' => $code,
        ]);

        // Add session timeout to radcheck
        if ($profile->duration > 0) {
            $timeoutSeconds = $profile->duration * $this->getMultiplier($profile->duration_unit);
            Radcheck::create([
                'username' => $code,
                'attribute' => 'Max-All-Session', // Using Max-All-Session or Session-Timeout depending on FreeRADIUS config. Usually Max-All-Session for total time.
                'op' => ':=',
                'value' => $timeoutSeconds,
            ]);
        }

        return $voucher;
    }

    public function generateBulk(VoucherProfile $profile, int $quantity, string $format, ?string $prefix = null, ?int $siteId = null)
    {
        $vouchers = [];
        for ($i = 0; $i < $quantity; $i++) {
            $vouchers[] = $this->generateSingle($profile, $format, $prefix, $siteId);
        }

        return $vouchers;
    }

    protected function generateCode(string $format, ?string $prefix = null)
    {
        do {
            $code = match ($format) {
                'numeric' => random_int(10000000, 99999999),
                'alpha' => strtoupper(Str::random(8)),
                '10_chars' => strtoupper(Str::random(10)),
                default => strtoupper(Str::random(8)), // 8_chars
            };
            if ($prefix) {
                $code = $prefix . $code;
            }
        } while (Voucher::where('voucher_code', $code)->exists());

        return $code;
    }

    protected function getMultiplier(string $unit)
    {
        return match (strtolower($unit)) {
            'minutes' => 60,
            'hours' => 3600,
            'days' => 86400,
            default => 3600,
        };
    }
}