<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Dinamis Title --}}
    <title>{{ config('app.name') }} - {{ $article->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800 antialiased flex flex-col min-h-screen">

    @include('partials.navbar')

    {{-- Bread crumb, agar mudah dalam melakukan redirect --}}
    {{-- <div class=" mt-28 mb-4 px-4 sm:px-8 md:px-12 lg:px-56 text-[#666]">
        <a href="" class="text-primary-light">Home</a> /
        <a href="{{ route('article.index') }}" class="text-primary-light">Article</a> /
        <span class="text-gray-400">{{ Str::limit($article->title, 50) }}</span>
    </div> --}}

    <article class="w-full max-w-8xl mx-auto mt-28  px-4 sm:px-8 md:px-12 lg:px-56">

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
                <p class="text-slate-400">Admin lokana</p>
            </div>
        </div>

        {{-- Meta data --}}
        <div class="flex flex-wrap items-center gap-4 mt-2 text-slate-500 text-sm">
            <div class="flex items-center gap-1.5">
                <x-heroicon-s-calendar-days class="size-4" />
                <span>{{ $article->created_at->format('d M Y') }}</span>
            </div>
            <div class="hidden md:block size-1 bg-slate-300 rounded-full"></div>
            <div class="flex items-center gap-1.5">
                <x-heroicon-s-eye class="size-4" />
                <span>{{ $article->views_count }} views</span>
            </div>
            <div class="hidden md:block size-1 bg-slate-300 rounded-full"></div>
            <form action="{{ route('articles.like', $article->slug) }}" method="POST"
                class="flex items-center gap-1.5">
                @csrf
                <button type="submit">
                    <x-heroicon-s-heart class="size-4" />
                </button>
                <span>{{ $article->likes_count }} likes</span>
            </form>
        </div>


        {{-- Cover article --}}
        @if ($article->medias->isNotEmpty())
            <div class="w-full h-[200px] lg:h-[400px] my-4 rounded-btn overflow-hidden">

                {{-- Pastikan property 'url' atau 'file_name' sesuai database Anda --}}
                <img src="{{ asset('storage/' . $article->thumbnail->url) }}" alt="{{ $article->title }}"
                    class="size-full object-center object-cover">
            </div>
        @endif

        {{-- PENTING: Gunakan {!! !!} agar tag HTML dirender (bold, italic, gambar), bukan ditampilkan sebagai teks --}}
        <div
            class="mb-10 p-6 md:p-8 lg:p-12 bg-surface-high rounded-btn article-prose text-[#444] text-base leading-[1.8] text-justify">
            {!! $article->content !!}
        </div>

    </article>

    {{-- Related article --}}
    <section class="w-full max-w-8xl mx-auto px-4 sm:px-8 md:px-12 lg:px-56 space-y-8 my-12">
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
    <section class="w-full max-w-8xl mx-auto px-4 sm:px-8 md:px-12 lg:px-56 mb-18 bg-white" x-data="{
        {{-- Submit komentar dengan http request json --}}
        submitKomentar(event) {
            const form = event.target;
            const formData = new FormData(form);
    
            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        form.reset(); // Kosongkan text area
                        this.isReplying = false; // Tutup form balas (jika itu form balasan)
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }">

        <div class="mb-10">
            {{-- JUDUL SECTION (Dynamic Count) --}}
            <h3 class="text-2xl text-[#333] mb-6 flex items-center gap-2">
                <x-heroicon-s-chat-bubble-oval-left-ellipsis class="text-primary-light size-8" />
                {{-- Hitung jumlah komentar --}}
                Comments ({{ $article->comments->count() }})
            </h3>

            {{-- FORM INPUT KOMENTAR --}}
            @auth
                {{-- 1. Bungkus dengan FORM & arahkan ke Route Store --}}
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
                    <a href="{{ route('login.index') }}" class="text-[#6b5541] font-bold underline hover:text-[#5e4b35]">
                        Sign in here
                    </a>
                </div>
            @endauth
        </div>

        {{-- Container Utama Komentar dengan State Alpine --}}
        {{-- Container Utama Komentar --}}
        <section class="mt-12" x-data="{
            {{-- Insiassi page --}}
            page: 1,
                {{-- Cek apakah comments saat ini diinsiasi dengna pagination --}}
            hasMore: {{ $comments->hasMorePages() ? 'true' : 'false' }},
        
                {{-- Stata loading --}}
            isLoading: false,
        
                currentViewerId: {{ auth()->id() ?? 'null' }},
        
                init() {
                    window.Echo.channel('article.{{ $article->slug }}')
                        .listen('CommentPosted', (event) => {
                            document.getElementById('comments-list-container')
                                .insertAdjacentHTML('afterbegin', event.html);
                        });
                },
        
                {{-- Function untuk loadmore atau untuk menambah jumalh komentar yang ada di setiap view detail article, nantinya disetiap load akan ditambah 5 data komentar --}}
            loadMore() {
                    {{-- Mengembalikan function dengan mengembalikan isloading menjadi false, untuk menghindari double klik --}}
                    if (this.isLoading) return;
        
                    {{-- Jika isloading false, maka baris pertama return tadi akan diskip dan langsung mengarah ke sini --}}
                    this.isLoading = true;
                    this.page++;
        
                    {{-- Tangakp request yang ada pada page ini, karena data yang masuk menggunakan pagination yang akan memuat link seperti pada syntax fetch dibawah --}}
                    fetch(`?page=${this.page}`, {
                        {{-- Headeres request --}}
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            {{-- Request akan selalu menerima json untuk responsenya --}} 'Accept': 'application/json'
                        }
                    })
                    {{-- Olah response yang didapat en --}}
                        .then(response => response.json())
                    {{-- Mengolah data response json tadi menjadi sebuah element html yang siap di inject ke container komentar --}}
                        .then(data => {
                            {{-- Menginsiasi container data yang di load dengan identitas pagination, misal kita mengambil data di halaman dua pagination, maka id akan menjadi comment-page-2, ini berguna untuk function show less nantinya --}}
                            const pageWrapper = `<div id='comment-page-${this.page}' x-data x-transition>${data.html}</div>`;
        
                            document.getElementById('comments-list-container')
                                .insertAdjacentHTML('beforeend', pageWrapper);
        
                            this.hasMore = data.hasMore;
                        })
                    {{-- Menangkap error, dan menggembalikannya melalui console log --}}
                        .catch(error => console.error('Error:', error))
        
                    {{-- Menggembalikan state loading menjadi false kembali --}}
                        .finally(() => { this.isLoading = false; });
                },
        
                showLess() {
                    {{-- Jika halaman pagination hanya 1 batalkan showless ini, karena minimal data yang tampil adalah 5 atau 1 halaman pagination --}}
                    if (this.page <= 1);
        
        
                    {{-- Untuk mencari tingkatan no paling tinggi dari container comment dari penambahan atau yang sudah ada sebelumnya --}}
                    const lastPage = document.getElementById(`comment-page-${this.page}`);
                    if (lastPage) {
                        lastPage.remove();
                    }
        
                    {{-- Mengurangi state page agar dapat mendapatkan container dengan no yang lebih rendah --}}
                    this.page--;
        
                    {{-- Stata yang digunakan untuk menyembunyikan tombol load more --}}
                    this.hasMore = true;
                }
        }">

            {{-- Daftar komentar --}}
            <div id="comments-list-container">
                {{-- Load halaman 1 sebagai insiasi halaman --}}
                @forelse($comments as $comment)
                    <x-comment-bubble :comment="$comment" :articleSlug="$article->slug" />
                @empty
                    <div class="text-center text-gray-400 py-8 text-sm">Belum ada komentar.</div>
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
