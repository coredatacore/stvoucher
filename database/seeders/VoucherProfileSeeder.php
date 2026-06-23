<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VoucherProfile;

class VoucherProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            ['profile_name' => '₱1 - 10 Minutes', 'price' => 1.00, 'duration' => 10, 'duration_unit' => 'Minutes'],
            ['profile_name' => '₱5 - 2 Hours', 'price' => 5.00, 'duration' => 2, 'duration_unit' => 'Hours'],
            ['profile_name' => '₱10 - 5 Hours', 'price' => 10.00, 'duration' => 5, 'duration_unit' => 'Hours'],
            ['profile_name' => '₱30 - 24 Hours', 'price' => 30.00, 'duration' => 24, 'duration_unit' => 'Hours'],
            ['profile_name' => '₱300 - 30 Days', 'price' => 300.00, 'duration' => 30, 'duration_unit' => 'Days'],
        ];

        foreach ($profiles as $profile) {
            VoucherProfile::create($profile);
        }
    }
}