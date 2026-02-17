<?php

use App\Http\Controllers\Admin\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PelakuUmkmController;
use App\Http\Controllers\Admin\CategoryUmkmController;
use App\Http\Controllers\Admin\UmkmProfileController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\CategoryArticleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;

<<<<<<< HEAD
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
=======

>>>>>>> 2b535ce (feat: subplan & subscription)
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

    // ================= SUBSCRIPTION PLANS =================
    Route::prefix('subscription-plans')->name('subscription-plans.')->group(function () {
        Route::get('/', [SubscriptionPlanController::class, 'index'])->name('index');
        Route::get('/create', [SubscriptionPlanController::class, 'create'])->name('create');
        Route::post('/', [SubscriptionPlanController::class, 'store'])->name('store');
        Route::get('/{subscriptionPlan}/edit', [SubscriptionPlanController::class, 'edit'])->name('edit');
        Route::put('/{subscriptionPlan}', [SubscriptionPlanController::class, 'update'])->name('update');
        Route::get('/{subscriptionPlan}', [SubscriptionPlanController::class, 'show'])->name('show');
        Route::delete('/{subscriptionPlan}', [SubscriptionPlanController::class, 'destroy'])->name('destroy');
    });

    // ================= SUBSCRIPTIONS =================
    Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('index');
        Route::get('/{subscription}', [SubscriptionController::class, 'show'])->name('show');
        Route::put('/{subscription}/verify', [SubscriptionController::class, 'verify'])->name('verify');
        Route::delete('/{subscription}', [SubscriptionController::class, 'destroy'])->name('destroy');
    });

    Route::get('/msme-products', function () {
        return "MSME Products - Coming Soon";
    })->name('msme-products.index');
    
    Route::get('/articles', function () {
        return "Articles - Coming Soon";
    })->name('articles.index');
    
    // ================= ARTICLE CATEGORIES =================
    Route::prefix('article-categories')->name('article-categories.')->group(function () {
        Route::get('/', [CategoryArticleController::class, 'index'])->name('index');
        Route::get('/create', [CategoryArticleController::class, 'create'])->name('create');
        Route::post('/', [CategoryArticleController::class, 'store'])->name('store');
        Route::get('/{category_article}', [CategoryArticleController::class, 'show'])->name('show');
        Route::get('/{category_article}/edit', [CategoryArticleController::class, 'edit'])->name('edit');
        Route::put('/{category_article}', [CategoryArticleController::class, 'update'])->name('update');
        Route::delete('/{category_article}', [CategoryArticleController::class, 'destroy'])->name('destroy');
        
        // Bulk delete
        Route::post('/bulk-destroy', [CategoryArticleController::class, 'bulkDestroy'])->name('bulk-destroy');
        
        // For select dropdown
        Route::get('/select-options', [CategoryArticleController::class, 'getCategories'])->name('select-options');
    });
    
    Route::get('/reports', function () {
        return "Reports - Coming Soon";
    })->name('reports.index');
    
    // ================= SETTINGS =================
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('/profile', [SettingsController::class, 'updateProfile'])->name('profile');
        Route::post('/password', [SettingsController::class, 'updatePassword'])->name('password');
    });
    
    // ================= USERS MANAGEMENT =================
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        
        // Bulk delete
        Route::post('/bulk-destroy', [UserController::class, 'bulkDestroy'])->name('bulk-destroy');
    });
    
});
>>>>>>> 4e89da7 (feat: artisan, msme category)
