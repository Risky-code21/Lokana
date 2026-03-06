<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon_lokana.png') }}">
    <title>{{ config('app.name') }} - About Us</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white">

    @include('partials.navbar')

    <main class="">

        {{-- Hero section --}}
        <section class="w-full h-fit mx-auto px-4 sm:px-8 md:px-12 lg:px-56 mt-28 text-center">
            <div class="mx-auto z-10 relative max-w-[1600px]">

                {{--  Heading untuk hero section --}}
                <h1
                    class="bg-gradient-to-b from-primary-main to-primary-light text-transparent bg-clip-text font-heading  font-bold leading-tight mb-6">
                    Preserving Bali's Cultural Heritage <br class="hidden md:block"> through modern connections.
                </h1>

                {{-- Paragraph pelengkap hero section --}}
                <p class="text-text-body font-paragraph text-sm md:text-base lg:text-lg max-w-2xl mx-auto mb-12">
                    At Lokana, we believe that greatness starts from small, meaningful steps. We are a local platform
                    dedicated to empowering Balinese artisans.
                </p>

                <a href="#anchor-place"
                    class="block p-4 mx-auto rounded-full bg-primary-main w-fit text-white hover:bg-state-hover transition hover:-translate-y-1 cursor-pointer">
                    <x-heroicon-s-arrow-down class="size-4 md:size-5" />
                </a>

                {{-- Gambar maskot hero  section --}}
                <div class="w-fit block mx-auto">
                    <img class="h-[240px] md:h-[480px] w-auto object-contain"
                        src="{{ asset('images/maskot_pose_barang_melayang.webp') }}" alt="Lokana Logo" />
                </div>
            </div>
        </section>

        {{-- Our story --}}
        <section
            class="w-full h-fit mx-auto px-4 sm:px-8 md:px-12 lg:px-56 mt-8 md:mt-12 lg:mt-28 bg-surface-low py-16 scroll-mt-16"
            id="anchor-place">
            <div class="max-w-[1600px] mx-auto">
                <div class="text-center mb-16">
                    {{-- Headline our story section --}}
                    <span class="text-primary-main font-heading text-sm font-bold uppercase tracking-widest">Our
                        Story</span>

                    {{-- Heading our story section --}}
                    <h1 class="mt-4 text-primary-main">
                        Preserving Bali's Cultural Heritage <br class="hidden md:block"> through modern connections.
                    </h1>
                </div>

                <div class="flex flex-col gap-16 md:gap-24">

                    {{-- From the start --}}
                    <div class="flex flex-col md:flex-row gap-10 lg:gap-16">

                        {{-- Foto pendukung --}}
                        <div class="w-full md:w-1/2 h-64 md:h-96 rounded-3xl overflow-hidden shadow-sm">
                            <img src="https://plus.unsplash.com/premium_photo-1668883189152-d771c402c385?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTd8fGJhbGl8ZW58MHx8MHx8fDA%3Dp"
                                alt="Traditional Mask" class="w-full h-full object-cover">
                        </div>

                        {{-- Informasi lebih lanjut --}}
                        <div class="w-full md:w-1/2 space-y-4">
                            {{-- Headline from the start --}}
                            <span
                                class="w-fit py-2 px-3 text-xs font-semibold text-white bg-primary-light rounded-md block">From
                                The
                                Start</span>

                            {{-- Heading from the start --}}
                            <h3 class="font-bold text-primary-main">Bridging Tradition and Modern Steps</h3>

                            {{-- Description from the start --}}
                            <p class="font-paragraph text-text-body textsm md:text-base">
                                At Lokana, we believe that greatness starts from small, meaningful steps. Established in
                                [Year], we are a local platform dedicated to empowering Balinese artisans by giving them
                                a
                                space to showcase their work to the world.
                            </p>
                        </div>
                    </div>

                    {{-- Our Mission --}}
                    <div class="flex flex-col md:flex-row-reverse gap-10 lg:gap-16">
                        {{-- Foto pendukung --}}
                        <div class="w-full md:w-1/2 h-64 md:h-96 rounded-3xl overflow-hidden shadow-sm">
                            <img src="https://images.unsplash.com/photo-1610179016496-6dd2bbc2f865?q=80&w=720&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                alt="Batik Artisan" class="w-full h-full object-cover">
                        </div>

                        {{-- Informasi lebih lanjut --}}
                        <div class="w-full md:w-1/2 space-y-4">
                            {{-- Headline mission --}}
                            <span
                                class="w-fit py-2 px-3 text-xs font-semibold text-white bg-primary-light rounded-md block">Our
                                Mission</span>
                            {{-- Heading mission 2 --}}
                            <h3 class="text-3xl font-heading font-bold text-primary-main">Empowering Local Craftsmanship
                            </h3>

                            {{-- Description mission --}}
                            <p class="font-paragraph text-text-body textsm md:text-base">
                                We aim to bridge the gap between traditional craftsmanship and modern markets. By
                                providing
                                a digital platform, we help MSMEs thrive while preserving the rich cultural identity of
                                Bali.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Social proof --}}
        <section class="w-full h-fit mx-auto px-4 sm:px-8 md:px-12 lg:px-56 mt-8 md:mt-12 lg:mt-28">
            <div class="mx-auto max-w-[1600px]">
                <div class="text-center mb-16">
                    {{-- Headlne social proof section --}}
                    <span class="text-primary-main font-heading text-sm font-bold uppercase tracking-widest">Our
                        Impact</span>

                    {{-- Heading social proof section --}}
                    <h1 class="bg-gradient-to-b from-primary-main to-primary-light text-transparent bg-clip-text mt-4">
                        Preserving Bali's Cultural Heritage <br class="hidden md:block"> through modern connections.
                    </h1>
                </div>

                {{-- MSME Proof section --}}
                <div class="mb-20 w-full">
                    {{-- Count heading --}}
                    <h2 class="text-4xl font-paragraph font-semibold text-black mb-2">500 +</h2>
                    {{-- Description --}}
                    <p class="font-paragraph text-text-body mb-8">MSMEs joined our platform</p>

                    {{-- Scroll horizontal container card --}}
                    <div class="flex flex-col md:flex-row gap-8">
                        <x-umkm-card class="hover:shadow-lg transition-shadow" />
                        <x-umkm-card class="hover:shadow-lg transition-shadow" />
                        <x-umkm-card class="hover:shadow-lg transition-shadow" />
                    </div>

                    <a href="{{ route('articles.index') }}" class="btn-primary bg-primary-light mt-6 w-fit px-8">
                        <span class="font-paragraph font-medium">View more MSMEs</span>
                        <x-heroicon-s-arrow-right class="size-4" />
                    </a>
                </div>

                {{-- Artisan Heritages dari user --}}
                <div>
                    {{-- Count heading --}}
                    <h2 class="text-4xl font-paragraph font-semibold text-black mb-2">1500 +</h2>
                    {{-- Description --}}
                    <p class="font-paragraph text-text-body mb-10">Artisan Heritages</p>

                    {{-- Testimonials container --}}
                    <div class="columns-1 md:columns-2 gap-6">
                        <x-testimonial-card name="Hendric amba" initials="HA"
                            message="an effort to connect Balinese artisans with the wider community through a digital platform, so that local works and products" />

                        <x-testimonial-card name="Wayan Budi" initials="WB"
                            message="Platform yang sangat mudah digunakan untuk menenemukan hidden jem yang ada." />

                        <x-testimonial-card name="Surya Jaya" initials="SJ"
                            message="Platform ini sangat membantu para pengrajin lokal. Sangat merepresentasikan budaya Bali dengan baik dan elegan." />

                        <x-testimonial-card name="Irman sigma" initials="IS"
                            message="A Good platform for connecting artisans with the community." />
                    </div>
                </div>
            </div>
        </section>

        {{-- Core values --}}
        <section
            class="w-full h-fit mx-auto px-4 sm:px-8 md:px-12 lg:px-56 mt-8 md:mt-12 lg:mt-28 bg-surface-low py-16">
            <div class="max-w-[1600px] mx-auto">
                <div class="text-center mb-16">
                    <span
                        class="text-primary-main font-heading text-sm font-bold uppercase tracking-widest">Values</span>
                    <h1 class="text-primary-main mt-4">
                        Preserving Bali's Cultural Heritage <br class="hidden md:block"> through modern connections.
                    </h1>
                </div>

                <div class="space-y-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach (['Agile', 'Equity', 'Agile', 'Equity'] as $value)
                        <div
                            class="flex col-span-1 h-full gap-6 p-6 rounded-2xl bg-white border border-surface-medium hover:shadow-md transition-shadow">
                            <div class="size-20 flex justify-center items-center flex-shrink-0 text-white relative">

                                {{-- Maskot sesuai core values --}}
                                <div class="w-20 h-28 flex items-end overflow-hidden rounded-b-full absolute -top-8">
                                    <div class="bg-primary-main size-20 max-h-20 rounded-full relative">
                                        <div class="w-fit block mx-auto absolute -top-7">
                                            <img class="h-40 w-auto object-contain "
                                                src="{{ asset('images/maskot_faq.webp') }}" alt="Lokana Logo" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-heading font-bold text-xl text-black mb-1">{{ $value }}</h4>
                                <p class="font-paragraph text-sm text-text-body">There are many variations of passages
                                    of
                                    Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Our Team --}}
        <section class="w-full h-fit mx-auto px-4 sm:px-8 md:px-12 lg:px-56 mt-8 md:mt-12 lg:mt-28 py-16">
            <div class="max-w-[1600px] mx-auto">
                <div class="text-center mb-16">
                    <span class="text-primary-main font-heading text-sm font-bold uppercase tracking-widest">Our
                        Team</span>
                    <h1 class="bg-gradient-to-b from-primary-main to-primary-light text-transparent bg-clip-text mt-4">
                        Our
                        Team</h1>
                </div>
                <div class="flex flex-wrap gap-10 justify-center mx-auto">
                    <x-group-member-card />
                    <x-group-member-card />
                    <x-group-member-card />
                    <x-group-member-card />
                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</body>

</html>
