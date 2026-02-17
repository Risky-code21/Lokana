<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Article</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800 antialiased flex flex-col min-h-screen">

    {{-- 1. NAVBAR --}}
    @include('partials.navbar')

    {{-- 2. MAIN CONTENT WRAPPER --}}
    {{-- Gunakan 'flex-grow' agar footer terdorong ke bawah jika konten sedikit --}}
    @if (isset($articles) && isset($populerArticle))
        <main class="flex-grow container mx-auto px-4 sm:px-8 md:px-12 lg:px-56 mt-28 mb-8 space-y-6">

            {{-- A. CATEGORY PILLS (Scrollable on Mobile) --}}
            {{-- overflow-x-auto: Agar bisa di-swipe kiri-kanan di HP --}}
            <section class="w-full h-fit overflow-x-auto pb-2">
                <div class="flex gap-3 w-max">
                    {{-- Active State Example --}}
                    {{-- 1. Tombol "All" (Opsional: Untuk reset filter) --}}
                    <a href="{{ route('article.index', request()->except('category')) }}"
                        class="py-2 px-4 text-sm font-medium rounded-btn transition hover:opacity-90 
                    {{ request('category') === null
                        ? 'bg-primary-light text-white'
                        : 'bg-white text-primary-light border border-primary-light' }}">
                        All
                    </a>

                    {{-- 2. Looping Kategori --}}
                    @foreach ($categoriesArticle as $categorie)
                        {{-- PERBAIKAN HREF: Logic Anda sudah benar (array_merge), ini menjaga search tetap ada saat ganti kategori --}}
                        <a href="{{ route('article.index', array_merge(request()->query(), ['category' => $categorie->name])) }}"
                            class="py-2 px-4 text-sm font-medium rounded-btn transition hover:opacity-90 
                        {{-- PERBAIKAN LOGIC AKTIF: --}}
                        {{-- Bandingkan 'parameter category di URL' dengan 'slug kategori saat ini' --}}
                        {{ request('category') == $categorie->name
                            ? 'bg-primary-light text-white'
                            : 'bg-white text-primary-light border border-primary-light' }}">
                            {{ $categorie->name }}
                        </a>
                    @endforeach
                </div>
            </section>

            {{-- B. FEATURED ARTICLE (Hero Section) --}}
            <section class="w-full">
                <h1 class="text-4xl mb-6">Article populer</h1>
                <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-stretch">

                    {{-- Image (Kiri/Atas) --}}
                    <div class="w-full lg:w-1/2 h-64 md:h-80 lg:h-auto relative rounded-card overflow-hidden shadow-sm">

                        {{-- Image Tag --}}
                        {{-- 
            1. absolute inset-0: Kunci utamanya! Ini memaksa gambar mengisi container 
               tanpa mempengaruhi dimensi container itu sendiri.
            2. w-full h-full object-cover: Agar gambar potrait ter-crop rapi (tidak gepeng).
        --}}
                        <img src="{{ asset('storage/' . $populerArticle->thumbnail->url) }}" alt="Featured Article"
                            class="absolute inset-0 w-full h-full object-cover object-center hover:scale-105 transition duration-500 ease-in-out" />
                    </div>

                    {{-- Info (Kanan/Bawah) --}}
                    <div class="w-full lg:w-1/2 space-y-6">
                        <span
                            class="inline-block py-2 px-4 text-white text-sm font-medium rounded-btn bg-primary-light">
                            {{ $populerArticle->category->name }}
                        </span>

                        <div class="space-y-4">
                            <a href="" class="group">
                                <h1
                                    class="text-3xl md:text-4xl font-bold text-heading group-hover:text-primary-main transition">
                                    {{ $populerArticle->title }}
                                </h1>
                            </a>

                            {{-- Metadata Row --}}
                            <div class="flex flex-wrap items-center gap-4 mt-2 text-slate-500 text-sm">
                                <div class="flex items-center gap-1.5">
                                    <x-heroicon-s-calendar-days class="size-4" />
                                    <span>{{ $populerArticle->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="hidden md:block size-1 bg-slate-300 rounded-full"></div>
                                <div class="flex items-center gap-1.5">
                                    <x-heroicon-s-eye class="size-4" />
                                    <span>{{ $populerArticle->views_count }} views</span>
                                </div>
                                <div class="hidden md:block size-1 bg-slate-300 rounded-full"></div>
                                <div class="flex items-center gap-1.5">
                                    <x-heroicon-s-heart class="size-4" />
                                    <span>{{ $populerArticle->likes_count }} likes</span>
                                </div>
                            </div>

                            <p class="text-slate-500 leading-relaxed line-clamp-3">
                                {{ $populerArticle->short_description }}
                            </p>
                        </div>

                        {{-- Author & Action --}}
                        <div class="flex gap-3 mt-10">
                            <div class="size-10 overflow-hidden rounded-full">
                                <img src="https://ui-avatars.com/api/?name=Irman+Firdaus" alt=""
                                    class="size-full object-cover object-center" />
                            </div>
                            <div class="space-y-0.5">
                                <p class="text-primary-main leading-none">{{ $populerArticle->author->name }}</p>
                                <p class="text-slate-400">Admin lokana</p>
                            </div>
                        </div>

                        <a href="" class="btn-primary block px-8 text-center w-fit">Read more</a>
                    </div>
                </div>
            </section>

            {{-- C. ARTICLE LIST GRID --}}
            <section class="space-y-8 mt-16">
                <h2 class="text-2xl font-bold text-heading">Another article</h2>
                {{-- Ambil data article yang ada, jika tidak tampilkan empty state --}}
                @if ($articles->isNotEmpty())
                    {{-- Grid System: 1 kolom (HP), 2 kolom (Tablet), 3 kolom (Laptop) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($articles as $article)
                            {{-- Pakai titik dua (:) dan hapus kurung kurawal --}}
                            <x-article-card :article="$article" />
                        @endforeach
                    </div>
                @else
                    <x-empty-state message="There are no another articles to read on this category" />
                @endif
            </section>

            {{-- D. PAGINATION --}}
            <div class="flex justify-end">
                {{-- Ini nanti diganti {{ $articles->links() }} saat sudah connect ke backend --}}
                <nav>
                    {{-- Parameter kedua adalah nama file view pagination yang kita buat tadi --}}
                    @if ($articles->hasPages())
                        {{-- 1. Jika halaman > 1, gunakan logic pagination asli --}}
                        {{ $articles->links('components.pagination') }}
                    @elseif ($articles->count() > 0)
                        {{-- 2. Jika halaman cuma 1 (tapi ada datanya), Render Pagination Statis --}}
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center">
                            <div class="flex gap-2">

                                {{-- Angka 1 (Aktif Coklat) --}}
                                <span
                                    class="px-4 py-2 bg-primary-light text-white rounded-md text-base font-bold shadow-sm">
                                    1
                                </span>

                            </div>
                        </nav>
                    @endif
                </nav>
            </div>

        </main>
    @else
        <x-empty-state containerClass="my-36" message="There are no articles to read" />
    @endif

    {{-- 3. FOOTER --}}
    @include('partials.footer')

</body>

</html>
