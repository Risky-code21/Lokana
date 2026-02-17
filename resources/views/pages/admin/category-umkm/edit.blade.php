@extends('layouts.app')

@section('title', 'Edit Kategori UMKM')
@section('page-title', 'Edit Kategori UMKM')

@section('content')
    @include('components.toast-notification')
    
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-800">Edit Kategori UMKM</h2>
                <p class="text-gray-600 mt-1">Perbarui data kategori {{ $category_umkm->name }}</p>
            </div>
            
            <!-- Form -->
            <form action="{{ route('admin.category-umkm.update', $category_umkm) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Nama Kategori *
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name', $category_umkm->name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                               required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                            Deskripsi *
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                                  required>{{ old('description', $category_umkm->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Info -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Kategori ini memiliki 
                                    <span class="font-semibold">{{ $category_umkm->total_umkm }}</span> 
                                    data UMKM.
                                    @if($category_umkm->total_umkm > 0)
                                    Perubahan akan mempengaruhi semua UMKM dalam kategori ini.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.category-umkm.index') }}" 
                           class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>Batal
                        </a>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection