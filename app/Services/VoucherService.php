<?php

namespace App\Services;

use App\Models\Voucher;
use App\Models\Plan;
use App\Models\User;
use App\Models\RouterServer;
use App\Repositories\VoucherRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class VoucherService
{
    protected VoucherRepository $voucherRepository;

    public function __construct(VoucherRepository $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }

    public function generateVoucher(Plan $plan, User $createdBy, ?int $routerServerId = null): Voucher
    {
        return DB::transaction(function () use ($plan, $createdBy, $routerServerId) {
            $code = strtoupper(Str::random(8));
            $username = $code;
            $password = Str::random(8);

            if ($routerServerId) {
                $routerServer = RouterServer::find($routerServerId);
            }
            
            if (empty($routerServer)) {
                $routerServer = RouterServer::first();
            }

            if (!$routerServer || empty($routerServer->ip_address)) {
                throw new Exception('Router Server details are not configured. Please setup the Router Server first.');
            }

            $mikrotikService = new MikroTikService($routerServer);

            // Step 1: CREATE HOTSPOT USER FIRST on MikroTik
            $tempVoucher = new Voucher([
                'username' => $username,
                'password' => $password,
            ]);

            $addResult = $mikrotikService->addHotspotUser($tempVoucher);
            $mikrotikUserId = $addResult['user_id'] ?? null;

            if (!$mikrotikUserId) {
                throw new Exception('Failed to retrieve MikroTik user ID');
            }

            // Step 2: VERIFY user exists on MikroTik
            $verifyResult = $mikrotikService->verifyHotspotUserExists($tempVoucher->username);
            if (!$verifyResult['exists']) {
                // Try to clean up the user we just created before throwing
                try {
                    $mikrotikService->removeHotspotUser($tempVoucher);
                } catch (\Exception $cleanupEx) {
                    // Ignore cleanup errors
                }
                throw new Exception('Created user not found in MikroTik');
            }

            // Step 3: NOW that MikroTik is successful, save to database!
            $voucher = $this->voucherRepository->create([
                'code' => $code,
                'username' => $username,
                'password' => $password,
                'plan_id' => $plan->id,
                'router_server_id' => $routerServerId,
                'created_by' => $createdBy->id,
                'status' => 'active', // Already active since MikroTik user is created
                'mikrotik_user_id' => $mikrotikUserId,
            ]);

            return $voucher;
        });
    }

    public function generateBulkVouchers(Plan $plan, User $createdBy, int $count, ?int $routerServerId = null): array
    {
        $vouchers = [];
        $successCount = 0;
        $lastException = null;

        for ($i = 0; $i < $count; $i++) {
            try {
                // Each voucher is in its own transaction
                $vouchers[] = $this->generateVoucher($plan, $createdBy, $routerServerId);
                $successCount++;
            } catch (\Exception $e) {
                $lastException = $e;
                // Continue to next voucher if one fails
                // We don't want to fail the entire bulk operation because of one bad voucher
            }
        }

        if ($successCount === 0 && $lastException) {
            throw $lastException;
        }

        return $vouchers;
    }
}
