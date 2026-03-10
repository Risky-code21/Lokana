@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
    @include('components.toast-notification')
    
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-800">Edit User</h2>
                <p class="text-gray-600 mt-1">Ubah informasi user</p>
            </div>
            
            <!-- Form -->
            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Avatar -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="avatar">
                            Foto Profile
                        </label>
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div id="avatarPreview" class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-16 w-16 rounded-full object-cover">
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
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('name') border-red-500 @enderror"
                               placeholder="Masukkan nama lengkap"
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
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('email') border-red-500 @enderror"
                               placeholder="contoh@email.com"
                               required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Role -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="role">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select name="role" 
                                id="role"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('role') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Role</option>
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Password (Optional) -->
                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ubah Password (Opsional)</h3>
                        <p class="text-sm text-gray-500 mb-4">Kosongkan jika tidak ingin mengubah password</p>
                        
                        <div class="space-y-4">
                            <!-- New Password -->
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                    Password Baru
                                </label>
                                <input type="password" 
                                       name="password" 
                                       id="password"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('password') border-red-500 @enderror"
                                       placeholder="Minimal 8 karakter">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Password Confirmation -->
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                                    Konfirmasi Password Baru
                                </label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition-all"
                                       placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.users.index') }}" 
                           class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                            <i class="fas fa-save mr-2"></i>Update User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Preview avatar sebelum upload
    document.getElementById('avatar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                preview.innerHTML = `<img src="${e.target.result}" class="h-16 w-16 rounded-full object-cover">`;
            }
            reader.readAsDataURL(file);
        }
    });
    </script>
@endsection