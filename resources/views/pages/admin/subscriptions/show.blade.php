@extends('layouts.app')

@section('title', 'Detail Transaksi Langganan')
@section('page-title', 'Detail Transaksi Langganan')

@section('content')
    @include('components.toast-notification')
    
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Transaksi Langganan</h1>
                <p class="text-gray-600 mt-1">Kode Unik: <span class="font-mono font-semibold">{{ $subscription->unique_code }}</span></p>
            </div>
            <div class="flex space-x-2">
                @if(!$subscription->verified_at)
                <button onclick="document.getElementById('verifyForm').classList.toggle('hidden')" 
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> Verifikasi
                </button>
                @endif
                <a href="{{ route('admin.subscriptions.index') }}" 
                   class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Verification Form (hidden by default) -->
        @if(!$subscription->verified_at)
        <div id="verifyForm" class="hidden mb-6">
            <div class="bg-white rounded-lg shadow p-6 border-2 border-green-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Verifikasi Pembayaran</h3>
                <form action="{{ route('admin.subscriptions.verify', $subscription) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="admin_notes">
                            Catatan Admin
                        </label>
                        <textarea name="admin_notes" 
                                  id="admin_notes" 
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                                  placeholder="Tambahkan catatan verifikasi (opsional)">{{ old('admin_notes') }}</textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="document.getElementById('verifyForm').classList.add('hidden')"
                                class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center">
                            <i class="fas fa-check mr-2"></i> Konfirmasi Verifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
        
        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- UMKM Info Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi UMKM</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-store text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-lg font-medium text-gray-900">{{ $subscription->umkm->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-500">{{ $subscription->umkm->email ?? '-' }}</p>
                                <p class="text-sm text-gray-500">{{ $subscription->umkm->phone ?? '-' }}</p>
                            </div>
                        </div>
                        @if($subscription->umkm && $subscription->umkm->address)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Alamat</label>
                            <p class="mt-1 text-gray-700">{{ $subscription->umkm->address }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Paket Info Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Paket</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nama Paket</label>
                            <p class="mt-1 text-gray-900 font-medium">{{ $subscription->plan->name ?? '-' }}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Harga Paket</label>
                                <p class="mt-1 text-gray-900 font-medium">Rp {{ number_format($subscription->plan->price ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Durasi</label>
                                <p class="mt-1 text-gray-900 font-medium">{{ $subscription->plan->duration_in_days ?? 0 }} hari</p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Fitur-fitur</label>
                            <div class="mt-2 space-y-2">
                                @foreach($subscription->plan->features ?? [] as $feature)
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Payment & Status -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Transaksi</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Status</span>
                            @if($subscription->verified_at)
                                @if($subscription->expires_at && $subscription->expires_at->isFuture())
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                    Aktif
                                </span>
                                @elseif($subscription->expires_at && $subscription->expires_at->isPast())
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">
                                    Kadaluarsa
                                </span>
                                @endif
                            @else
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                                    Menunggu Verifikasi
                                </span>
                            @endif
                        </div>
                        
                        @if($subscription->verified_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Diverifikasi Oleh</label>
                            <p class="mt-1 text-gray-900">{{ $subscription->verifiedBy->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-500">{{ $subscription->verified_at->format('d F Y, H:i') }}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Mulai Aktif</label>
                                <p class="mt-1 text-gray-900">{{ $subscription->starts_at->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Berakhir</label>
                                <p class="mt-1 text-gray-900">{{ $subscription->expires_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Info Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pembayaran</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kode Unik</span>
                            <span class="font-mono font-semibold bg-gray-100 px-3 py-1 rounded">{{ $subscription->unique_code }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Bayar</span>
                            <span class="font-semibold text-lg">Rp {{ number_format($subscription->total_amount, 0, ',', '.') }}</span>
                        </div>
                        
                        @if($subscription->payment_proof)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Bukti Transfer</label>
                            <a href="{{ Storage::url($subscription->payment_proof) }}" 
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-image mr-2"></i> Lihat Bukti
                            </a>
                        </div>
                        @endif
                        
                        <div class="text-xs text-gray-500 pt-2">
                            Dibuat: {{ $subscription->created_at->format('d F Y, H:i') }}
                        </div>
                    </div>
                </div>

                <!-- Admin Notes Card -->
                @if($subscription->admin_notes)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Catatan Admin</h3>
                    <p class="text-gray-700">{{ $subscription->admin_notes }}</p>
                </div>
                @endif

                <!-- Actions Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
                    <div class="space-y-3">
                        @if(!$subscription->verified_at)
                        <button onclick="document.getElementById('verifyForm').classList.toggle('hidden')" 
                                class="w-full flex items-center justify-center px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition-colors">
                            <i class="fas fa-check-circle mr-2"></i> Verifikasi Pembayaran
                        </button>
                        @endif
                        
                        <button onclick="confirmDelete('{{ $subscription->id }}', '{{ $subscription->umkm->name ?? 'transaksi ini' }}')" 
                                class="w-full flex items-center justify-center px-4 py-2 border border-red-600 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                            <i class="fas fa-trash mr-2"></i> Hapus Transaksi
                        </button>
                        <form id="delete-form-{{ $subscription->id }}" 
                              action="{{ route('admin.subscriptions.destroy', $subscription) }}" 
                              method="POST" 
                              class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                        
                        <a href="{{ route('admin.subscriptions.index') }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-gray-600 text-gray-600 rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
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
    </script>
@endsection