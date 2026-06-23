<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptivePortalController;

Route::get('/host-test', function () {
    return [
        'host' => request()->getHost(),
        'route' => request()->route()?->getName(),
        'url' => request()->fullUrl(),
    ];
});

// Captive Portal
Route::get('/', [CaptivePortalController::class, 'index'])->name('portal.index');
Route::post('/authenticate', [CaptivePortalController::class, 'authenticate'])->name('portal.authenticate');
Route::get('/success', [CaptivePortalController::class, 'success'])->name('portal.success');
