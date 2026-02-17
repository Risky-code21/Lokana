@extends('layouts.app')

@section('title', 'Detail Paket Langganan')
@section('page-title', 'Detail Paket Langganan')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $subscriptionPlan->name }}</h1>
                <p class="text-gray-600 mt-1">Detail informasi paket langganan UMKM</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.subscription-plans.edit', $subscriptionPlan) }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('admin.subscription-plans.index') }}" 
                   class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Plan Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Paket</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Paket</label>
                            <p class="mt-1 text-gray-900 font-medium">{{ $subscriptionPlan->name }}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Harga</label>
                                <p class="mt-1 text-gray-900 font-medium">Rp {{ number_format($subscriptionPlan->price, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Durasi</label>
                                <p class="mt-1 text-gray-900 font-medium">{{ $subscriptionPlan->duration_in_days }} hari</p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Fitur-fitur</label>
                            <div class="mt-2 space-y-2">
                                @foreach(is_array($subscriptionPlan->features) ? $subscriptionPlan->features : json_decode($subscriptionPlan->features, true) ?? [] as $feature)
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Dibuat</label>
                                <p class="mt-1 text-gray-900">{{ $subscriptionPlan->created_at->format('d F Y, H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Diperbarui</label>
                                <p class="mt-1 text-gray-900">{{ $subscriptionPlan->updated_at->format('d F Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Subscribers List Card -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">UMKM Berlangganan</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full">
                            {{ $subscriptionPlan->subscriptions_count ?? 0 }} UMKM
                        </span>
                    </div>
                    <div class="p-6">
                        @if(($subscriptionPlan->subscriptions_count ?? 0) == 0)
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-store text-4xl mb-4"></i>
                            <p>Belum ada UMKM yang berlangganan paket ini</p>
                        </div>
                        @else
                        <div class="space-y-4">
                            @foreach($subscriptionPlan->subscriptions->take(5) as $subscription)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-store text-blue-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">{{ $subscription->umkm->name ?? 'UMKM' }}</p>
                                        <p class="text-xs text-gray-500">
                                            Aktif: {{ $subscription->expires_at ? $subscription->expires_at->format('d/m/Y') : '-' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-sm">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $subscription->expires_at && $subscription->expires_at->isFuture() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $subscription->expires_at && $subscription->expires_at->isFuture() ? 'Aktif' : 'Kadaluarsa' }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                            
                            @if(($subscriptionPlan->subscriptions_count ?? 0) > 5)
                            <div class="text-center pt-4">
                                <a href="{{ route('admin.subscriptions.index', ['plan_id' => $subscriptionPlan->id]) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Lihat semua {{ $subscriptionPlan->subscriptions_count }} transaksi →
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
                            <span class="text-gray-600">Total Pelanggan</span>
                            <span class="font-semibold">{{ $subscriptionPlan->subscriptions_count ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Pelanggan Aktif</span>
                            <span class="font-semibold">{{ $subscriptionPlan->active_subscriptions_count ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Pendapatan</span>
                            <span class="font-semibold">Rp {{ number_format(($subscriptionPlan->subscriptions_count ?? 0) * $subscriptionPlan->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Terakhir Update</span>
                            <span class="font-semibold">{{ $subscriptionPlan->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Actions Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.subscription-plans.edit', $subscriptionPlan) }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition-colors">
                            <i class="fas fa-edit mr-2"></i> Edit Paket
                        </a>
                        
                        @if(($subscriptionPlan->subscriptions_count ?? 0) == 0)
                        <button onclick="confirmDelete('{{ $subscriptionPlan->id }}', '{{ addslashes($subscriptionPlan->name) }}')" 
                                class="w-full flex items-center justify-center px-4 py-2 border border-red-600 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                            <i class="fas fa-trash mr-2"></i> Hapus Paket
                        </button>
                        <form id="delete-form-{{ $subscriptionPlan->id }}" 
                              action="{{ route('admin.subscription-plans.destroy', $subscriptionPlan) }}" 
                              method="POST" 
                              class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                        @else
                        <button disabled
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-400 rounded-lg cursor-not-allowed"
                                title="Tidak dapat dihapus karena sudah digunakan">
                            <i class="fas fa-trash mr-2"></i> Hapus Paket
                        </button>
                        @endif
                        
                        <a href="{{ route('admin.subscription-plans.create') }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                            <i class="fas fa-plus mr-2"></i> Tambah Paket Baru
                        </a>
                    </div>
                </div>
            </div>
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
    </script>
@endsection