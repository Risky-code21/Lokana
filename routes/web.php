<?php

use Illuminate\Support\Facades\Route;

// Landing page (1 route saja, jangan dobel)
Route::get('/', function () {
    $stats = [
        'umkm' => '100+',
        'products' => '500+',
        'happy' => '1000+',
        'rating' => '5',
    ];

    $products = collect(range(1, 6))->map(fn($i) => [
        'image' => asset('images/product-'.$i.'.jpg'),
        'category' => 'HandCraft',
        'title' => "Bali’s Art #$i",
        'seller' => 'Pande Jagatama',
        'count' => 37,
        'desc' => 'Produk lokal khas Bali yang dibuat oleh UMKM dengan kualitas terbaik.',
        'rating' => '5.0',
        'url' => '#',
    ])->toArray();

    $works = collect(range(1, 6))->map(fn($i) => [
        'image' => asset('images/work-'.$i.'.jpg'),
        'title' => 'Arjuna Mask',
        'desc' => 'Topeng tradisional Bali yang dibuat secara handmade oleh pengrajin lokal.',
        'price' => 'Rp. 300.000',
        'url' => '#',
    ])->toArray();

    $articles = collect(range(1, 3))->map(fn($i) => [
        'image' => asset('images/article-'.$i.'.jpg'),
        'title' => 'Article Name',
        'excerpt' => 'Cerita singkat tentang UMKM lokal dan produk-produk tradisional Bali.',
        'url' => '#',
    ])->toArray();

    return view('pages.landing-page', compact('stats', 'products', 'works', 'articles'));
})->name('landing-page');


// Profile page
Route::get('/profile', function () {
    // dummy data (nanti bisa diganti dari DB)
    $user = [
        'name' => 'Yayayaahaha',
        'role' => 'Owner MSME',
        'location' => 'Jln. Kartini',
        'joined' => '19 Januari 2025',
        'avatar' => asset('images/avatar.jpg'),      // siapkan gambarnya (atau ganti)
        'cover'  => asset('images/cover.jpg'),       // siapkan gambarnya (atau ganti)
        'completion' => 50,
    ];

    return view('pages.profile-page', compact('user'));
})->name('profile');
