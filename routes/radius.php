<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('radius.index');
})->name('radius.index');
