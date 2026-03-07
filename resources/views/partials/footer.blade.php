<footer class="w-full bg-[#282727] text-white pt-16 pb-8">
    {{-- Container Utama: Membatasi lebar agar tidak terlalu melebar di layar besar --}}
    <div class="container mx-auto px-4 md:px-8 lg:px-20">

        {{-- BAGIAN ATAS: Logo/Desc (Kiri) & Link (Kanan) --}}
        {{-- Di HP: Stack ke bawah (flex-col). Di Laptop: Sebelahan (lg:flex-row) --}}
        <div class="flex flex-col lg:flex-row justify-between gap-12 lg:gap-8">

            {{-- 1. Brand Section (Logo & Desc) --}}
            {{-- w-full di HP, w-1/3 di Laptop --}}
            <div class="w-full lg:w-1/3 space-y-6">
                <div class="w-fit">
                    <a href="{{ route('register.index') }}" class="flex-shrink-0 z-50">
                        <img class="h-10 w-auto object-contain" src="{{ asset('images/logo_lokana.webp') }}"
                            alt="Lokana Logo" />
                    </a>
                </div>

                <p class="text-white text-sm leading-relaxed max-w-sm">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quos, impedit sequi?
                    Architecto distinctio voluptates rerum quos corrupti voluptatem tenetur.
                </p>
            </div>

            {{-- 2. Navigation Section --}}
            {{-- Grid System: 
                 - HP: 2 Kolom (grid-cols-2) -> Rapi & Hemat tempat
                 - Laptop: 4 Kolom (lg:grid-cols-4) -> Sesuai desain awal
            --}}
            <nav class="w-full lg:w-2/3 grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-4">

                {{-- Column 1: Explore --}}
                <div class="space-y-4 text-white">
                    <h3 class="font-semibold text-lg text-white">Explore</h3>
                    <ul class="space-y-3 text-sm text-white">
                        <li><a href="#" class="text-inherit font-normal hover:text-gray-300 transition">All
                                MSME</a></li>
                        <li><a href="#" class="text-inherit font-normal hover:text-gray-300 transition">Meet
                                Artisans</a></li>
                        <li><a href="#" class="text-inherit font-normal hover:text-gray-300 transition">Stories
                                & Article</a>
                        </li>
                        <li><a href="#" class="text-inherit font-normal hover:text-gray-300 transition">About
                                Us</a></li>
                    </ul>
                </div>

                {{-- Column 2: Quick Links --}}
                <div class="space-y-4 text-white">
                    <h3 class="font-semibold text-lg text-white">Quick Links</h3>
                    <ul class="space-y-3 text-sm text-white">
                        <li><a href="#" class="text-inherit font-normal hover:text-gray-300 transition">About
                                Us</a></li>
                        <li><a href="#"
                                class="text-inherit font-normal hover:text-gray-300 transition">Explore</a></li>
                        <li><a href="#"
                                class="text-inherit font-normal hover:text-gray-300 transition">Article</a></li>
                        <li><a href="#" class="text-inherit font-normal hover:text-gray-300 transition">FAQ</a>
                        </li>
                    </ul>
                </div>

                {{-- Column 3: Categories --}}
                <div class="space-y-4 text-white">
                    <h3 class="font-semibold text-lg text-white">Categories</h3>
                    <ul class="space-y-3 text-sm text-white">
                        <li><a href="#" class="text-inherit font-normal hover:text-gray-300 transition">Batik</a>
                        </li>
                        <li><a href="#" class="text-inherit font-normal hover:text-gray-300 transition">Food &
                                Healthy</a>
                        </li>
                        <li><a href="#"
                                class="text-inherit font-normal hover:text-gray-300 transition">Jewelry</a></li>
                        <li><a href="#"
                                class="text-inherit font-normal hover:text-gray-300 transition">Handcraft</a></li>
                    </ul>
                </div>

                {{-- Column 4: Contact --}}
                <div class="space-y-4 text-white">
                    <h3 class="font-semibold text-lg text-white">Contact</h3>
                    <ul class="space-y-3 text-sm text-white">
                        <li>Jl. Gadung No. 123 Denpasar</li>
                        <li>+62 361 231-213</li>
                        <li>lokana@gmail.com</li>
                    </ul>
                </div>

            </nav>
        </div>

        {{-- BAGIAN BAWAH: Copyright --}}
        {{-- Menggunakan border-t (garis atas) sebagai pemisah yang rapi --}}
        <div class="mt-16 lg:mt-36 pt-8 border-t border-gray-700 text-center">
            <p class="text-sm text-gray-400">
                &copy; {{ date('Y') }} Lokana. All rights reserved.
            </p>
        </div>
    </div>
</footer>
