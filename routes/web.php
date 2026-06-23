<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;

// Panel Subdomain
Route::domain(config('domains.panel'))->group(base_path('routes/panel.php'));

// Portal Subdomain
Route::domain(config('domains.portal'))->group(base_path('routes/portal.php'));

// Status Subdomain
Route::domain(config('domains.status'))->group(base_path('routes/status.php'));

// RADIUS Subdomain
Route::domain(config('domains.radius'))->group(base_path('routes/radius.php'));

// Installer (Available on main domain fallback)
Route::prefix('install')->name('install.')->group(function () {
    Route::get('/', [InstallController::class, 'index'])->name('index');
    Route::post('/step/{step}', [InstallController::class, 'process'])->name('process');
});

Route::get('/host-test', function () {
    return [
        'host' => request()->getHost(),
        'route' => request()->route()?->getName(),
        'url' => request()->fullUrl(),
    ];
});

Route::fallback(function () {
    return redirect()->away('https://' . config('domains.panel'));
});