<?php

namespace App\Http\Controllers;

use App\Models\RouterServer;
use App\Models\Voucher;
use App\Services\MikroTikService;
use Illuminate\Http\Request;
use Exception;

class MikrotikController extends Controller
{
    public function testConnection()
    {
        try {
            $routerServer = \App\Models\RouterServer::first();
            
            if (!$routerServer || empty($routerServer->ip_address)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Router Server details are not configured in settings.'
                ], 400);
            }

            $mikrotikService = new MikroTikService($routerServer);

            if (!$mikrotikService->connect()) {
                return view('mikrotik.test-connection', [
                    'connected' => false,
                    'error' => 'Failed to connect to MikroTik',
                ]);
            }

            $identity = $mikrotikService->getIdentity();
            $version = $mikrotikService->getVersion();
            $userCount = $mikrotikService->getHotspotUserCount();

            $mikrotikService->disconnect();

            return view('mikrotik.test-connection', [
                'connected' => true,
                'identity' => $identity,
                'version' => $version,
                'userCount' => $userCount,
            ]);
        } catch (Exception $e) {
            return view('mikrotik.test-connection', [
                'connected' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function testVoucher()
    {
        return view('mikrotik.test-voucher');
    }

    public function executeTestVoucher()
    {
        try {
            $routerServer = \App\Models\RouterServer::first();
            
            if (!$routerServer || empty($routerServer->ip_address)) {
                return redirect()->route('mikrotik.test-voucher')->with('error', 'Router Server details are not configured in settings.');
            }

            $mikrotikService = new MikroTikService($routerServer);

            if (!$mikrotikService->connect()) {
                return redirect()->route('mikrotik.test-voucher')->with('error', 'Failed to connect to MikroTik');
            }

            // Create a test voucher object (not stored in DB)
            $testVoucher = new Voucher([
                'username' => 'test_api_001',
                'password' => 'test123',
            ]);

            // Step 1: Add user
            $addResult = $mikrotikService->addHotspotUser($testVoucher);

            // Step 2: Verify user exists
            $verifyResult = $mikrotikService->verifyHotspotUserExists($testVoucher->username);

            $mikrotikService->disconnect();

            return view('mikrotik.test-voucher', [
                'success' => true,
                'addResult' => $addResult,
                'verifyResult' => $verifyResult,
            ]);
        } catch (Exception $e) {
            return view('mikrotik.test-voucher', [
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
