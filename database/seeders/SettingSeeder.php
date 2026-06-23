<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'system_name', 'value' => 'ST Voucher Solution', 'group' => 'branding'],
            ['key' => 'primary_color', 'value' => '#dc2626', 'group' => 'branding'],
            ['key' => 'default_prefix', 'value' => 'ST-', 'group' => 'voucher'],
            ['key' => 'default_length', 'value' => '8', 'group' => 'voucher'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}