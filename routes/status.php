<?php

use Illuminate\Support\Facades\Route;

Route::get('/host-test', function () {
    return [
        'host' => request()->getHost(),
        'route' => request()->route()?->getName(),
        'url' => request()->fullUrl(),
    ];
});

Route::get('/', function () {
    return view('status.index');
})->name('status.index');
