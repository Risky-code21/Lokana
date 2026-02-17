@extends('layouts.app')

@section('title', 'Transaksi Langganan UMKM')
@section('page-title', 'Transaksi Langganan UMKM')

@section('content')
    @include('components.toast-notification')
    @include('components.confirmation-modal')
    
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Transaksi Langganan UMKM</h1>
        <p class="text-gray-600 mt-2">Kelola dan verifikasi transaksi langganan dari UMKM</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Total Transaksi</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total'] ?? $subscriptions->total() }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-credit-card text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Menunggu</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['pending'] ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Terverifikasi</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['verified'] ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Total Pendapatan</p>
                    <p class="text-3xl font-bold mt-2">Rp {{ number_format($stats['revenue'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="px-6 py-3 border-b">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.subscriptions.index') }}" 
                   class="px-4 py-2 rounded-lg {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors">
                    Semua
                </a>
                <a href="{{ route('admin.subscriptions.index', ['status' => 'pending']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('status') == 'pending' ? 'bg-yellow-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors">
                    Menunggu
                </a>
                <a href="{{ route('admin.subscriptions.index', ['status' => 'verified']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('status') == 'verified' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors">
                    Terverifikasi
                </a>
                <a href="{{ route('admin.subscriptions.index', ['status' => 'expired']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('status') == 'expired' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors">
                    Kadaluarsa
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow">
        <!-- Header -->
        <div class="px-6 py-4 border-b flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Daftar Transaksi Langganan</h2>
                <p class="text-sm text-gray-600 mt-1">
                    Total: <span class="font-semibold">{{ $subscriptions->total() }}</span> transaksi
                    @if(request('search'))
                    | Hasil pencarian: "{{ request('search') }}"
                    @endif
                </p>
            </div>
            
            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <!-- Search -->
                <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="flex">
                    <div class="relative w-full md:w-64">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari UMKM atau paket..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                        @if(request('search') || request('status'))
                        <a href="{{ route('admin.subscriptions.index') }}" 
                           class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                    <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Cari
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Table -->
        <div class="p-6">
            @if($subscriptions->isEmpty())
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-credit-card text-4xl mb-4"></i>
                <p class="text-lg mb-2">Belum ada transaksi langganan</p>
                @if(request('search') || request('status'))
                <p class="text-sm">Coba dengan filter atau kata kunci lain</p>
                @endif
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">UMKM</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paket</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Unik</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($subscriptions as $index => $sub)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ ($subscriptions->currentPage() - 1) * $subscriptions->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-store text-blue-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $sub->umkm->name ?? 'UMKM' }}</div>
                                        <div class="text-sm text-gray-500">{{ $sub->umkm->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $sub->plan->name ?? '-' }}</div>
                                <div class="text-xs text-gray-500">{{ $sub->plan->duration_in_days ?? 0 }} hari</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 font-mono text-sm rounded">
                                    {{ $sub->unique_code }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Rp {{ number_format($sub->total_amount, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($sub->verified_at)
                                    @if($sub->expires_at && $sub->expires_at->isFuture())
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1 text-xs"></i> Aktif
                                    </span>
                                    @elseif($sub->expires_at && $sub->expires_at->isPast())
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-clock mr-1 text-xs"></i> Kadaluarsa
                                    </span>
                                    @endif
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-hourglass-half mr-1 text-xs"></i> Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($sub->starts_at && $sub->expires_at)
                                    {{ $sub->starts_at->format('d/m/Y') }} <br>
                                    <span class="text-xs">s/d {{ $sub->expires_at->format('d/m/Y') }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.subscriptions.show', $sub) }}" 
                                       class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if(!$sub->verified_at)
                                    <a href="{{ route('admin.subscriptions.show', $sub) }}#verify" 
                                       class="text-green-600 hover:text-green-900 p-2 rounded hover:bg-green-50"
                                       title="Verifikasi">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    @endif
                                    
                                    <button onclick="confirmDelete('{{ $sub->id }}', '{{ $sub->umkm->name ?? 'transaksi ini' }}')" 
                                            class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $sub->id }}" 
                                          action="{{ route('admin.subscriptions.destroy', $sub) }}" 
                                          method="POST" 
                                          class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $subscriptions->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>

    <script>
    function confirmDelete(id, name) {
        const deleteUrl = `{{ route('admin.subscriptions.destroy', ':id') }}`.replace(':id', id);
        showConfirmationModal(
            'Konfirmasi Hapus',
            `Apakah Anda yakin ingin menghapus transaksi dari <strong>"${name}"</strong>?`,
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