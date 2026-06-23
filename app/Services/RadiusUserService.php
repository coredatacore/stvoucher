<?php

namespace App\Services;

use App\Models\Radcheck;
use App\Models\Voucher;

class RadiusUserService
{
    public function suspendUser(string $username)
    {
        // Remove Cleartext-Password or change it to prevent login
        Radcheck::where('username', $username)->where('attribute', 'Cleartext-Password')->update(['value' => 'suspended']);
        Voucher::where('voucher_code', $username)->update(['status' => 'suspended']);
    }

    public function resumeUser(string $username)
    {
        Radcheck::where('username', $username)->where('attribute', 'Cleartext-Password')->update(['value' => $username]);
        Voucher::where('voucher_code', $username)->update(['status' => 'active']);
    }

    public function deleteUser(string $username)
    {
        Radcheck::where('username', $username)->delete();
        Voucher::where('voucher_code', $username)->delete();
    }
}