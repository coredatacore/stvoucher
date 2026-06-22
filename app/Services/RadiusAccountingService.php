<?php

namespace App\Services;

use App\Models\Radacct;

class RadiusAccountingService
{
    public function getActiveSessions()
    {
        return Radacct::whereNull('acctstoptime')->orderBy('acctstarttime', 'desc')->get();
    }

    public function disconnectUser(string $username)
    {
        // CoA logic goes here if configured
        // For now, we simulate marking them stopped if CoA is not fully setup
        return ['status' => 'error', 'message' => 'CoA not configured'];
    }
}