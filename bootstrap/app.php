<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Panel Subdomain
            \Illuminate\Support\Facades\Route::middleware('web')
                ->domain(config('domains.panel'))
                ->group(base_path('routes/panel.php'));

            // Portal Subdomain
            \Illuminate\Support\Facades\Route::middleware('web')
                ->domain(config('domains.portal'))
                ->group(base_path('routes/portal.php'));

            // Status Subdomain
            \Illuminate\Support\Facades\Route::middleware('web')
                ->domain(config('domains.status'))
                ->group(base_path('routes/status.php'));

            // RADIUS Subdomain
            \Illuminate\Support\Facades\Route::middleware('web')
                ->domain(config('domains.radius'))
                ->group(base_path('routes/radius.php'));

            // API Subdomain Fallback (root)
            \Illuminate\Support\Facades\Route::middleware('api')
                ->domain(config('domains.api'))
                ->get('/', function () {
                    return response()->json([
                        'status' => 'online',
                        'service' => 'ST Voucher API'
                    ]);
                });
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\DomainDetector::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
