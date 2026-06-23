<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RadiusAccountingService;
use App\Services\RadiusUserService;

class SessionController extends Controller
{
    public function index(RadiusAccountingService $accountingService)
    {
        $sessions = $accountingService->getActiveSessions();
        return view('admin.sessions.index', compact('sessions'));
    }

    public function disconnect(string $username, RadiusAccountingService $accountingService, RadiusUserService $userService)
    {
        $result = $accountingService->disconnectUser($username);
        
        if ($result['status'] === 'error') {
            return back()->with('error', $result['message']);
        }
        
        return back()->with('success', 'User disconnected successfully.');
    }
}