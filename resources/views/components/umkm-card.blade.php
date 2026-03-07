@props([
    'image' => 'https://images.unsplash.com/photo-1533900298318-6b8da08a523e?q=80&w=800&auto=format&fit=crop',
    'category' => 'HandCraft',
    'rating' => '4.9',
    'reviews' => '59',
    'title' => 'Bali’s Modern Food',
    'productsCount' => '38',
    'views' => '6.2k',
    'description' => 'At Bali\'s Craft, we believe that greatness starts from small, meaningful steps. Established in [Tahun Berdiri], we are a local.',
    'ownerAvatar' => 'https://ui-avatars.com/api/?name=Pande+Sujana',
    'ownerName' => 'Pande Sujana',
    'url' => '#',
])

<div
    {{ $attributes->merge(['class' => 'bg-white rounded-card shadow-sm border border-surface-medium overflow-hidden flex flex-col h-full hover:shadow-md transition-shadow duration-300 text-left ']) }}>

    {{-- Bagian Atas: Gambar & Badge Kategori --}}
    <div class="relative h-56 w-full flex-shrink-0">
        <img src="{{ $image }}" alt="{{ $title }}"
            class="w-full h-full object-cover grayscale-50 hover:grayscale-0 transition-filter duration-500" />

        {{-- Badge (Bisa disesuaikan warnanya dengan class custom Anda, misal: bg-primary-light) --}}
        <div class="absolute top-4 left-4 w-fit py-2 px-3 text-xs font-semibold text-white bg-primary-light rounded-md">
            {{ $category }}
        </div>
    </div>

    {{-- Bagian Bawah: Konten --}}
    <div class="p-5 flex flex-col flex-grow">

        {{-- Rating & Reviews --}}
        <div class="flex items-center gap-1.5 mb-3">
            <x-heroicon-s-star class="size-4 text-yellow-400" />
            <span class="font-semibold text-primary-main font-paragraph">{{ $rating }}</span>
            <span class="text-text-body font-paragraph text-sm">({{ $reviews }} reviews)</span>
        </div>

        {{-- Judul UMKM --}}
        <h3 class="font-heading text-left font-semibold text-[28px] text-primary-main mb-1 line-clamp-1">
            {{ $title }}
        </h3>

        {{-- Meta Data (Produk & Views) --}}
        <div class="flex items-center gap-2 text-sm text-gray-400 font-paragraph mb-4">
            <span>{{ $productsCount }} Products</span>
            <span class="text-gray-300 text-xs">•</span>
            <span>{{ $views }} views</span>
        </div>

        {{-- Deskripsi (Dibatasi maksimal 3 baris agar rapi) --}}
        <p class="font-paragraph text-gray-400 text-sm line-clamp-3 mb-6 flex-grow">
            {{ $description }}
        </p>

        {{-- Owner / Pembuat --}}
        <div class="flex items-center gap-3 mb-6">
            <img src="{{ $ownerAvatar }}" alt="{{ $ownerName }}" class="w-8 h-8 rounded-full object-cover">
            <p class="font-paragraph text-sm text-gray-400">
                By <span class="font-medium text-primary-main">{{ $ownerName }}</span>
            </p>
        </div>

        {{-- Tombol (Akan selalu terdorong ke paling bawah karena ada flex-grow di deskripsi) --}}
        <a href="{{ $url }}" class="btn-primary">
            View Detail
        </a>
    </div>
</div>
