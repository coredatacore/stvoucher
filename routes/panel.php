<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptivePortalController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\VoucherProfileController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\NasController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\InstallController;

// Installer
Route::prefix('install')->name('install.')->group(function () {
    Route::get('/', [InstallController::class, 'index'])->name('index');
    Route::post('/step/{step}', [InstallController::class, 'process'])->name('process');
});

// Admin Auth Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function () {
    return view('admin.login');
})->name('login');
Route::post('/login', [CaptivePortalController::class, 'adminLogin'])->name('admin.login.submit');
Route::post('/logout', [CaptivePortalController::class, 'adminLogout'])->name('logout');

// Admin Protected Routes
Route::middleware('auth')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('sites', SiteController::class);

    Route::get('vouchers/print', [VoucherController::class, 'print'])->name('vouchers.print');
    Route::post('vouchers/bulk', [VoucherController::class, 'bulk'])->name('vouchers.bulk');
    Route::resource('vouchers', VoucherController::class);
    
    Route::resource('profiles', VoucherProfileController::class);
    
    Route::get('sessions', [SessionController::class, 'index'])->name('sessions.index');
    Route::post('sessions/{username}/disconnect', [SessionController::class, 'disconnect'])->name('sessions.disconnect');
    
    Route::get('logs/accounting', [LogController::class, 'accounting'])->name('logs.accounting');
    Route::get('logs/auth', [LogController::class, 'auth'])->name('logs.auth');
    
    Route::resource('nas', NasController::class);
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
});
