<?php

use Illuminate\Support\Facades\Route;

// Route untuk guest user
Route::get('/', function () {
    return view('pages.landing-page');
})->name('landing-page');

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


});
