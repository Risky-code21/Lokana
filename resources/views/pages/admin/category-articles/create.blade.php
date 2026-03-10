@extends('layouts.app')

@section('title', 'Tambah Kategori Artikel')
@section('page-title', 'Tambah Kategori Artikel')

@section('content')
    @include('components.toast-notification')
    
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-800">Tambah Kategori Artikel Baru</h2>
                <p class="text-gray-600 mt-1">Isi form di bawah untuk menambahkan kategori artikel baru</p>
            </div>
            
            <!-- Form -->
            <form action="{{ route('admin.article-categories.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('name') border-red-500 @enderror"
                               placeholder="Contoh: Teknologi, Bisnis, Lifestyle"
                               required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                            Deskripsi <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all @error('description') border-red-500 @enderror"
                                  placeholder="Deskripsi singkat tentang kategori artikel ini"
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Maksimal 500 karakter</p>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.article-categories.index') }}" 
                           class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                            <i class="fas fa-save mr-2"></i>Simpan Kategori
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection