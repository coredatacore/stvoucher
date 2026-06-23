<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;

class DomainDetector
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $module = 'unknown';

        if ($host === config('domains.panel')) {
            $module = 'panel';
        } elseif ($host === config('domains.api')) {
            $module = 'api';
        } elseif ($host === config('domains.portal')) {
            $module = 'portal';
        } elseif ($host === config('domains.status')) {
            $module = 'status';
        } elseif ($host === config('domains.radius')) {
            $module = 'radius';
        }

        // Share the active module globally with all views
        View::share('active_module', $module);

        // Also add it to the request so controllers can access it easily if needed
        $request->attributes->add(['active_module' => $module]);

        return $next($request);
    }
}