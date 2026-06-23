<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemUser;
use Illuminate\Support\Facades\Hash;

class SystemUserSeeder extends Seeder
{
    public function run(): void
    {
        SystemUser::create([
            'name' => 'Super Admin',
            'email' => 'admin@stvoucher.local',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
        ]);
    }
}