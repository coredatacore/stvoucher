<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('status.index');
})->name('status.index');
