@extends('layouts.app')

@section('title', 'Detail User')
@section('page-title', 'Detail User')

@section('content')
    @include('components.toast-notification')
    @include('components.confirmation-modal')
    
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
                <p class="text-gray-600 mt-1">Detail informasi user</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('admin.users.index') }}" 
                   class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: User Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Profile Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="flex-shrink-0">
                            <img class="h-20 w-20 rounded-full object-cover border-4 border-blue-100" 
                                 src="{{ $user->avatar_url }}" 
                                 alt="{{ $user->name }}">
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            <div class="mt-2">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $user->role === 'admin' ? 'Admin' : 'User' }}
                                </span>
                                @if($user->id === auth()->id())
                                <span class="ml-2 px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Akun Anda
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">ID User</label>
                            <p class="mt-1 text-gray-900">{{ $user->id }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Status Verifikasi</label>
                            <p class="mt-1">
                                @if($user->email_verified_at)
                                <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i>Terverifikasi ({{ $user->email_verified_at->format('d/m/Y') }})</span>
                                @else
                                <span class="text-yellow-600"><i class="fas fa-clock mr-1"></i>Belum Terverifikasi</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Bergabung</label>
                            <p class="mt-1 text-gray-900">{{ $user->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Terakhir Update</label>
                            <p class="mt-1 text-gray-900">{{ $user->updated_at->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Activity Card (Placeholder untuk aktivitas user) -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terkini</h3>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-history text-4xl mb-4"></i>
                        <p>Fitur aktivitas user akan segera hadir</p>
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
                            <span class="text-gray-600">Role</span>
                            <span class="font-semibold capitalize">{{ $user->role }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Terakhir Login</span>
                            <span class="font-semibold">{{ $user->last_login_at ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Bergabung</span>
                            <span class="font-semibold">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Actions Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition-colors">
                            <i class="fas fa-edit mr-2"></i> Edit User
                        </a>
                        
                        @if($user->id !== auth()->id())
                        <button onclick="confirmDelete('{{ $user->id }}', '{{ addslashes($user->name) }}')" 
                                class="w-full flex items-center justify-center px-4 py-2 border border-red-600 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                            <i class="fas fa-trash mr-2"></i> Hapus User
                        </button>
                        <form id="delete-form-{{ $user->id }}" 
                              action="{{ route('admin.users.destroy', $user) }}" 
                              method="POST" 
                              class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                        @else
                        <button disabled
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-400 rounded-lg cursor-not-allowed">
                            <i class="fas fa-trash mr-2"></i> Tidak Dapat Hapus
                        </button>
                        @endif
                        
                        <a href="{{ route('admin.users.create') }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                            <i class="fas fa-plus mr-2"></i> Tambah User Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function confirmDelete(id, name) {
        showConfirmationModal(
            'Konfirmasi Hapus',
            `Apakah Anda yakin ingin menghapus user <strong>"${name}"</strong>?`,
            `{{ route('admin.users.destroy', ':id') }}`.replace(':id', id),
            name
        );
    }
    </script>
@endsection