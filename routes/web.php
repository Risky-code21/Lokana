<?php

use Illuminate\Support\Facades\Route;

// Route untuk guest user
Route::get('/', function () {
    return view('pages.landing-page');
})->name('landing-page');
