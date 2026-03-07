{{--
    resources/views/landing-page.blade.php
    ───────────────────────────────────────
    Stack  : Laravel + Tailwind CSS v3 + Alpine.js
    Fonts  : Playfair Display (serif heading) + DM Sans (body)
    Assets : @vite(['resources/css/app.css', 'resources/js/app.js'])
--}}
<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon_lokana.png') }}">
    <title>{{ config('app.name') }} - Home</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-surface-high text-[#2B2621] font-sans antialiased">

    @include('partials.navbar')


    <main>

        {{-- Hero section --}}
        <section id="home" class="relative pt-36 pb-28 overflow-hidden text-white"
            aria-label="Hero — Bali Artist Local Product MSMEs">
            {{-- Background image + gradient overlay --}}
            <div class="absolute inset-0 bg-cover bg-center opacity-75"
                style="background-image: url('{{ asset('images/landing-page-bg-hero.jpg') }}')" role="img"
                aria-label="Foto pasar seni Bali"></div>

            <div class="absolute inset-0 bg-primary-main opacity-70"></div>

            {{-- Content --}}
            <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col items-center text-center gap-5">

                    <h1 class="max-w-xl text-white">
                        Bali Artist Local Product MSMEs
                    </h1>

                    <p class="text-white/85 max-w-[60ch] text-[13.5px] sm:text-sm leading-relaxed">
                        Supporting Bali local economy by promoting authentic regional products through our MSME market
                        &amp; platform.
                    </p>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-wrap justify-center gap-6 mt-2">
                        <a href="#explore"
                            class="inline-flex gap-4 items-center px-6 py-2 rounded-btn
                                   bg-white border border-white/25
                                    hover:-translate-y-px active:translate-y-0
                                   transition-all duration-150">
                            <span>Explore UMKM</span>
                            <x-heroicon-s-arrow-right class="size-4" />
                        </a>
                        <a href="#register"
                            class="inline-flex gap-4 items-center px-6 py-2 rounded-btn
                                font-semibold text-white
                                   bg-white/10 border border-white/22
                                   hover:bg-white/18 hover:border-white/30 hover:-translate-y-px active:translate-y-0
                                   transition-all duration-150">
                            <span>Learn about UMKM</span>
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div class="flex flex-wrap justify-center gap-8 sm:gap-10 mt-12 text-white/90">
                        @foreach ([['num' => $stats['umkm'] ?? '100+', 'lbl' => 'SME Owner'], ['num' => $stats['products'] ?? '500+', 'lbl' => 'MSME Products'], ['num' => $stats['happy'] ?? '1000+', 'lbl' => 'Happy Visitors']] as $stat)
                            <div class="text-center text-white min-w-[120px]">
                                <h2 class="text-inherit">{{ $stat['num'] }}</h2>
                                <p class=" text-inherit mt-2">{{ $stat['lbl'] }}</p>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </section>

        {{-- Explore MSME  --}}
        <section id="explore" class="py-16 bg-surface-medium" aria-labelledby="explore-heading">
            <div class="max-w-6xl mx-auto px-8 sm:px-6 lg:px-8 flex flex-col gap-8 items-center">

                {{-- Section heading --}}
                <header class="text-center mb-8 flex flex-col items-center gap-4">
                    <span class="py-2 px-4 text-white text-sm bg-primary-main rounded-md block w-fit">Feature
                        section
                    </span>
                    <h1 id="explore-heading" class="text-primary-main">
                        Explore
                        <span class="text-inherit text-primary-light">
                            MSME
                        </span>
                        Products
                    </h1>
                    <p class="text-text-body">
                        We offer a variety of traditional Balinese products.
                    </p>
                </header>

                {{-- Product Cards Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <x-umkm-card />
                    <x-umkm-card />
                    <x-umkm-card />
                </div>

                <a href="#explore" class="btn-primary bg-primary-light">
                    View All MSMEs
                    <x-heroicon-s-arrow-right class="size-4" />
                </a>

            </div>
        </section>

        {{-- Selected Works --}}
        <section class="py-16" aria-labelledby="works-heading">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

                <header class="text-center mb-8 flex flex-col items-center gap-4">
                    <span class="py-2 px-4 text-white text-sm bg-primary-main rounded-md block w-fit">Feature
                        section
                    </span>
                    <h1 id="explore-heading" class="text-primary-main">
                        Explore
                        <span class="text-inherit text-primary-light">
                            MSME
                        </span>
                        Products
                    </h1>
                    <p class="text-text-body">
                        We offer a variety of traditional Balinese products.
                    </p>
                </header>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <x-umkm-products-card />
                    <x-umkm-products-card />
                    <x-umkm-products-card />
                </div>

            </div>
        </section>

        {{-- Social Proof --}}
        <section id="about" class="py-16 bg-surface-low" aria-labelledby="support-heading">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

                    {{-- Left — Text --}}
                    <div>
                        <h1 id="support-heading" class="text-primary-main mb-4">
                            Supporting Local Products, Strengthening MSMEs.
                        </h1>
                        <p class="text-body">
                            We are connecting local SMEs and customers. By showcasing authentic regional products,
                            we help MSMEs reach a wider market while preserving local culture and craftsmanship.
                        </p>
                    </div>

                    {{-- Right — Stats Tiles (CSS Grid stagger layout) --}}
                    {{-- Parent Container: Menggunakan columns-2 --}}
                    <div class="columns-2 gap-4 w-full mx-auto" aria-label="Statistik Lokana">

                        {{-- Tile A: Total UMKM --}}
                        <div
                            class="break-inside-avoid mb-4 rounded-[18px] p-5 flex flex-col items-center justify-center text-center
                bg-primary-light text-white min-h-[200px]">
                            <div class="font-serif font-bold text-2xl">{{ $stats['umkm'] ?? '100+' }}</div>
                            <div class="text-base mt-2">Total UMKM</div>
                        </div>

                        {{-- Tile C: Rating (Tinggi) --}}
                        {{-- Di layout columns, konten mengalir ke bawah dulu baru pindah kolom --}}
                        <div
                            class="break-inside-avoid mb-4 rounded-[18px] p-5 flex flex-col items-center justify-center text-center
                bg-primary-main text-white min-h-[180px]">
                            <div class="font-serif font-bold text-2xl flex gap-2 items-center"><x-heroicon-s-star
                                    class="size-6" />
                                {{ $stats['rating'] ?? '5' }}</div>
                            <div class="text-base mt-2">Rating</div>
                        </div>

                        {{-- Tile B: Products (Sangat Tinggi) --}}
                        <div
                            class="break-inside-avoid mb-4 rounded-[18px] p-5 flex flex-col items-center justify-center text-center
                bg-primary-main text-white min-h-[240px]">
                            <div class="font-serif font-bold text-2xl">{{ $stats['products'] ?? '500+' }}</div>
                            <div class="text-base mt-2">MSME Products</div>
                        </div>

                        {{-- Tile D: Happy Visitors --}}
                        <div
                            class="break-inside-avoid mb-4 rounded-[18px] p-5 flex flex-col items-center justify-center text-center
                bg-primary-light text-white min-h-[220px]">
                            <div class="font-serif font-bold text-2xl">{{ $stats['happy'] ?? '1000+' }}</div>
                            <div class="text-base mt-2">Happy Visitors</div>
                        </div>

                    </div>

                </div>
            </div>
        </section>

        {{-- Articles --}}
        <section id="articles" class="py-16 bg-surface-medium" aria-labelledby="stories-heading">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

                <header class="text-center mb-8 flex flex-col items-center gap-4">
                    <h1 id="explore-heading" class="text-primary-main">
                        Stories and
                        <span class="text-inherit text-primary-light">
                            Insights
                        </span>
                    </h1>
                    <p class="text-text-body max-w-lg">
                        A collection of stories and information that shares stories, experiences, and insights about
                        MSMEs and local products.
                    </p>
                </header>

                <div class="flex flex-col md:flex-row gap-8">
                    @foreach ($articles as $article)
                        {{-- Pakai titik dua (:) dan hapus kurung kurawal --}}
                        <x-article-card :article="$article" />
                    @endforeach
                </div>

            </div>
        </section>

        {{-- Cta --}}
        <section id="register" class="py-16 pb-20 bg-surface-low" aria-labelledby="cta-heading">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

                <header class="text-center mb-8 flex flex-col items-center gap-4">
                    <h1 id="explore-heading" class="text-primary-main">
                        Visit Our Artisans
                        <span class="text-inherit text-primary-light">
                            In Person
                        </span>
                    </h1>
                    <p class="text-text-body max-w-lg">
                        Book a personal visit to our artisan workshops. Watch master craftspeople at work, learn their
                        techniques, and take home a piece of Balinese culture
                    </p>
                </header>

                <div class="flex flex-wrap justify-center gap-6 mt-2">
                    <a href="#explore" class="btn-primary">
                        <span>Chat on whatsapp</span>
                    </a>
                    <a href="#register"
                        class="inline-flex gap-4 items-center px-6 py-2 rounded-btn
                                font-semibold text-primary-main
                                   bg-white/10 border border-white
                                   hover:bg-white/18 hover:border-white/30 hover:-translate-y-px active:translate-y-0
                                   transition-all duration-150">
                        <span>View Workshops Tours.</span>
                    </a>
                </div>

            </div>
        </section>

    </main>

    @include('partials.footer')

</body>

</html>
