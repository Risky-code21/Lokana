<?php

use App\Http\Controllers\Admin\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PelakuUmkmController;
use App\Http\Controllers\Admin\CategoryUmkmController;

<<<<<<< HEAD
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
=======
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('pages.admin.dashboard');
    })->name('dashboard');
    
    // ================= PELAKU UMKM =================
    Route::prefix('pelaku-umkm')->name('pelaku-umkm.')->group(function () {
        Route::get('/', [PelakuUmkmController::class, 'index'])->name('index');
        Route::get('/stats', [PelakuUmkmController::class, 'getStats'])->name('stats');
        Route::get('/create', [PelakuUmkmController::class, 'create'])->name('create');
        Route::post('/', [PelakuUmkmController::class, 'store'])->name('store');
        Route::get('/{pelaku_umkm}', [PelakuUmkmController::class, 'show'])->name('show');
        Route::get('/{pelaku_umkm}/edit', [PelakuUmkmController::class, 'edit'])->name('edit');
        Route::put('/{pelaku_umkm}', [PelakuUmkmController::class, 'update'])->name('update');
        Route::delete('/{pelaku_umkm}', [PelakuUmkmController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-destroy', [PelakuUmkmController::class, 'bulkDestroy'])->name('bulk-destroy');
    });
    // ================= CATEGORY UMKM =================
    Route::prefix('category-umkm')->name('category-umkm.')->group(function () {
        Route::get('/', [CategoryUmkmController::class, 'index'])->name('index');
        Route::get('/create', [CategoryUmkmController::class, 'create'])->name('create');
        Route::post('/', [CategoryUmkmController::class, 'store'])->name('store');
        Route::get('/{category_umkm}', [CategoryUmkmController::class, 'show'])->name('show');
        Route::get('/{category_umkm}/edit', [CategoryUmkmController::class, 'edit'])->name('edit');
        Route::put('/{category_umkm}', [CategoryUmkmController::class, 'update'])->name('update');
        Route::delete('/{category_umkm}', [CategoryUmkmController::class, 'destroy'])->name('destroy');
        
        // Bulk delete
        Route::post('/bulk-destroy', [CategoryUmkmController::class, 'bulkDestroy'])->name('bulk-destroy');
        
        // For select dropdown
        Route::get('/select-options', [CategoryUmkmController::class, 'getCategories'])->name('select-options');
    });
    
    // Tambahkan di dalam Route::prefix('admin') group


// Tambahkan di dalam Route::prefix('admin') group

    // ================= UMKM PROFILES =================
    Route::prefix('umkm-profiles')->name('umkm-profiles.')->group(function () {
        Route::get('/', [UmkmProfileController::class, 'index'])->name('index');
        Route::get('/create', [UmkmProfileController::class, 'create'])->name('create');
        Route::post('/', [UmkmProfileController::class, 'store'])->name('store');
        Route::get('/{umkmProfile}', [UmkmProfileController::class, 'show'])->name('show');
        Route::get('/{umkmProfile}/edit', [UmkmProfileController::class, 'edit'])->name('edit');
        Route::put('/{umkmProfile}', [UmkmProfileController::class, 'update'])->name('update');
        Route::delete('/{umkmProfile}', [UmkmProfileController::class, 'destroy'])->name('destroy');
        
        // Bulk delete
        Route::post('/bulk-destroy', [UmkmProfileController::class, 'bulkDestroy'])->name('bulk-destroy');
        
        // For select dropdown
        Route::get('/select-options', [UmkmProfileController::class, 'getProfiles'])->name('select-options');
    });

    Route::get('/msme-products', function () {
        return "MSME Products - Coming Soon";
    })->name('msme-products.index');
    
    Route::get('/articles', function () {
        return "Articles - Coming Soon";
    })->name('articles.index');
    
    Route::get('/article-categories', function () {
        return "Article Categories - Coming Soon";
    })->name('article-categories.index');
    
    Route::get('/reports', function () {
        return "Reports - Coming Soon";
    })->name('reports.index');
    
    Route::get('/settings', function () {
        return "Settings - Coming Soon";
    })->name('settings.index');
    
    Route::get('/users', function () {
        return "Users Management - Coming Soon";
    })->name('users.index');
    
});
>>>>>>> 4e89da7 (feat: artisan, msme category)
