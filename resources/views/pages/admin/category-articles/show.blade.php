@extends('layouts.app')

@section('title', 'Detail Kategori Artikel')
@section('page-title', 'Detail Kategori Artikel')

@section('content')
    @include('components.toast-notification')
    @include('components.confirmation-modal')
    
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $category->name }}</h1>
                <p class="text-gray-600 mt-1">Detail informasi kategori artikel</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.article-categories.edit', $category) }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('admin.article-categories.index') }}" 
                   class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Category Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Kategori</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Kategori</label>
                            <p class="mt-1 text-gray-900 font-medium">{{ $category->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Deskripsi</label>
                            <p class="mt-1 text-gray-900">{{ $category->description }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Dibuat</label>
                                <p class="mt-1 text-gray-900">{{ $category->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Diperbarui</label>
                                <p class="mt-1 text-gray-900">{{ $category->updated_at->format('d F Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Articles List Card -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Artikel dalam Kategori</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">
                            {{ $category->articles_count }} Artikel
                        </span>
                    </div>
                    <div class="p-6">
                        @if($category->articles->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-newspaper text-4xl mb-4"></i>
                            <p>Belum ada artikel dalam kategori ini</p>
                        </div>
                        @else
                        <div class="space-y-4">
                            @foreach($category->articles as $article)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-newspaper text-blue-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">{{ $article->title }}</p>
                                        <p class="text-xs text-gray-500">
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-user mr-1"></i>{{ $article->author ?? 'Admin' }}
                                            </span>
                                            <span class="mx-2">•</span>
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-calendar mr-1"></i>{{ $article->created_at->format('d/m/Y') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $article->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $article->status ?? 'Draft' }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                            
                            @if($category->articles_count > 10)
                            <div class="text-center pt-4">
                                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Lihat semua {{ $category->articles_count }} artikel →
                                </a>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Stats & Actions -->
            <div class="space-y-6">
                <!-- Stats Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Artikel</span>
                            <span class="font-semibold">{{ $category->articles_count }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Terakhir Update</span>
                            <span class="font-semibold">{{ $category->updated_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status</span>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $category->articles_count > 0 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $category->articles_count > 0 ? 'Aktif' : 'Kosong' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Actions Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.article-categories.edit', $category) }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition-colors">
                            <i class="fas fa-edit mr-2"></i> Edit Kategori
                        </a>
                        
                        @if($category->articles_count == 0)
                        <button onclick="confirmDelete('{{ $category->id }}', '{{ addslashes($category->name) }}')" 
                                class="w-full flex items-center justify-center px-4 py-2 border border-red-600 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                            <i class="fas fa-trash mr-2"></i> Hapus Kategori
                        </button>
                        <form id="delete-form-{{ $category->id }}" 
                              action="{{ route('admin.article-categories.destroy', $category) }}" 
                              method="POST" 
                              class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                        @else
                        <button disabled
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-400 rounded-lg cursor-not-allowed"
                                title="Tidak dapat dihapus karena memiliki artikel">
                            <i class="fas fa-trash mr-2"></i> Hapus Kategori
                        </button>
                        @endif
                        
                        <a href="{{ route('admin.article-categories.create') }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                            <i class="fas fa-plus mr-2"></i> Tambah Kategori Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function confirmDelete(id, name) {
        const deleteUrl = `{{ route('admin.article-categories.destroy', ':id') }}`.replace(':id', id);
        showConfirmationModal(
            'Konfirmasi Hapus',
            `Apakah Anda yakin ingin menghapus kategori <strong>"${name}"</strong>?`,
            deleteUrl,
            name
        );
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('deleteForm');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const actionUrl = this.action;
                const id = actionUrl.split('/').pop();
                const form = document.getElementById(`delete-form-${id}`);
                
                if (form) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menghapus...';
                    submitBtn.disabled = true;
                    form.submit();
                }
            });
        }
    });
    </script>
@endsection