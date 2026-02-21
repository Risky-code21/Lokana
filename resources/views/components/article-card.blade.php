@props(['article'])


@php
    // Function untuk cek apakah user yang login saat ini sudah melakukan like pada suatu komentar yang ada disini, entah komentar replay ataupun komentar utama
    $smartAvatar = fn($model) => $model->author->avatar ??
        'https://ui-avatars.com/api/?name=' . urlencode($model->author->name);

@endphp
{{-- 
    WRAPPER CARD 
    - Gunakan w-full (ikut grid parent)
    - Gunakan flex flex-col agar footer card rata bawah
--}}
<div
    class="w-full  bg-white rounded-card shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300 flex flex-col h-auto max-h-full">

    {{-- 1. THUMBNAIL IMAGE --}}
    <div class="h-48 w-full overflow-hidden bg-gray-100">
        {{-- Cek apakah ada gambar? Jika tidak, pakai placeholder --}}
        @if ($article->medias->isNotEmpty())
            <img src="{{ asset('storage/' . $article->thumbnail->url) }}" alt="{{ $article->title }}"
                class="w-full h-full object-cover object-center hover:scale-105 transition-transform duration-500" />
        @else
            {{-- Fallback Image jika tidak ada upload --}}
            <div class="w-full h-full flex items-center justify-center text-gray-400">
                <x-heroicon-s-photo class="w-12 h-12" />
            </div>
        @endif
    </div>

    {{-- 2. CONTENT BODY --}}
    <div class="p-5 flex flex-col flex-grow space-y-4">

        {{-- Judul Artikel --}}
        <a href="{{ route('article.detail', $article->slug) }}" class="block group">
            <h3
                class="text-xl font-bold text-gray-800 group-hover:text-primary-main line-clamp-2 leading-tight transition-colors">
                {{ $article->title }}
            </h3>
        </a>

        @if ($article->category)
            <span class="w-fit py-2 px-3 text-xs font-semibold text-white bg-primary-light rounded-md">
                {{ $article->category->name }}
            </span>
        @endif

        {{-- Metadata Row (Date, Views, Likes) --}}
        <div class="flex items-center flex-wrap gap-4 text-xs text-gray-500 font-medium">
            {{-- Date --}}
            <div class="flex items-center gap-1.5">
                <x-heroicon-s-calendar-days class="size-4 text-gray-400" />
                <span>{{ $article->created_at->format('d M Y') }}</span>
            </div>

            {{-- Views --}}
            <div class="flex items-center gap-1.5">
                <x-heroicon-s-eye class="size-4 text-gray-400" />
                {{-- Format angka (misal: 1200 jadi 1.2k) bisa dibuat helper nanti --}}
                <span>{{ number_format($article->views_count) }} Views</span>
            </div>

            {{-- Likes --}}
            <div class="flex items-center gap-1.5">
                <x-heroicon-s-heart class="size-4 text-gray-400" />
                <span>{{ number_format($article->likes_count) }} Likes</span>
            </div>
        </div>

        {{-- Short Description --}}
        <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-4">
            {{ $article->short_description }}
        </p>

        {{-- 3. FOOTER (Author & Button) --}}
        {{-- mt-auto akan mendorong bagian ini ke paling bawah card --}}
        <div class="space-y-4 mt-auto">
            <div class="flex gap-3">

                <div class="size-10 overflow-hidden rounded-full">

                    <img src="{{ $smartAvatar($article) }}" alt="{{ $article->author->name }}"
                        class="size-full object-cover object-center" />

                </div>



                <div class="space-y-0.5">

                    <p class="text-primary-main leading-none">{{ $article->author->name }}</p>

                    <p class="text-slate-400">
                        {{ $article->author->role == 'admin' ? 'Lokana admin' : 'Admin testing' }}</p>

                </div>

            </div>
            <a href="{{ route('article.detail', $article->slug) }}" class="btn-primary block text-center">Read
                more</a>

            {{-- <form action="{{ route('article.delete', $article->slug) }}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="btn-primary bg-red-600 block text-center">Hapus article</button>
            </form> --}}

        </div>
    </div>

</div>
