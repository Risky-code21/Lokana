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


// FAQ page
Route::get('/faq', function () {
    $faqs = [
        'General Question' => [
            [
                'q' => 'What is Lokana',
                'a' => 'Lokana is a digital platform focused on empowering Balinese MSMEs and artisans by showcasing the stories, cultural values, and creative processes behind each handcrafted product. Through a storytelling-driven approach, Lokana helps local creators introduce their works to the global market in an authentic and sustainable way. The platform not only serves as a promotional medium, but also as a cultural bridge that offers consumers a more meaningful experience by connecting Balinese heritage, craftsmanship, and contemporary market demands.',
            ],
            ['q' => 'How does Lokana work?', 'a' => 'You can explore products, read stories, connect with artisans, and place orders directly through the platform.'],
            ['q' => 'Is Lokana free to use?', 'a' => 'Yes, browsing stories and products is free. Certain features may require an account.'],
            ['q' => 'How to become an UMKM partner?', 'a' => 'Register as UMKM, complete profile, and submit your product listing.'],
        ],
        'Ordering & payment' => [
            ['q' => 'How to place an order?', 'a' => 'Choose a product, click order, and follow the checkout instructions.'],
            ['q' => 'What payment methods are available?', 'a' => 'Bank transfer, e-wallet, and other available payment gateways (depending on your integration).'],
            ['q' => 'Can I cancel an order?', 'a' => 'You can cancel before the seller confirms. After confirmation, follow the return policy.'],
            ['q' => 'How long does shipping take?', 'a' => 'Shipping time depends on location and courier. Estimated time will appear at checkout.'],
        ],
        'For artisans' => [
            ['q' => 'How to join as an artisan?', 'a' => 'Sign up, complete artisan profile, and upload your products with photos and descriptions.'],
            ['q' => 'How do I get featured?', 'a' => 'Maintain good ratings, complete profile, and consistently upload high-quality products.'],
            ['q' => 'Do you charge platform fees?', 'a' => 'Platform fees depend on partnership plan. You can contact us for details.'],
            ['q' => 'Can I tell my story?', 'a' => 'Yes, you can publish stories/articles to help customers understand your craftsmanship.'],
        ],
    ];

    return view('pages.faq-page', compact('faqs'));
})->name('faq.page');
