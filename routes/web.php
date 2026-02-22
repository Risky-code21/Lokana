<?php

use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\LikeController;
use App\Http\Controllers\User\CommentController;
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
        'image' => asset('images/product-' . $i . '.jpg'),
        'category' => 'HandCraft',
        'title' => "Bali’s Art #$i",
        'seller' => 'Pande Jagatama',
        'count' => 37,
        'desc' => 'Produk lokal khas Bali yang dibuat oleh UMKM dengan kualitas terbaik.',
        'rating' => '5.0',
        'url' => '#',
    ])->toArray();

    $works = collect(range(1, 6))->map(fn($i) => [
        'image' => asset('images/work-' . $i . '.jpg'),
        'title' => 'Arjuna Mask',
        'desc' => 'Topeng tradisional Bali yang dibuat secara handmade oleh pengrajin lokal.',
        'price' => 'Rp. 300.000',
        'url' => '#',
    ])->toArray();

    $articles = collect(range(1, 3))->map(fn($i) => [
        'image' => asset('images/article-' . $i . '.jpg'),
        'title' => 'Article Name',
        'excerpt' => 'Cerita singkat tentang UMKM lokal dan produk-produk tradisional Bali.',
        'url' => '#',
    ])->toArray();

    return view('pages.landing_page', compact('stats', 'products', 'works', 'articles'));
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


Route::controller(ArticleController::class)->group(function () {

    // Halaman List Artikel
    Route::get('/articles', 'index')->name('article.index');

    // Halaman Detail (menggunakan Slug)
    Route::get('/articles/{slug}', 'show')->name('article.detail');

    // Crud sementara article
    Route::post('articles/post', 'store')->name('articles.store');

    // Proses Simpan Artikel
    Route::post('/store', 'store')->name('articles.store');

    Route::get('article/edit/{slug}', 'edit')->name('article.edit');

    Route::put('/article/update/{article:slug}', 'update')->name('articles.update');
    Route::delete('/article/delete/{article:slug}', 'delete')->name('article.delete');

    // API Khusus untuk Froala Editor Upload Image
    Route::post('/upload-media', 'uploadFromEditor')->name('articles.upload_media');
});

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
Route::middleware('auth')->prefix('comments')->name('comments.')->controller(CommentController::class)->group(function () {

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
Route::middleware('auth')->prefix('likes')->name('likes.')->controller(LikeController::class)->group(function () {

    Route::post('/{type}/{slug}', 'toggle')
        ->name('toggle');
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

    $about = [
        'hero_title' => "Preserving Bali’s Cultural Heritage through modern connections.",
        'hero_desc'  => "Lokana helps connect local artisans and MSMEs to broader audiences through meaningful stories, culture, and products.",
        'hero_image' => asset('images/about-hero.png'),

        'mission_title' => 'Our mission',
        'mission_heading' => "Preserving Bali’s Cultural Heritage through modern connections.",
        'mission_left_image' => asset('images/about-mission-1.jpg'),
        'mission_right_image' => asset('images/about-mission-2.jpg'),
        'mission_cards' => [
            ['tag' => 'Our mission', 'title' => 'Revitalizing Tradition for the Modern Era.', 'desc' => 'We help cultural products remain relevant through design, storytelling, and digital access.'],
            ['tag' => 'Our mission', 'title' => 'Bridging Local Artisans to the Global Stage', 'desc' => 'We bring exposure to Balinese MSMEs so their works can be recognized widely.'],
        ],

        'stats_title' => 'Our impact',
        'stats_heading' => "Preserving Bali’s Cultural Heritage through modern connections.",
        'stat_1' => ['num' => '500+', 'label' => 'MSMEs are helped'],
        'stat_2' => ['num' => '1000+', 'label' => 'visitors feel happy'],

        'impact_cards' => collect(range(1, 4))->map(fn($i) => [
            'image' => asset("images/explore-$i.jpg"),
            'badge' => 'HandCraft',
            'title' => $i === 2 ? "Bali’s Arjuna’s mask" : "Bali’s Statue Carving",
            'rating' => '4.9',
            'author' => 'Pande Sujana',
            'url'   => '#',
        ])->toArray(),

        'testi_title' => '1000+ visitors feel happy',
        'testimonials' => [
            ['initials' => 'MA', 'name' => 'Made Ari', 'text' => 'The platform is amazing. It helps me discover authentic Balinese crafts and stories in one place.'],
            ['initials' => 'KA', 'name' => 'Kadek Ayu', 'text' => 'Beautiful design and meaningful stories. I love how it connects culture with modern needs.'],
            ['initials' => 'BP', 'name' => 'Bagus Putra', 'text' => 'As an artisan, I feel supported. My work gets exposure and customers understand my story.'],
        ],

        'values_title' => 'Our vision',
        'values_heading' => 'What Drives Us.',
        'values' => [
            ['title' => 'Quality', 'desc' => 'We prioritize authenticity and craftsmanship in every product and story.'],
            ['title' => 'Quality', 'desc' => 'We ensure every MSME receives fair exposure and sustainable growth.'],
            ['title' => 'Quality', 'desc' => 'We connect culture with modern audiences in a respectful way.'],
            ['title' => 'Quality', 'desc' => 'We focus on community impact for artisans and local families.'],
        ],

        'team_title' => 'Our team',
        'team' => [
            ['name' => 'Risky', 'role' => 'Crypto analisis', 'tag1' => 'Crypto analisis', 'tag2' => 'Team member', 'image' => asset('images/team-1.jpg')],
            ['name' => 'Surya', 'role' => 'Crypto analisis', 'tag1' => 'Crypto analisis', 'tag2' => 'Team member', 'image' => asset('images/team-2.jpg')],
            ['name' => 'Pamji', 'role' => 'Crypto analisis', 'tag1' => 'Crypto analisis', 'tag2' => 'Team member', 'image' => asset('images/team-3.jpg')],
            ['name' => 'Gung Jaya', 'role' => 'Crypto analisis', 'tag1' => 'Crypto analisis', 'tag2' => 'Team member', 'image' => asset('images/team-4.jpg')],
            ['name' => 'Ardi', 'role' => 'Crypto analisis', 'tag1' => 'Crypto analisis', 'tag2' => 'Team member', 'image' => asset('images/team-5.jpg')],
        ],

    ];

    return view('pages.about-us', compact('about'));
})->name('about.us');

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
Route::middleware('auth')->prefix('comments')->name('comments.')->controller(CommentController::class)->group(function () {

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
Route::middleware('auth')->prefix('likes')->name('likes.')->controller(LikeController::class)->group(function () {

    Route::post('/{type}/{slug}', 'toggle')
        ->name('toggle');
});

// Testing fitur admin versi cepat
// Untuk sekarang ini hanya untuk testing CRUD saja
Route::get('/testing', [ArticleController::class, 'create'])->name('testing');
