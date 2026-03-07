<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// Group route dengan middleware guest untuk menghindari user yang sudah terautentikasi mengakses route ini
Route::middleware('guest')->group(function () {
    // Register route
    // Register route index untuk menampilkan halaman register
    Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
    // Register route store untuk memproses data registrasi user
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store')->middleware('throttle:auth-protection');

    // Login route
    // Login route index untuk menampilkan halaman login
    Route::get('login', [AuthController::class, 'index'])->name('login.index');
    // Login route store untuk memproses data autentikasi user
    Route::post('/login', [AuthController::class, 'store'])->name('login.store')->middleware('throttle:auth-protection');
});
