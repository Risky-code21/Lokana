<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon_lokana.png') }}">
    <title>{{ $user->name }} - Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white">

    @include('partials.navbar')

    <x-delete-modal title="Delete account?"
        description="Are you sure you want to delete your account? It will be gone forever!"
        buttonText="Yes, Delete Account" />

    <main class="pt-28 pb-14 px-4 sm:px-8 md:px-12 lg:px-56">

        <div x-data="{
            activeTab: new URLSearchParams(location.search).get('tab') || 'profile',
        
            changeTab(tab) {
                this.activeTab = tab;
                const url = new URL(window.location);
                url.searchParams.set('tab', tab);
                window.history.pushState({}, '', url);
            }
        }"
            class="max-w-[1600px] mx-auto rounded-[2rem] bg-white border border-surface-medium shadow-sm min-h-[700px] flex flex-col">

            {{-- Tab Bar Navigation --}}
            <nav class="w-full border-b border-surface-medium px-8 md:px-12 pt-8 flex gap-8 md:gap-12 overflow-x-auto">
                <button @click="changeTab('profile')"
                    class="pb-4 font-paragraph font-medium text-lg transition-all duration-300 border-b-2 whitespace-nowrap"
                    :class="activeTab === 'profile' ? 'border-primary-main text-primary-main font-semibold' :
                        'border-transparent text-text-body hover:text-'">
                    Profile
                </button>

                <button @click="changeTab('settings')"
                    class="pb-4 font-paragraph font-medium text-lg transition-all duration-300 border-b-2 whitespace-nowrap"
                    :class="activeTab === 'settings' ? 'border-primary-main text-primary-main font-semibold' :
                        'border-transparent text-text-body hover:text-'">
                    Setting
                </button>

                <button @click="changeTab('liked')"
                    class="pb-4 font-paragraph font-medium text-lg transition-all duration-300 border-b-2 whitespace-nowrap"
                    :class="activeTab === 'liked' ? 'border-primary-main text-primary-main font-semibold' :
                        'border-transparent text-text-body hover:text-'">
                    Like Content
                </button>
            </nav>

            {{-- CONTENT AREA --}}
            <div class="flex-grow p-8 md:p-12">

                <form action="{{ route('profiles.update.identity') }}" method="POST" enctype="multipart/form-data"
                    x-show="activeTab === 'profile'" x-cloak x-transition.opacity.duration.300ms
                    class="flex flex-col md:flex-row gap-12 lg:gap-20">
                    @csrf
                    @method('PATCH')
                    {{-- Sidebar Profile (Kiri) --}}
                    <aside class="w-full md:w-1/4 flex flex-col items-center gap-4">
                        <div class="relative">
                            <div
                                class="w-40 h-40 rounded-full bg-surface-medium overflow-hidden border-4 border-white shadow-sm">
                                <img src="{{ $user->avatar }}" alt="Profile Picture" class="w-full h-full object-cover">
                            </div>

                            {{-- Coming soon --}}
                            {{-- <input type="file" name="avatar" id="avatar_upload" class="hidden" accept="image/*">

                            <button type="button" onclick="document.getElementById('avatar_upload').click()"
                                class="absolute bottom-2 right-2 p-4 bg-primary-main text-white rounded-full flex items-center justify-center shadow-md hover:scale-105 transition-transform">
                                <x-heroicon-s-pencil class="size-4" />
                            </button> --}}
                        </div>
                        <h2 class="text-xl font-heading font-semibold text-">{{ $user->name }}</h2>
                    </aside>

                    {{-- Form Profile (Kanan) --}}
                    <div class="w-full md:w-3/4 max-w-2xl">
                        <h3 class="text-lg font-heading leading-none font-semibold text-">Edit Profile</h3>

                        <span class="my-6 block text-gray-400">Join on {{ $user->created_at->format('d F Y') }}</span>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-paragraph text- mb-2">Username</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    class="w-full border border-surface-medium rounded-lg px-4 py-3 font-paragraph text-sm text- focus:outline-none focus:border-primary-main transition-colors">
                                @error('name')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="pt-6 border-t border-surface-medium mt-8">
                                <p class="text-sm font-paragraph text-text-body mb-3">Want to change email or word
                                    your password?</p>
                                <button type="button" @click="activeTab = 'settings'"
                                    class="text-primary-main font-paragraph font-medium hover:underline flex items-center gap-2">
                                    Go to Security Settings
                                    <x-heroicon-s-arrow-right class="size-4" />
                                </button>
                            </div>

                            <button class="btn-primary">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>

                <div x-show="activeTab === 'settings'" x-cloak x-transition.opacity.duration.300ms>
                    <h2 class="text-xl font-heading font-semibold text- mb-8">Edit Your Account Information</h2>

                    {{-- Update security settings --}}
                    <form action="{{ route('profiles.update.security') }}" method="POST" class="max-w-2xl space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-paragraph text- mb-2">Email Saat Ini</label>
                            <input type="email" value="{{ $user->email }}" disabled
                                class="w-full border border-surface-medium bg-surface-low rounded-lg px-4 py-3 font-paragraph text-sm text-text-body cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-sm font-paragraph text- mb-2">Enter New Email
                                (Opsional)</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                placeholder="Masukkan email baru..."
                                class="w-full border border-surface-medium rounded-lg px-4 py-3 font-paragraph text-sm text- focus:outline-none focus:border-primary-main transition-colors">
                            @error('email')
                                <div class="error-status-primary mt-4">
                                    <x-heroicon-s-exclamation-circle class="size-5" />
                                    <p class="text-inherit m-0"> {{ $message }} </p>
                                </div>
                            @enderror
                        </div>

                        <div class="pt-4">
                            <label class="block text-sm font-paragraph text- mb-2">Enter Current Password</label>
                            <input type="password" name="current_password" placeholder="********"
                                class="w-full border border-surface-medium rounded-lg px-4 py-3 font-paragraph text-sm text- focus:outline-none focus:border-primary-main transition-colors">
                            @error('current_password')
                                <div class="error-status-primary mt-4">
                                    <x-heroicon-s-exclamation-circle class="size-5" />
                                    <p class="text-inherit m-0"> {{ $message }} </p>
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-paragraph text- mb-2">Enter New Password</label>
                            <input type="password" name="new_password" placeholder="********"
                                class="w-full border border-surface-medium rounded-lg px-4 py-3 font-paragraph text-sm text- focus:outline-none focus:border-primary-main transition-colors">
                            @error('new_password')
                                <div class="error-status-primary mt-4">
                                    <x-heroicon-s-exclamation-circle class="size-5" />
                                    <p class="text-inherit m-0"> {{ $message }} </p>
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-paragraph text- mb-2">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" placeholder="********"
                                class="w-full border border-surface-medium rounded-lg px-4 py-3 font-paragraph text-sm text- focus:outline-none focus:border-primary-main transition-colors">
                        </div>

                        <button type="submit" class="btn-primary">
                            Save
                        </button>
                    </form>

                    {{-- Danger zone yang sangat besar pengaruhnya terhadap akun pengguna --}}
                    <div class="mt-12 pt-8 border-t border-surface-medium">
                        <h3 class="text-lg font-heading font-semibold text-red-600 mb-4">Danger Zone</h3>
                        <div class="flex flex-wrap gap-4">
                            <button
                                class="border border-red-600 text-red-600 font-paragraph font-medium px-6 py-2.5 rounded-lg hover:bg-red-50 transition-colors">Sign
                                out</button>
                            <form action="{{ route('profiles.delete.account') }}" method="POST" @csrf
                                @method('DELETE') <button type="button"
                                @click="$dispatch('open-delete-modal', { url: '{{ route('profiles.delete.account') }}' })"
                                class="bg-red-600 text-white font-paragraph font-medium px-6 py-2.5 rounded-lg hover:bg-red-700 transition-colors">
                                Delete
                                Account</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'liked'" x-cloak x-transition.opacity.duration.300ms>
                    <h2 class="text-xl font-heading font-semibold text- mb-8">Article you like</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($likedArticles as $like)
                            @if ($like->likeable_type === 'article')
                                <x-article-card :article="$like->likeable" />
                            @endif
                        @empty
                            <x-empty-state containerClass="mt-16 col-span-full"
                                message="There are no articles to like" />
                            <a href="{{ route('articles.index') }}"
                                class="btn-primary mx-auto flex items-center gap-2">
                                Explore Articles <x-heroicon-s-arrow-right class="size-4" />
                            </a>
                        @endforelse
                    </div>

                    <div class="flex justify-end mt-12">
                        <nav>
                            {{-- Parameter kedua adalah nama file view pagination yang kita buat tadi --}}
                            @if ($likedArticles->hasPages())
                                {{-- 1. Jika halaman > 1, gunakan logic pagination asli --}}
                                {{ $likedArticles->links('components.pagination') }}
                            @elseif ($likedArticles->count() > 0)
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
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</body>

</html>
