@extends('layouts.app')

@section('title', 'Kategori Artikel')
@section('page-title', 'Kategori Artikel')

@section('content')
    @include('components.toast-notification')
    @include('components.confirmation-modal')

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Kategori Artikel</h1>
        <p class="text-gray-600 mt-2">Kelola kategori untuk artikel</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Total Kategori</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-tags text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Terisi Artikel</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['with_articles'] ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-newspaper text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Kosong</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['empty'] ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-box-open text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="px-6 py-4 border-b flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Daftar Kategori Artikel</h2>
                <p class="text-sm text-gray-600 mt-1">
                    Total: <span class="font-semibold">{{ $categories->total() }}</span> kategori
                    @if(request('search'))
                    | Hasil pencarian: "{{ request('search') }}"
                    @endif
                </p>
            </div>
            
            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <!-- Search -->
                <form method="GET" action="{{ route('admin.article-categories.index') }}" class="flex">
                    <div class="relative w-full md:w-64">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari nama kategori..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                        @if(request('search'))
                        <a href="{{ route('admin.article-categories.index') }}" 
                           class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                    <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Cari
                    </button>
                </form>
                
                <!-- Create Button -->
                <a href="{{ route('admin.article-categories.create') }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center whitespace-nowrap">
                    <i class="fas fa-plus mr-2"></i> Tambah Kategori
                </a>
            </div>
        </div>
        
        <!-- Table -->
        <div class="p-6">
            @if($categories->isEmpty())
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-tags text-4xl mb-4"></i>
                <p class="text-lg mb-2">Belum ada data kategori</p>
                @if(request('search'))
                <p class="text-sm">Coba dengan kata kunci lain</p>
                @endif
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Artikel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($categories as $index => $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-tag text-blue-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                        <div class="text-sm text-gray-500">ID: {{ $category->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $category->description }}">
                                    {{ Str::limit($category->description, 60) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $category->articles_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $category->articles_count }} Artikel
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $category->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.article-categories.show', $category) }}" 
                                       class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.article-categories.edit', $category) }}" 
                                       class="text-green-600 hover:text-green-900 p-2 rounded hover:bg-green-50"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if($category->articles_count == 0)
                                    <button onclick="confirmDelete('{{ $category->id }}', '{{ addslashes($category->name) }}')" 
                                            class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $category->id }}" 
                                          action="{{ route('admin.article-categories.destroy', $category) }}" 
                                          method="POST" 
                                          class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @else
                                    <span class="text-gray-400 p-2" title="Tidak dapat dihapus karena memiliki artikel">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $categories->links() }}
            </div>
            @endif
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