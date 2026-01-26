<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('')->group(function () {
    // Register route
    Route::get('register', [RegisterController::class, 'index'])->name('register.index');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    // Login route
    Route::get('login', [AuthController::class, 'index'])->name('login.index');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});
