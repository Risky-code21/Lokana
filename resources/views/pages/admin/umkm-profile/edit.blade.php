{{-- resources/views/pages/admin/umkm-profile/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit UMKM')
@section('page-title', 'Edit UMKM: ' . $umkmProfile->name)

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Form Edit UMKM</h2>
            <p class="text-sm text-gray-600 mt-1">Update data UMKM</p>
        </div>
        <div class="flex gap-2">
            <!-- Status Badges -->
            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                {{ $umkmProfile->profile_status == 'published' ? 'bg-green-100 text-green-800' : 
                   ($umkmProfile->profile_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                   ($umkmProfile->profile_status == 'archived' ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800')) }}">
                <i class="fas fa-circle mr-1 text-xs"></i>
                Status: {{ ucfirst($umkmProfile->profile_status) }}
            </span>
            
            <span class="px-3 py-1 text-sm font-semibold rounded-full
                {{ $umkmProfile->verification_status == 'verified' ? 'bg-green-100 text-green-800' : 
                   ($umkmProfile->verification_status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                <i class="fas fa-shield-alt mr-1"></i>
                Verifikasi: {{ ucfirst($umkmProfile->verification_status) }}
            </span>
        </div>
    </div>

    <form action="{{ route('admin.umkm-profiles.update', $umkmProfile) }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')
        
        <!-- Progress Steps (sama dengan create) -->
        <div class="mb-8">
            <!-- ... sama dengan create ... -->
        </div>

        <!-- Bagian 1: Informasi Dasar -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Dasar UMKM</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama UMKM -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama UMKM <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $umkmProfile->name) }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama UMKM"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tahun Berdiri -->
                <div>
                    <label for="tahun_berdiri" class="block text-sm font-medium text-gray-700 mb-2">
                        Tahun Berdiri <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="tahun_berdiri" 
                           id="tahun_berdiri" 
                           value="{{ old('tahun_berdiri', $umkmProfile->tahun_berdiri) }}"
                           min="1900" 
                           max="{{ date('Y') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('tahun_berdiri') border-red-500 @enderror"
                           placeholder="Contoh: 2020"
                           required>
                    @error('tahun_berdiri')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pemilik UMKM (Pelaku UMKM) -->
                <div>
                    <label for="pelaku_umkm" class="block text-sm font-medium text-gray-700 mb-2">
                        Pemilik UMKM <span class="text-red-500">*</span>
                    </label>
                    <select name="pelaku_umkm" 
                            id="pelaku_umkm" 
                            class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('pelaku_umkm') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Pemilik UMKM</option>
                        {{-- UBAH dari $users menjadi $pelakuUmkm --}}
                        @foreach($pelakuUmkm as $artisan)
                        <option value="{{ $artisan->id }}" {{ old('pelaku_umkm', $umkmProfile->pelaku_umkm) == $artisan->id ? 'selected' : '' }}>
                            {{ $artisan->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('pelaku_umkm')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Nama Pemilik (Contact Person) -->
                <div>
                    <label for="nama_pemilik" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Pemilik (Contact Person) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama_pemilik" 
                           id="nama_pemilik" 
                           value="{{ old('nama_pemilik', $umkmProfile->nama_pemilik) }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('nama_pemilik') border-red-500 @enderror"
                           placeholder="Masukkan nama pemilik"
                           required>
                    @error('nama_pemilik')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori UMKM -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori UMKM <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" 
                            id="category_id" 
                            class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('category_id') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $umkmProfile->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Short Description -->
                <div class="md:col-span-2">
                    <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Singkat <span class="text-red-500">*</span>
                    </label>
                    <textarea name="short_description" 
                              id="short_description" 
                              rows="2"
                              class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('short_description') border-red-500 @enderror"
                              placeholder="Deskripsi singkat tentang UMKM (maks 255 karakter)"
                              required>{{ old('short_description', $umkmProfile->short_description) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Maksimal 255 karakter</p>
                    @error('short_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content (Full Story) -->
                <div class="md:col-span-2">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Story / Deskripsi Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" 
                              id="content" 
                              rows="6"
                              class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('content') border-red-500 @enderror"
                              placeholder="Cerita lengkap tentang UMKM"
                              required>{{ old('content', $umkmProfile->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Bagian 2: Kontak & Lokasi (sama dengan create, tapi dengan old value) -->
        <!-- ... (sama seperti create, tapi value pakai old('field', $umkmProfile->field)) ... -->

        <!-- Bagian 3: Media & SEO dengan preview existing files -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Media & SEO</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Logo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Logo UMKM
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            @if($umkmProfile->logo)
                            <div id="logo-preview" class="mb-3">
                                <img src="{{ $umkmProfile->logo }}" alt="Logo" class="mx-auto h-24 w-24 object-cover rounded-lg">
                                <button type="button" onclick="removeExistingFile('logo')" class="mt-2 text-xs text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash mr-1"></i>Hapus logo
                                </button>
                                <input type="hidden" name="existing_logo" value="{{ $umkmProfile->logo }}">
                            </div>
                            @else
                            <div id="logo-preview" class="hidden mb-3"></div>
                            @endif
                            
                            <div id="logo-new-preview" class="hidden mb-3">
                                <img src="" alt="Logo preview" class="mx-auto h-24 w-24 object-cover rounded-lg">
                            </div>
                            
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="logo-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                    <span>Ganti logo</span>
                                    <input id="logo-upload" name="logo" type="file" class="sr-only" accept="image/*" onchange="previewNewImage(this, 'logo-preview', 'logo-new-preview')">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, JPEG maksimal 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Thumbnail dengan preview existing -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Thumbnail
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            @if($umkmProfile->thumbnail)
                            <div id="thumbnail-preview" class="mb-3">
                                <img src="{{ $umkmProfile->thumbnail }}" alt="Thumbnail" class="mx-auto h-24 w-24 object-cover rounded-lg">
                                <button type="button" onclick="removeExistingFile('thumbnail')" class="mt-2 text-xs text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash mr-1"></i>Hapus thumbnail
                                </button>
                                <input type="hidden" name="existing_thumbnail" value="{{ $umkmProfile->thumbnail }}">
                            </div>
                            @else
                            <div id="thumbnail-preview" class="hidden mb-3"></div>
                            @endif
                            
                            <div id="thumbnail-new-preview" class="hidden mb-3">
                                <img src="" alt="Thumbnail preview" class="mx-auto h-24 w-24 object-cover rounded-lg">
                            </div>
                            
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="thumbnail-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                    <span>Ganti thumbnail</span>
                                    <input id="thumbnail-upload" name="thumbnail" type="file" class="sr-only" accept="image/*" onchange="previewNewImage(this, 'thumbnail-preview', 'thumbnail-new-preview')">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, JPEG maksimal 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Images dengan preview existing -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Gallery Images (Maksimal 5 foto)
                    </label>
                    
                    @if(!empty($umkmProfile->gallery_images))
                    <div class="mb-3">
                        <p class="text-sm text-gray-600 mb-2">Gallery saat ini:</p>
                        <div class="grid grid-cols-5 gap-2">
                            @foreach($umkmProfile->gallery_images as $index => $image)
                            <div class="relative" id="existing-gallery-{{ $index }}">
                                <img src="{{ $image }}" class="h-16 w-16 object-cover rounded-lg">
                                <button type="button" onclick="removeExistingGallery({{ $index }})" 
                                        class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs hover:bg-red-600">
                                    ×
                                </button>
                                <input type="hidden" name="existing_gallery[]" value="{{ $image }}" id="gallery-input-{{ $index }}">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            <div id="gallery-preview" class="grid grid-cols-5 gap-2 mb-3 hidden"></div>
                            
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="gallery-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                    <span>Tambah gallery</span>
                                    <input id="gallery-upload" name="gallery_images[]" type="file" class="sr-only" accept="image/*" multiple onchange="previewGallery(this)">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">Upload untuk menambah gallery baru</p>
                        </div>
                    </div>
                </div>

                <!-- Meta fields (sama dengan create) -->
                <!-- ... -->
            </div>
        </div>

        <!-- Bagian 4: Subscription dengan status -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Subscription & Pembayaran</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Subscription Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Subscription</label>
                    <div class="p-3 bg-white rounded-lg border">
                        <span class="px-3 py-1 text-sm font-semibold rounded-full
                            {{ $umkmProfile->subscription_status == 'active' ? 'bg-green-100 text-green-800' : 
                               ($umkmProfile->subscription_status == 'expired' ? 'bg-red-100 text-red-800' : 
                               ($umkmProfile->subscription_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                            {{ ucfirst($umkmProfile->subscription_status) }}
                        </span>
                        
                        @if($umkmProfile->subscription_start_date && $umkmProfile->subscription_end_date)
                        <div class="mt-2 text-xs text-gray-600">
                            <div>Mulai: {{ $umkmProfile->subscription_start_date->format('d/m/Y') }}</div>
                            <div>Berakhir: {{ $umkmProfile->subscription_end_date->format('d/m/Y') }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Subscription Plan -->
                <div>
                    <label for="subscription_plan_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Ganti Paket Subscription
                    </label>
                    <select name="subscription_plan_id" 
                            id="subscription_plan_id" 
                            class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Pilih Paket (Kosongkan jika tidak ganti)</option>
                        @foreach($subscriptionPlans as $plan)
                        <option value="{{ $plan->id }}" {{ old('subscription_plan_id') == $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }} - Rp {{ number_format($plan->price, 0, ',', '.') }} ({{ $plan->duration_days }} hari)
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Payment Proof -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Bukti Pembayaran
                    </label>
                    @if($umkmProfile->payment_proof)
                    <div class="mb-2">
                        <a href="{{ $umkmProfile->payment_proof }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                            <i class="fas fa-file-pdf mr-1"></i>Lihat bukti pembayaran
                        </a>
                    </div>
                    @endif
                    
                    <input type="file" name="payment_proof" class="w-full text-sm" accept="image/*,application/pdf">
                </div>
            </div>
        </div>

        <!-- Status Update (Admin Only) -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Status (Admin)</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Profile Status -->
                <div>
                    <label for="profile_status" class="block text-sm font-medium text-gray-700 mb-2">
                        Profile Status
                    </label>
                    <select name="profile_status" id="profile_status" class="w-full border-gray-300 rounded-lg">
                        <option value="draft" {{ $umkmProfile->profile_status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="pending" {{ $umkmProfile->profile_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="published" {{ $umkmProfile->profile_status == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ $umkmProfile->profile_status == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <!-- Verification Status -->
                <div>
                    <label for="verification_status" class="block text-sm font-medium text-gray-700 mb-2">
                        Verification Status
                    </label>
                    <select name="verification_status" id="verification_status" class="w-full border-gray-300 rounded-lg">
                        <option value="pending" {{ $umkmProfile->verification_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="verified" {{ $umkmProfile->verification_status == 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="rejected" {{ $umkmProfile->verification_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <!-- Featured -->
                <div>
                    <label for="is_featured" class="block text-sm font-medium text-gray-700 mb-2">
                        Featured
                    </label>
                    <div class="flex items-center h-10">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" 
                               {{ $umkmProfile->is_featured ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="is_featured" class="ml-2 text-sm text-gray-700">
                            Jadikan featured UMKM
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end gap-3 pt-4 border-t">
            <a href="{{ route('admin.umkm-profiles.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <a href="{{ route('admin.umkm-profiles.show', $umkmProfile) }}" 
               class="px-6 py-2 border border-blue-300 text-blue-600 rounded-lg hover:bg-blue-50">
                <i class="fas fa-eye mr-2"></i>Lihat Detail
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i>Update UMKM
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Fungsi-fungsi JavaScript untuk preview dan remove (sama dengan create, ditambah fungsi untuk existing files)
function previewNewImage(input, oldPreviewId, newPreviewId) {
    const oldPreview = document.getElementById(oldPreviewId);
    const newPreview = document.getElementById(newPreviewId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            newPreview.querySelector('img').src = e.target.result;
            newPreview.classList.remove('hidden');
            if (oldPreview) oldPreview.style.display = 'none';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removeExistingFile(type) {
    const container = document.getElementById(type + '-preview');
    const input = document.getElementById(type + '-upload');
    const hiddenInput = document.querySelector(`input[name="existing_${type}"]`);
    
    container.style.display = 'none';
    if (hiddenInput) hiddenInput.value = '';
    if (input) input.value = '';
}

function removeExistingGallery(index) {
    const element = document.getElementById(`existing-gallery-${index}`);
    const input = document.getElementById(`gallery-input-${index}`);
    
    if (element) element.remove();
    if (input) input.value = '';
}
</script>
@endpush
@endsection