<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptivePortalController;

// Captive Portal
Route::get('/', [CaptivePortalController::class, 'index'])->name('portal.index');
Route::post('/authenticate', [CaptivePortalController::class, 'authenticate'])->name('portal.authenticate');
Route::get('/success', [CaptivePortalController::class, 'success'])->name('portal.success');
