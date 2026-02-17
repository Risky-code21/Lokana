@extends('layouts.app')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')

@section('content')
    @include('components.toast-notification')
    
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Pengaturan Akun</h1>
            <p class="text-gray-600 mt-1">Kelola informasi profil dan keamanan akun Anda</p>
        </div>
        
        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="text-center mb-4">
                        <img class="h-20 w-20 rounded-full object-cover mx-auto border-4 border-blue-100" 
                             src="{{ auth()->user()->avatar_url }}" 
                             alt="{{ auth()->user()->name }}">
                        <h3 class="mt-2 font-semibold text-gray-800">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                    </div>
                    
                    <nav class="space-y-1">
                        <a href="#profile" 
                           class="tab-link active block px-3 py-2 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg"
                           data-target="profile">
                            <i class="fas fa-user mr-2"></i> Profil
                        </a>
                        <a href="#password" 
                           class="tab-link block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg"
                           data-target="password">
                            <i class="fas fa-lock mr-2"></i> Keamanan
                        </a>
                    </nav>
                </div>
            </div>
            
            <!-- Content -->
            <div class="lg:col-span-3">
                <!-- Profile Tab -->
                <div id="profile" class="tab-content">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Profil</h2>
                        
                        <form action="{{ route('admin.settings.profile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="space-y-6">
                                <!-- Avatar -->
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="avatar">
                                        Foto Profile
                                    </label>
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div id="avatarPreview" class="h-20 w-20 rounded-full bg-gray-200 overflow-hidden">
                                                <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="h-20 w-20 rounded-full object-cover">
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <input type="file" 
                                                   name="avatar" 
                                                   id="avatar"
                                                   accept="image/*"
                                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Maks: 2MB</p>
                                        </div>
                                    </div>
                                    @error('avatar')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Name -->
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="name" 
                                           id="name"
                                           value="{{ old('name', auth()->user()->name) }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('name') border-red-500 @enderror"
                                           required>
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Email -->
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           name="email" 
                                           id="email"
                                           value="{{ old('email', auth()->user()->email) }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('email') border-red-500 @enderror"
                                           required>
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Submit -->
                                <div class="flex justify-end">
                                    <button type="submit" 
                                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Password Tab -->
                <div id="password" class="tab-content hidden">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">Ubah Password</h2>
                        
                        <form action="{{ route('admin.settings.password') }}" method="POST">
                            @csrf
                            
                            <div class="space-y-6">
                                <!-- Current Password -->
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="current_password">
                                        Password Saat Ini <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" 
                                           name="current_password" 
                                           id="current_password"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('current_password') border-red-500 @enderror"
                                           required>
                                    @error('current_password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- New Password -->
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="new_password">
                                        Password Baru <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" 
                                           name="new_password" 
                                           id="new_password"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('new_password') border-red-500 @enderror"
                                           required>
                                    <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter, mengandung huruf besar dan angka</p>
                                    @error('new_password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Confirm New Password -->
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="new_password_confirmation">
                                        Konfirmasi Password Baru <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" 
                                           name="new_password_confirmation" 
                                           id="new_password_confirmation"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition-all"
                                           required>
                                </div>
                                
                                <!-- Submit -->
                                <div class="flex justify-end">
                                    <button type="submit" 
                                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                                        <i class="fas fa-key mr-2"></i>Update Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Tab switching
    document.querySelectorAll('.tab-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Update active tab
            document.querySelectorAll('.tab-link').forEach(l => {
                l.classList.remove('active', 'text-blue-700', 'bg-blue-50');
                l.classList.add('text-gray-700');
            });
            this.classList.add('active', 'text-blue-700', 'bg-blue-50');
            
            // Show target content
            const target = this.dataset.target;
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById(target).classList.remove('hidden');
        });
    });

    // Avatar preview
    document.getElementById('avatar')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.querySelector('#avatarPreview img');
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
    </script>
@endsection