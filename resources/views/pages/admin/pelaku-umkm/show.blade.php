@extends('layouts.app')

@section('title', 'Detail Pelaku UMKM')
@section('page-title', 'Detail Pelaku UMKM')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Detail Pelaku UMKM</h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.pelaku-umkm.edit', $pelakuUmkm) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('admin.pelaku-umkm.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                    Kembali
                </a>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Info Dasar -->
                <div class="space-y-4">
                    <div class="border-b pb-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Nama</label>
                                <p class="mt-1 text-gray-900">{{ $pelakuUmkm->name }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500">Email</label>
                                <p class="mt-1 text-gray-900">{{ $pelakuUmkm->email }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500">Telepon</label>
                                <p class="mt-1 text-gray-900">{{ $pelakuUmkm->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Info Tambahan -->
                <div class="space-y-4">
                    <div class="border-b pb-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Alamat Lengkap</label>
                                <p class="mt-1 text-gray-900 whitespace-pre-line">{{ $pelakuUmkm->address }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500">Tanggal Dibuat</label>
                                <p class="mt-1 text-gray-900">{{ $pelakuUmkm->created_at->format('d M Y H:i') }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500">Terakhir Diperbarui</label>
                                <p class="mt-1 text-gray-900">{{ $pelakuUmkm->updated_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="mt-6 pt-6 border-t flex justify-between">
                <form action="{{ route('admin.pelaku-umkm.destroy', $pelakuUmkm) }}" method="POST" onsubmit="return confirm('Hapus pelaku UMKM ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i> Hapus
                    </button>
                </form>
                
                <div class="flex space-x-3">
                    <a href="{{ route('admin.pelaku-umkm.edit', $pelakuUmkm) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i> Edit Data
                    </a>
                    <a href="{{ route('admin.pelaku-umkm.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        <i class="fas fa-plus mr-2"></i> Tambah Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection