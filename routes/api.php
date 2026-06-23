<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VoucherApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/v1/vouchers/generate', [VoucherApiController::class, 'generate']);
    Route::post('/v1/vouchers/bulk', [VoucherApiController::class, 'bulkGenerate']);
    Route::post('/v1/vouchers/validate', [VoucherApiController::class, 'validateVoucher']);
    Route::get('/v1/vouchers/{code}/status', [VoucherApiController::class, 'status']);
    Route::get('/v1/sessions/active', [VoucherApiController::class, 'activeSessions']);
    Route::get('/v1/dashboard/stats', [VoucherApiController::class, 'dashboardStats']);
});