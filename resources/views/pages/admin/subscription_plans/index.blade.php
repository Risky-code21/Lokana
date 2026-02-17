@extends('layouts.app')

@section('title', 'Paket Langganan UMKM')
@section('page-title', 'Paket Langganan UMKM')

@section('content')
    @include('components.toast-notification')
    @include('components.confirmation-modal')
    
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Paket Langganan UMKM</h1>
        <p class="text-gray-600 mt-2">Kelola paket langganan untuk pelaku UMKM</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Total Paket</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total'] ?? $plans->total() }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-tags text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Paket Aktif</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['active'] ?? $plans->count() }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Total Transaksi</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_transactions'] ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-credit-card text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Pendapatan</p>
                    <p class="text-3xl font-bold mt-2">Rp {{ number_format($stats['revenue'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="px-6 py-4 border-b flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Daftar Paket Langganan</h2>
                <p class="text-sm text-gray-600 mt-1">
                    Total: <span class="font-semibold">{{ $plans->total() }}</span> paket
                    @if(request('search'))
                    | Hasil pencarian: "{{ request('search') }}"
                    @endif
                </p>
            </div>
            
            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <!-- Search -->
                <form method="GET" action="{{ route('admin.subscription-plans.index') }}" class="flex">
                    <div class="relative w-full md:w-64">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari nama paket..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                        @if(request('search'))
                        <a href="{{ route('admin.subscription-plans.index') }}" 
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
                <a href="{{ route('admin.subscription-plans.create') }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center whitespace-nowrap">
                    <i class="fas fa-plus mr-2"></i> Tambah Paket
                </a>
            </div>
        </div>
        
        <!-- Table -->
        <div class="p-6">
            @if($plans->isEmpty())
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-box-open text-4xl mb-4"></i>
                <p class="text-lg mb-2">Belum ada paket langganan</p>
                @if(request('search'))
                <p class="text-sm">Coba dengan kata kunci lain</p>
                @else
                <a href="{{ route('admin.subscription-plans.create') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                    Tambah paket pertama
                </a>
                @endif
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Paket</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fitur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemakaian</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($plans as $index => $plan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ ($plans->currentPage() - 1) * $plans->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-crown text-blue-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $plan->name }}</div>
                                        <div class="text-sm text-gray-500">ID: {{ $plan->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Rp {{ number_format($plan->price, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $plan->duration_in_days }} hari</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs">
                                   @foreach(is_array($plan->features) ? $plan->features : json_decode($plan->features, true) ?? [] as $feature)
                                        <span class="inline-flex items-center mr-2 mb-1">
                                            <i class="fas fa-check text-green-500 text-xs mr-1"></i>
                                            {{ Str::limit($feature, 20) }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $plan->subscriptions_count ?? 0 }} UMKM
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $plan->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.subscription-plans.show', $plan) }}" 
                                       class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.subscription-plans.edit', $plan) }}" 
                                       class="text-green-600 hover:text-green-900 p-2 rounded hover:bg-green-50"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if(($plan->subscriptions_count ?? 0) == 0)
                                    <button onclick="confirmDelete('{{ $plan->id }}', '{{ addslashes($plan->name) }}')" 
                                            class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $plan->id }}" 
                                          action="{{ route('admin.subscription-plans.destroy', $plan) }}" 
                                          method="POST" 
                                          class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @else
                                    <span class="text-gray-400 p-2" title="Tidak dapat dihapus karena sudah digunakan">
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
                {{ $plans->links() }}
            </div>
            @endif
        </div>
    </div>

    <script>
    function confirmDelete(id, name) {
        const deleteUrl = `{{ route('admin.subscription-plans.destroy', ':id') }}`.replace(':id', id);
        showConfirmationModal(
            'Konfirmasi Hapus',
            `Apakah Anda yakin ingin menghapus paket <strong>"${name}"</strong>?`,
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