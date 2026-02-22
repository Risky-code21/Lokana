{{-- 
    Pastikan Alpine.js sudah ter-load di layout utama (app.blade.php) 
    Biasanya via @vite(['resources/js/app.js']) 
--}}
<header x-data="{ mobileOpen: false, userDropdownOpen: false }"
    class="fixed top-0 left-0 w-full bg-white border-b border-gray-200 z-40 transition-all duration-300">

    <div
        class="max-w-8xl mx-auto px-4 sm:px-8 md:px-12 lg:px-56 h-20 flex items-center justify-between lg:justify-normal">

        {{-- 1. LOGO --}}
        <div class="w-fit md:w-48">
            <a href="{{ route('register.index') }}" class="flex-shrink-0 z-50">
                <img class="h-10 w-auto object-contain" src="{{ asset('images/logo_lokana_coklat.webp') }}"
                    alt="Lokana Logo" />
            </a>
        </div>

        {{-- 2. DESKTOP NAVIGATION (Tengah) --}}
        <nav class="hidden lg:flex mx-auto items-center gap-8">
            <a href="{{ route('landing-page') }}"
                class="text-gray-600 hover:text-primary-main font-medium transition">Home</a>
            <a href="{{ route('articles.index') }}"
                class="text-gray-600 hover:text-primary-main font-medium transition">Articles</a>
            <a href="#" class="text-gray-600 hover:text-primary-main font-medium transition">Explore</a>
            <a href="{{ route('faq.index') }}"
                class="text-gray-600 hover:text-primary-main font-medium transition">FAQ</a>
            <a href="#" class="text-gray-600 hover:text-primary-main font-medium transition">About us</a>
        </nav>

        {{-- 3. RIGHT SECTION (Auth Logic) --}}
        <div class="hidden lg:flex items-center gap-4">

            @guest
                {{-- A. JIKA BELUM LOGIN (Tampilkan Tombol Sign In/Up) --}}
                <a href="{{ route('login.index') }}"
                    class="py-2 px-6 rounded-btn text-white hover:bg-state-hover bg-primary-light hover:bg-opacity-90 transition font-medium">
                    Sign In
                </a>
                <a href="{{ route('register.index') }}"
                    class="py-2 px-6 rounded-btn border border-primary-main text-primary-main hover:bg-primary-50 transition font-medium">
                    Sign Up
                </a>
            @endguest

            @auth
                {{-- B. JIKA SUDAH LOGIN (Tampilkan Avatar & Dropdown) --}}
                <div class="relative md:ml-14">
                    {{-- Avatar Trigger --}}
                    <button @click="userDropdownOpen = !userDropdownOpen" @click.outside="userDropdownOpen = false"
                        class="flex items-center justify-center gap-3 focus:outline-none group">

                        <div class="text-right hidden xl:block">
                            <p
                                class="text-sm leading-none mb-0 font-semibold text-gray-800 group-hover:text-primary-main transition">
                                {{ Auth::user()->name }}</p>
                            {{-- <p class="text-xs text-gray-500 leading-none">Member</p> --}}
                        </div>

                        {{-- Avatar Image (Gunakan UI Avatars jika tidak ada foto) --}}
                        <div
                            class="size-10 rounded-full overflow-hidden border-2 border-transparent group-hover:border-primary-main transition">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                                class="size-full object-cover" alt="User Avatar">
                        </div>

                        {{-- Icon Chevron --}}
                        <x-heroicon-s-chevron-down class="size-4 text-gray-400 group-hover:text-primary-main transition" />
                    </button>

                    {{-- Dropdown Menu (Absolute) --}}
                    <div x-show="userDropdownOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 overflow-hidden"
                        style="display: none;">

                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-xs text-gray-500">Signed in as</p>
                            <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary-main">My
                            Profile</a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary-main">Settings</a>

                        <div class="border-t border-gray-100 my-1"></div>

                        {{-- Logout Form (Wajib POST method di Laravel) --}}
                        <form method="POST" action="{{ route('register.index') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

        </div>

        {{-- 4. MOBILE HAMBURGER (Visible di Mobile) --}}
        <div class="lg:hidden flex items-center gap-4">
            {{-- Jika User Login, tampilkan Avatar kecil di sebelah hamburger (Opsional, agar user tahu dia login) --}}
            @auth
                <div class="size-8 rounded-full overflow-hidden border border-gray-200">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                        class="size-full object-cover">
                </div>
            @endauth

            <button @click="mobileOpen = !mobileOpen" class="text-gray-600 focus:outline-none">
                <svg x-show="!mobileOpen" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
                <svg x-show="mobileOpen" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    {{-- 5. MOBILE MENU DROPDOWN --}}
    <div x-show="mobileOpen" x-transition
        class="lg:hidden absolute top-20 left-0 w-full sm:px-8 md:px-12 bg-white shadow-lg flex flex-col max-h-[80vh] overflow-y-auto"
        style="display: none;">

        <div class="p-4 space-y-6">
            <a href="{{ route('landing-page') }}"
                class="block  rounded-md text-gray-600 hover:text-primary-main font-medium">Home</a>
            <a href="{{ route('articles.index') }}"
                class="block  rounded-md text-gray-600 hover:text-primary-main font-medium">Articles</a>
            <a href="#" class="block  rounded-md text-gray-600 hover:text-primary-main font-medium">Explore</a>
            <a href="{{ route('faq.index') }}"
                class="block  rounded-md text-gray-600 hover:text-primary-main font-medium">FAQ</a>
            <a href="#" class="block  rounded-md text-gray-600 hover:text-primary-main font-medium">About
                us</a>
        </div>

        <hr class="border-gray-100">

        <div class="">
            @guest
                {{-- Mobile: Tombol Sign In/Up Stack --}}
                <div class="flex flex-col gap-3 p-4">
                    <a href="{{ route('register.index') }}"
                        class="w-full text-center py-3 rounded-btn text-white hover:bg-state-hover bg-primary-light hover:opacity-90 font-medium">Sign
                        In</a>
                    <a href="{{ route('register.index') }}"
                        class="w-full text-center py-3 rounded-btn border border-primary-main text-primary-main font-medium">Sign
                        Up</a>
                </div>
            @endguest

            @auth
                {{-- Mobile: User Profile Menu --}}
                <div class="p-4 space-y-3">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="size-10 rounded-full bg-gray-200 overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                                class="size-full object-cover">
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 mb-0">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 mb-0">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <a href="#" class="block text-sm text-gray-600 py-1 hover:text-primary-main">My Profile</a>
                    <a href="#" class="block text-sm text-gray-600 py-1 hover:text-primary-main">Settings</a>

                    <form method="POST" action="{{ route('register.index') }}"
                        class="py-2 border-t border-gray-200 mt-2">
                        @csrf
                        <button type="submit" class="w-full text-left text-sm text-red-600 font-medium">Sign Out</button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</header>
