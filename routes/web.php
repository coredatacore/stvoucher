<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;

// Installer (Available on main domain)
Route::prefix('install')->name('install.')->group(function () {
    Route::get('/', [InstallController::class, 'index'])->name('index');
    Route::post('/step/{step}', [InstallController::class, 'process'])->name('process');
});

Route::get('/', function () {
    return redirect()->away('https://' . config('domains.panel'));
});
