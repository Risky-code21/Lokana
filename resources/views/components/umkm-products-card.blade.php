@props([
    'image' =>
        'https://images.unsplash.com/photo-1654569420225-63a1858e3178?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTl8fGJhbGklMjBtYXNrfGVufDB8fDB8fHww',
    'title' => "Arjuna's Mask",
    'seller' => 'Pande Sujana',
    'sellerAvatar' =>
        'https://images.unsplash.com/photo-1488161628813-04466f872be2?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTV8fGh1bWFufGVufDB8fDB8fHww',
    'shop' => "Bali's Craft",
    'description' => "At Bali's Craft, we believe that greatness starts from small, meaningful steps.",
    'price' => 'Rp. 300.000',
    'url' => '#',
])

<article
    class="relative col-span-1 rounded-[24px] overflow-hidden
           shadow-sm flex flex-col
           bg-black/40
           transition-transform duration-300 "
    aria-label="Produk: {{ $title }}">

    {{-- ── Background Image (full card height) ── --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover object-center"
            loading="lazy">
        {{-- Multi-stop gradient: clear top → heavy bottom --}}
        <div
            class="absolute inset-0 bg-gradient-to-b
                    from-black/10
                    via-black/20
                    via-[55%]
                    to-black/90
                    to-[85%]">
        </div>
    </div>

    {{-- ── Spacer: pushes content to bottom ── --}}
    <div class="relative z-10 flex-1 min-h-[200px]"></div>

    {{-- ── Content Block (bottom) ── --}}
    <div class="relative z-10 px-5 pb-1 pt-3 flex flex-col gap-2">

        {{-- Seller + Shop --}}
        <div class="flex items-center gap-2">
            <img src="{{ $sellerAvatar }}" alt="Avatar {{ $seller }}"
                class="w-6 h-6 rounded-full object-cover border border-white/25 shrink-0" loading="lazy">
            <p class="text-white">
                {{ $seller }}
                <span class="text-white mx-2" aria-hidden="true">•</span>
                {{ $shop }}
            </p>
        </div>

        {{-- Title --}}
        <h2 class="text-white">
            {{ $title }}
        </h2>

        {{-- Description --}}
        <p class="text-white">
            {{ $description }}
        </p>

        {{-- Price --}}
        <p class="text-white font-semibold text-2xl tracking-tight" aria-label="Harga: {{ $price }}">
            {{ $price }}
        </p>

    </div>

    {{-- ── CTA Button ── --}}
    <div class="relative z-10 px-4 pt-4 pb-6">
        <a href="{{ $url }}" class="btn-primary w-full bg-primary-light">
            View Product Detail
        </a>
    </div>

</article>
