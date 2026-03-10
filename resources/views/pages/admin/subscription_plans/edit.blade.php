@extends('layouts.app')

@section('title', 'Edit Paket Langganan')
@section('page-title', 'Edit Paket Langganan')

@section('content')
    @include('components.toast-notification')
    
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-800">Edit Paket Langganan</h2>
                <p class="text-gray-600 mt-1">Ubah informasi paket langganan "{{ $subscriptionPlan->name }}"</p>
            </div>
            
            <!-- Form -->
            <form action="{{ route('admin.subscription-plans.update', $subscriptionPlan) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Nama Paket *
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name', $subscriptionPlan->name) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                               placeholder="Contoh: Paket Basic UMKM"
                               required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price and Duration Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Price -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="price">
                                Harga (Rp) *
                            </label>
                            <input type="number" 
                                   name="price" 
                                   id="price"
                                   value="{{ old('price', $subscriptionPlan->price) }}"
                                   min="0"
                                   step="1000"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                                   placeholder="100000"
                                   required>
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="duration_in_days">
                                Durasi (Hari) *
                            </label>
                            <input type="number" 
                                   name="duration_in_days" 
                                   id="duration_in_days"
                                   value="{{ old('duration_in_days', $subscriptionPlan->duration_in_days) }}"
                                   min="1"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                                   placeholder="30"
                                   required>
                            @error('duration_in_days')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Features -->
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Fitur-fitur *
                        </label>
                        <div id="features-container" class="space-y-2">
                            @php
    $features = old('features', is_array($subscriptionPlan->features) ? $subscriptionPlan->features : json_decode($subscriptionPlan->features, true) ?? []);
@endphp
@foreach($features as $index => $feature)
                            <div class="flex items-center gap-2 feature-row">
                                <input type="text" 
                                       name="features[]" 
                                       value="{{ $feature }}"
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                                       placeholder="Contoh: Manajemen Stok"
                                       required>
                                <button type="button" 
                                        onclick="removeFeature(this)"
                                        class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            @endforeach
                        </div>
                        
                        <button type="button" 
                                onclick="addFeature()"
                                class="mt-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center">
                            <i class="fas fa-plus mr-2"></i>Tambah Fitur
                        </button>
                        
                        @error('features')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.subscription-plans.index') }}" 
                           class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                            <i class="fas fa-save mr-2"></i>Update Paket
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function addFeature() {
            const container = document.getElementById('features-container');
            const newRow = document.createElement('div');
            newRow.className = 'flex items-center gap-2 feature-row';
            newRow.innerHTML = `
                <input type="text" 
                       name="features[]" 
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                       placeholder="Contoh: Manajemen Stok"
                       required>
                <button type="button" 
                        onclick="removeFeature(this)"
                        class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(newRow);
        }

        function removeFeature(button) {
            const rows = document.querySelectorAll('.feature-row');
            if (rows.length > 1) {
                button.closest('.feature-row').remove();
            } else {
                alert('Minimal harus ada 1 fitur');
            }
        }
    </script>
@endsection