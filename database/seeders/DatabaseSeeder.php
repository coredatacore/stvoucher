<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Plan;
use App\Models\RouterServer;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $superAdminRole = Role::create([
            'name' => 'super_admin',
            'description' => 'Super Administrator with full access',
        ]);

        $staffRole = Role::create([
            'name' => 'staff',
            'description' => 'Staff member with limited access',
        ]);

        $cashierRole = Role::create([
            'name' => 'cashier',
            'description' => 'Cashier with voucher creation access',
        ]);

        // Create admin user
        $adminUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'mantabuelog@gmail.com',
            'password' => Hash::make('@Admin_Datacore_1616'),
            'role_id' => $superAdminRole->id,
        ]);

        // Create plans
        Plan::create([
            'name' => '1 Hour',
            'description' => '1 hour of internet access',
            'price' => 20.00,
            'duration_minutes' => 60,
            'duration_days' => null,
            'data_limit_mb' => null,
            'download_speed_mbps' => null,
            'upload_speed_mbps' => null,
            'is_active' => true,
        ]);

        Plan::create([
            'name' => '3 Hours',
            'description' => '3 hours of internet access',
            'price' => 50.00,
            'duration_minutes' => 180,
            'duration_days' => null,
            'data_limit_mb' => null,
            'download_speed_mbps' => null,
            'upload_speed_mbps' => null,
            'is_active' => true,
        ]);

        Plan::create([
            'name' => '1 Day',
            'description' => '1 day of internet access',
            'price' => 100.00,
            'duration_minutes' => 1440,
            'duration_days' => null,
            'data_limit_mb' => null,
            'download_speed_mbps' => null,
            'upload_speed_mbps' => null,
            'is_active' => true,
        ]);

        Plan::create([
            'name' => '3 Days',
            'description' => '3 days of internet access',
            'price' => 250.00,
            'duration_minutes' => null,
            'duration_days' => 3,
            'data_limit_mb' => null,
            'download_speed_mbps' => null,
            'upload_speed_mbps' => null,
            'is_active' => true,
        ]);

        Plan::create([
            'name' => '7 Days',
            'description' => '7 days of internet access',
            'price' => 200.00,
            'duration_minutes' => null,
            'duration_days' => 7,
            'data_limit_mb' => null,
            'download_speed_mbps' => null,
            'upload_speed_mbps' => null,
            'is_active' => true,
        ]);

        Plan::create([
            'name' => '30 Days',
            'description' => '30 days of internet access',
            'price' => 500.00,
            'duration_minutes' => null,
            'duration_days' => 30,
            'data_limit_mb' => null,
            'download_speed_mbps' => null,
            'upload_speed_mbps' => null,
            'is_active' => true,
        ]);

        // Create default router server
        RouterServer::create([
            'name' => 'Main Router',
            'ip_address' => '192.168.88.1',
            'api_port' => 8728,
            'api_username' => 'datacore',
            'api_password' => 'datacore123',
            'is_active' => true,
        ]);

        // Create system settings
        SystemSetting::create([
            'key' => 'site_name',
            'value' => 'DataCore WiFi Manager',
            'type' => 'string',
            'description' => 'Name of the site',
        ]);

        SystemSetting::create([
            'key' => 'default_router_server_id',
            'value' => '1',
            'type' => 'integer',
            'description' => 'Default router server to use',
        ]);
    }
}
