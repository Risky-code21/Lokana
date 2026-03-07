<?php

use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\LikeController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\LandingPageController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/',  [LandingPageController::class, 'index'])->name('landing-page');

// Route untuk faq page
// Tidak di group secara khusus karena tidak memiliki fitur khusus seperti artikel, komentar, dll. Jadi cukup satu route saja untuk menampilkan halaman FAQ statis.
Route::get('/faq', function () {
    return view('pages.user.faq.faq-page');
})->name('faq.index');

// Route untuk menu article
// Menggunakan group route, agar lebih terorganisir dengan baik
// Digroup bedasarkan prefix, name, dan controller
Route::controller(ArticleController::class)->prefix('articles')->name('articles.')->group(function () {
    // Halaman Lutama artikel
    Route::get('/', 'index')->name('index');

    // Halaman Detail artikel (menggunakan Slug)
    Route::get('/{slug}', 'show')->name('show');
});

// Route untuk fitur komentar
// Pengguna yang ingin berkomentar atau mereply suatu komentar harus lah pengguna yang sudah terautentikas
// Menggunakan group route, agar route perfitur lebih terorganisir dengan baik
// Digroup bedasarkan middleware, prefix, name, dan controller dari fitur
Route::middleware(['auth', 'checkrole:user'])->prefix('comments')->name('comments.')->controller(CommentController::class)->group(function () {

    // Upload komentar
    Route::post('/{type}/{slug}', 'store')
        ->name('store');

    // Update komentar
    Route::put('/{comment}', 'update')
        ->name('update');

    // Delete Komentar
    Route::delete('/{comment}', 'destroy')
        ->name('destroy');
});

// Route untuk fitur like 
// Pengguna yang ingin meemberikan like harus login terlebih dahulu
// Menggunakan group route, agar route perfitur lebih terorganisir dengan baik
// Digroup bedasarkan middleware, prefix, name, dan controller dari fitur
Route::middleware(['auth', 'checkrole:user'])->prefix('likes')->name('likes.')->controller(LikeController::class)->group(function () {

    Route::post('/{type}/{slug}', 'toggle')
        ->name('toggle');
});


// Route untuk fitur profile user
// Pengguna yang ingin mengakses halaman profile harus login terlebih dahulu
// Menggunakan group route, agar route perfitur lebih terorganisir dengan baik
// Digroup bedasarkan middleware, prefix, name, dan controller dari fitur
Route::middleware(['auth', 'checkrole:user'])->prefix('profiles')->name('profiles.')->controller(ProfileController::class)->group(function () {

    Route::get('/', 'index')->name('index');

    Route::patch('/identity', 'updateIdentity')->name('update.identity');

    Route::put('/security', 'updateSecurity')->name('update.security');

    Route::delete('/delete-account', 'destroy')->name('delete.account');
});

// Testing fitur admin versi cepat
// Untuk sekarang ini hanya untuk testing CRUD saja
Route::get('/testing', [ArticleController::class, 'create'])->name('testing');

// Explore UMKM page
Route::get('/explore-umkm', function () {

    $categories = [
        'All products',
        'Culinary',
        'Mask',
        'Art tools',
        'Handcraft',
    ];

    // dummy produk
    $items = collect(range(1, 5))->map(function ($i) {
        $title =
            $i === 2 ? "Bali’s Craft Center" : ($i === 5 ? "Bali’s Arjuna’s mask" : "Bali’s Statue Carving");

        // slug sederhana dari title
        $slug = str($title)->lower()->replace(['’', '\'', '’s'], ['', '', ''])->replace('  ', ' ')->replace(' ', '-');

        return [
            'badge' => 'HandCraft',
            'image' => asset('images/explore-' . $i . '.jpg'), // siapin gambarnya
            'rating' => '4.9',
            'reviews' => '59 reviews',
            'title' => $title,
            'products' => '38 Products',
            'views' => '6.2k views',
            'desc' => "At Bali’s Craft, we believe that greatness starts from small, meaningful steps. Established in [Tahun Berdiri], we are a local.",
            'author' => 'Pande Sujana',

            // View Detail sekarang ngarah ke profile UMKM
            'url' => route('profile-umkm-page', ['slug' => $slug]),
        ];
    })->toArray();

    // dummy pagination state
    $page = (int) request('page', 1);

    return view('pages.explore-umkm-page', compact('categories', 'items', 'page'));
})->name('explore.umkm');


