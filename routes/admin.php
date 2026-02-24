<?php

use App\Http\Controllers\Admin\ArticleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'checkrole:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.admin.dashboard');
    })->name('index');
});

// Route group untuk management articles di sisi admin
Route::middleware(['auth', 'checkrole:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Menggunakan Resource Controller untuk CRUD Otomatis
    // Menghasilkan: index, create, store, show, edit, update, destroy
    Route::resource('articles', ArticleController::class)->parameters([
        'articles' => 'article:slug' // Menggunakan slug sebagai pengenal di URL
    ]);

    // API Khusus Editor (Tetap di dalam grup  agar aman)
    Route::post('articles/upload-media', [ArticleController::class, 'uploadFromEditor'])
        ->name('articles.upload_media');
});
