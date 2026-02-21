<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon_lokana.png') }}">
    <title>{{ config('app.name') }} - {{ $article->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800 antialiased flex flex-col min-h-screen">

    {{-- Pop up auth required --}}
    <x-auth-required-modal description='You need to log in to your account first to like this article' />

    @include('partials.navbar')

    {{-- Main content article --}}
    <article class="w-full max-w-[1600px] mx-auto mt-28  px-4 sm:px-8 md:px-12 lg:px-56">

        {{-- Category article --}}
        @if ($article->category)
            <span
                class="py-2 px-4 my-2 inline-block text-white text-sm font-medium rounded-md bg-primary-light transition hover:opacity-90">
                {{ $article->category->name }}
            </span>
        @endif

        {{-- Title article --}}
        <h1 class="text-[2rem] md:text-[2.5rem] leading-[1.3] my-4 text-[#2c2c2c] font-bold">
            {{ $article->title }}
        </h1>

        {{-- Author dan meta data lainnya --}}
        {{-- Author --}}
        <div class="flex gap-3 my-4">
            <div class="size-10 overflow-hidden rounded-full">
                <img src="https://ui-avatars.com/api/?name=Irman+Firdaus" alt=""
                    class="size-full object-cover object-center" />
            </div>
            <div class="space-y-0.5">
                <p class="text-primary-main leading-none">{{ $article->author->name }}</p>
                <p class="text-slate-400">{{ $article->author->role == 'admin' ? 'Lokana admin' : 'Admin testing' }}</p>
            </div>
        </div>

        {{-- Meta data --}}
        <div class="flex flex-wrap items-center gap-4 mt-2 text-slate-500 text-sm">
            {{-- Created at article --}}
            <div class="flex items-center gap-1.5">
                <x-heroicon-s-calendar-days class="size-4" />
                <span>{{ $article->created_at->format('d M Y') }}</span>
            </div>

            {{-- Divider --}}
            <div class="hidden md:block size-1 bg-slate-300 rounded-full"></div>

            {{-- Views count dari article --}}
            <div class="flex items-center gap-1.5">
                <x-heroicon-s-eye class="size-4" />
                <span>{{ $article->views_count }} views</span>
            </div>

            {{-- Divider --}}
            <div class="hidden md:block size-1 bg-slate-300 rounded-full"></div>

            {{-- Button like dengan realtime websocket --}}
            <form x-data="likeButton(
                {{ $article->likes_count }},
                {{ auth()->check() && $article->isLikedBy(auth()->id()) ? 'true' : 'false' }},
                {{ auth()->check() ? 'true' : 'false' }},
                'article',
                '{{ $article->slug }}'
            )" @submit.prevent="toggled"
                action="{{ route('likes.toggle', ['type' => 'article', 'slug' => $article->slug]) }}" method="POST"
                class="flex items-center gap-1.5">
                @csrf

                {{-- Icon love relative tergantung state yang dihasilkan dari like button module --}}
                <button type="submit" :class="isLiked ? 'text-red-600' : 'text-gray-400'"
                    class="transition-colors duration-200 hover:scale-110">
                    <x-heroicon-s-heart x-show="isLiked" class="size-4" />
                    <x-heroicon-o-heart x-show="!isLiked" class="size-4" />
                </button>

                <span x-text="likesCount"></span> likes
            </form>
        </div>


        {{-- Cover article --}}
        @if ($article->medias->isNotEmpty())
            <div class="w-full h-[200px] lg:h-[400px] my-4 rounded-btn overflow-hidden">
                <img src="{{ asset('storage/' . $article->thumbnail->url) }}" alt="{{ $article->title }}"
                    class="size-full object-center object-cover">
            </div>
        @endif

        {{-- Content article yang dimana content sebenarnya adalah sebuah elemen html yang memerlukan syntax !! untuk bisa di render dengan baik --}}
        <div
            class="mb-10 p-6 md:p-8 lg:p-12 bg-surface-high rounded-btn article-prose text-[#444] text-base leading-[1.8] text-justify">
            {!! $article->content !!}
        </div>

    </article>

    {{-- Related article --}}
    <section class="w-full max-w-[1600px] mx-auto px-4 sm:px-8 md:px-12 lg:px-56 space-y-8 my-12">
        <h2 class="text-4xl font-bold text-heading">Related article</h2>
        {{-- Ambil data article yang ada, jika tidak tampilkan empty state --}}
        @if ($relatedArticle->isNotEmpty())
            {{-- Grid System ... --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($relatedArticle as $item)
                    <x-article-card :article="$item" />
                @endforeach
            </div>
        @else
            <x-empty-state message="There are no articles to read" />
        @endif
    </section>

    {{-- Komentar --}}
    <section class="w-full max-w-[1600px] mx-auto px-4 sm:px-8 md:px-12 lg:px-56 mb-18 bg-white"
        x-data="commentSection('{{ $article->slug }}', {{ $comments->hasMorePages() ? 'true' : 'false' }}, {{ auth()->id() ?? 'null' }})">

        <div class="mb-10">
            {{-- Judul dan jumlah komentar (Dynamic Count) --}}
            <h3 class="text-2xl text-[#333] mb-6 flex items-center gap-2">
                <x-heroicon-s-chat-bubble-oval-left-ellipsis class="text-primary-light size-8" />
                {{-- Hitung jumlah komentar --}}
                Comments ({{ $article->comments->count() }})
            </h3>

            {{-- Form input komentar untuk membuat parent komentar --}}
            @auth
                {{-- Bungkus dengan FORM & arahkan ke Route Store --}}
                <form @submit.prevent="submitKomentar"
                    action="{{ route('comments.store', ['type' => 'article', 'slug' => $article->slug]) }}" method="POST"
                    class="relative">
                    @csrf

                    <textarea name="content"
                        class="w-full p-5 border border-gray-300 rounded-2xl focus:outline-none focus:border-[#6b5541] focus:ring-1 focus:ring-[#6b5541] min-h-[140px] text-gray-600 placeholder-gray-400 resize-none font-sans"
                        placeholder="Type your message here.." required></textarea>

                    <div class="flex justify-end mt-3">
                        <button type="submit" class="btn-primary gap-4">
                            <span class="text-sm">Send your comment</span>
                            <x-heroicon-s-paper-airplane class="text-white size-4 -rotate-45" />
                        </button>
                    </div>
                </form>
            @else
                {{-- State jika belum login --}}
                <div class="p-6 border border-gray-200 rounded-2xl text-center bg-gray-50">
                    <p class="text-gray-600 mb-2">Please login to join the discussion.</p>
                    <a href="{{ route('login.index') }}"
                        class="text-primary-main font-bold underline hover:text-state-hover">
                        Sign in here
                    </a>
                </div>
            @endauth
        </div>

        {{-- Container Utama Komentar dengan State Alpine --}}
        {{-- Container Utama Komentar --}}
        <section class="mt-12">

            {{-- Daftar komentar --}}
            <div id="comments-list-container">
                {{-- Load halaman 1 sebagai insiasi halaman --}}
                @forelse($comments as $comment)
                    <x-comment-bubble :comment="$comment" :modelSlug="$article->slug" />
                @empty
                    <div class="text-center text-gray-400 py-8 text-sm">
                        No comments yet</div>
                @endforelse
            </div>

            {{-- CONTAINER TOMBOL LOAD MORE & SHOW LESS --}}
            <div class="mt-8 flex justify-center gap-4">

                {{-- Tombol show less (Hanya muncul jika halaman > 1) --}}
                {{-- Akan muncul ketika ada lebih dari 1 pagination yang sudah terload --}}
                <button x-show="page > 1" @click="showLess()" style="display: none;"
                    class="px-6 py-2 text-gray-500 hover:text-red-500 text-sm font-semibold transition-colors">
                    Show Less
                </button>

                {{-- Tombol load more --}}
                {{-- Akan muncul jika terdapat lebih dari 2 halaman dari pagination data komentar --}}
                <button x-show="hasMore" @click="loadMore()" :disabled="isLoading" style="display: none;"
                    class="btn-primary text-sm">
                    <x-heroicon-s-arrow-path x-show="isLoading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" />
                    <span x-text="isLoading ? 'Loading...' : 'Load More Comments'"></span>
                </button>

            </div>
        </section>
    </section>

    @include('partials.footer')
    @stack('scripts')
</body>

</html>