// Profile UMKM page (STATIC)
Route::get('/profile-umkm-page', function () {

    // dummy data (nanti bisa diganti DB)
    $umkm = [
        'badge' => 'HandCraft',
        'name' => "Bali’s Craft",
        'product_count' => '38 Product',
        'rating' => '4.9',
        'reviews' => '59 reviews',
        'owner' => 'Pande Sujana',
        'owner_role' => 'MSME owner',
        'avatar' => asset('images/avatar.jpg'),
        'cover' => asset('images/explore-2.jpg'),
        'desc' => "Balinese carving is a traditional art unique to Bali that features fine details and culturally valuable motifs, often inspired by nature, mythology, and Balinese Hindu beliefs.",
        'location' => 'Celuk, Bali',
        'whatsapp_url' => '#',
        'established' => '1952',
        'product_type' => 'Handcraft',
        'umkm_location' => 'Celuk, Bali',
    ];

    $story = [
        'p1' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...",
        'img1' => asset('images/article-2.jpg'),
        'p2' => "Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum...",
        'img2' => asset('images/article-3.jpg'),
        'p3' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...",
    ];

    $popularProduct = [
        'title' => "Arjuna’s Mask",
        'price' => "Rp. 300.000",
        'image' => asset('images/product-1.jpg'),
        'url' => '#',
    ];

    $featuredProducts = collect(range(1, 4))->map(fn($i) => [
        'title' => "Arjuna’s Mask",
        'price' => "Rp. 300.000",
        'image' => asset("images/product-$i.jpg"),
        'url' => '#',
    ])->toArray();

    $recommended = [
        [
            'badge' => 'Culinary',
            'image' => asset('images/work-2.jpg'),
            'rating' => '4.8',
            'reviews' => '51 reviews',
            'title' => "Bali’s Modern Food",
            'products' => '21 Products',
            'views' => '4.1k views',
            'desc' => "A short story about local culinary craft and tradition.",
            'author' => 'Pande Sujana',
            'url' => '#',
        ],
        [
            'badge' => 'HandCraft',
            'image' => asset('images/work-1.jpg'),
            'rating' => '4.9',
            'reviews' => '59 reviews',
            'title' => "Bali’s Traditional Craft",
            'products' => '38 Products',
            'views' => '6.2k views',
            'desc' => "A short story about artisans and handmade products.",
            'author' => 'Pande Sujana',
            'url' => '#',
        ],
        [
            'badge' => 'HandCraft',
            'image' => asset('images/explore-2.jpg'),
            'rating' => '4.9',
            'reviews' => '59 reviews',
            'title' => "Bali’s Craft Center",
            'products' => '38 Products',
            'views' => '6.2k views',
            'desc' => "A short story about MSME and cultural values.",
            'author' => 'Pande Sujana',
            'url' => '#',
        ],
    ];

    $reviews = [
        [
            'name' => 'Made Sentosa',
            'initials' => 'MS',
            'time' => '2 days ago',
            'stars' => 5,
            'text' => 'an effort to connect Balinese artisans with the wider community through a digital platform...',
            'img1' => asset('images/cta-market.jpg'),
            'img2' => asset('images/work-1.jpg'),
            'img3' => asset('images/work-2.jpg'),
        ],
    ];

    $mapEmbed = 'https://www.google.com/maps?q=Celuk%20Bali&output=embed';

    return view('pages.profile-umkm-page', compact(
        'umkm',
        'story',
        'popularProduct',
        'featuredProducts',
        'recommended',
        'reviews',
        'mapEmbed'
    ));
})->name('profile-umkm-page');


// ✅ About Us page
Route::get('/about-us', function () {
    return view('pages.about-us');
})->name('about.us');
