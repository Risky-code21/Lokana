{{-- resources/views/pages/admin/umkm-profile/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah UMKM')
@section('page-title', 'Tambah UMKM Baru')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Form Tambah UMKM</h2>
        <p class="text-sm text-gray-600 mt-1">Lengkapi data UMKM dengan benar</p>
    </div>

    <form action="{{ route('admin.umkm-profiles.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold">1</div>
                        <div class="ml-2">
                            <p class="text-sm font-medium text-gray-900">Informasi Dasar</p>
                            <p class="text-xs text-gray-500">Data utama UMKM</p>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-semibold">2</div>
                        <div class="ml-2">
                            <p class="text-sm font-medium text-gray-500">Kontak & Lokasi</p>
                            <p class="text-xs text-gray-400">Info kontak dan alamat</p>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-semibold">3</div>
                        <div class="ml-2">
                            <p class="text-sm font-medium text-gray-500">Media & SEO</p>
                            <p class="text-xs text-gray-400">Gambar dan pengaturan SEO</p>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-semibold">4</div>
                        <div class="ml-2">
                            <p class="text-sm font-medium text-gray-500">Subscription</p>
                            <p class="text-xs text-gray-400">Paket dan pembayaran</p>
                        </div>
                    </div>
                </div>
            </div>
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
                           value="{{ old('name') }}"
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
                           value="{{ old('tahun_berdiri') }}"
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
                            <option value="{{ $artisan->id }}">{{ $artisan->name }}</option>
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
                           value="{{ old('nama_pemilik') }}"
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
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                              required>{{ old('short_description') }}</textarea>
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
                              required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Bagian 2: Kontak & Lokasi -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Kontak & Lokasi</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- WhatsApp Number -->
                <div>
                    <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                            +62
                        </span>
                        <input type="text" 
                               name="whatsapp_number" 
                               id="whatsapp_number" 
                               value="{{ old('whatsapp_number') }}"
                               class="flex-1 border-gray-300 rounded-r-lg focus:border-blue-500 focus:ring-blue-500 @error('whatsapp_number') border-red-500 @enderror"
                               placeholder="81234567890"
                               required>
                    </div>
                    @error('whatsapp_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Person Phone -->
                <div>
                    <label for="contact_person_phone" class="block text-sm font-medium text-gray-700 mb-2">
                        No. Telepon Contact Person <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="contact_person_phone" 
                           id="contact_person_phone" 
                           value="{{ old('contact_person_phone') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('contact_person_phone') border-red-500 @enderror"
                           placeholder="Contoh: 021-12345678"
                           required>
                    @error('contact_person_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email UMKM -->
                <div>
                    <label for="email_umkm" class="block text-sm font-medium text-gray-700 mb-2">
                        Email UMKM
                    </label>
                    <input type="email" 
                           name="email_umkm" 
                           id="email_umkm" 
                           value="{{ old('email_umkm') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('email_umkm') border-red-500 @enderror"
                           placeholder="umkm@example.com">
                    @error('email_umkm')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Website -->
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                        Website
                    </label>
                    <input type="url" 
                           name="website" 
                           id="website" 
                           value="{{ old('website') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('website') border-red-500 @enderror"
                           placeholder="https://example.com">
                    @error('website')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Instagram Link -->
                <div>
                    <label for="instagram_link" class="block text-sm font-medium text-gray-700 mb-2">
                        Instagram
                    </label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                            @
                        </span>
                        <input type="text" 
                               name="instagram_link" 
                               id="instagram_link" 
                               value="{{ old('instagram_link') }}"
                               class="flex-1 border-gray-300 rounded-r-lg focus:border-blue-500 focus:ring-blue-500 @error('instagram_link') border-red-500 @enderror"
                               placeholder="username">
                    </div>
                    @error('instagram_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Facebook Link -->
                <div>
                    <label for="facebook_link" class="block text-sm font-medium text-gray-700 mb-2">
                        Facebook
                    </label>
                    <input type="text" 
                           name="facebook_link" 
                           id="facebook_link" 
                           value="{{ old('facebook_link') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('facebook_link') border-red-500 @enderror"
                           placeholder="username atau URL">
                    @error('facebook_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Twitter Link -->
                <div>
                    <label for="twitter_link" class="block text-sm font-medium text-gray-700 mb-2">
                        Twitter/X
                    </label>
                    <input type="text" 
                           name="twitter_link" 
                           id="twitter_link" 
                           value="{{ old('twitter_link') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('twitter_link') border-red-500 @enderror"
                           placeholder="username">
                    @error('twitter_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- TikTok Link -->
                <div>
                    <label for="tiktok_link" class="block text-sm font-medium text-gray-700 mb-2">
                        TikTok
                    </label>
                    <input type="text" 
                           name="tiktok_link" 
                           id="tiktok_link" 
                           value="{{ old('tiktok_link') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('tiktok_link') border-red-500 @enderror"
                           placeholder="@username">
                    @error('tiktok_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Province -->
                <div>
                    <label for="province" class="block text-sm font-medium text-gray-700 mb-2">
                        Provinsi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="province" 
                           id="province" 
                           value="{{ old('province') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('province') border-red-500 @enderror"
                           placeholder="Contoh: Jawa Barat"
                           required>
                    @error('province')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                        Kota/Kabupaten <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="city" 
                           id="city" 
                           value="{{ old('city') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('city') border-red-500 @enderror"
                           placeholder="Contoh: Bandung"
                           required>
                    @error('city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- District -->
                <div>
                    <label for="district" class="block text-sm font-medium text-gray-700 mb-2">
                        Kecamatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="district" 
                           id="district" 
                           value="{{ old('district') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('district') border-red-500 @enderror"
                           placeholder="Contoh: Coblong"
                           required>
                    @error('district')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Village -->
                <div>
                    <label for="village" class="block text-sm font-medium text-gray-700 mb-2">
                        Kelurahan/Desa <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="village" 
                           id="village" 
                           value="{{ old('village') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('village') border-red-500 @enderror"
                           placeholder="Contoh: Dago"
                           required>
                    @error('village')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address (Detail) -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="address" 
                              id="address" 
                              rows="3"
                              class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('address') border-red-500 @enderror"
                              placeholder="Contoh: Jl. Setiabudi No. 123, RT 01 RW 02"
                              required>{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Postal Code -->
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Pos <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="postal_code" 
                           id="postal_code" 
                           value="{{ old('postal_code') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('postal_code') border-red-500 @enderror"
                           placeholder="Contoh: 40132"
                           required>
                    @error('postal_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Latitude & Longitude -->
                <div>
                    <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                        Latitude
                    </label>
                    <input type="text" 
                           name="latitude" 
                           id="latitude" 
                           value="{{ old('latitude') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('latitude') border-red-500 @enderror"
                           placeholder="-6.123456">
                    @error('latitude')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">
                        Longitude
                    </label>
                    <input type="text" 
                           name="longitude" 
                           id="longitude" 
                           value="{{ old('longitude') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('longitude') border-red-500 @enderror"
                           placeholder="107.123456">
                    @error('longitude')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Bagian 3: Media & SEO -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Media & SEO</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Logo -->
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                        Logo UMKM
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            <div id="logo-preview" class="hidden mb-3">
                                <img src="" alt="Logo preview" class="mx-auto h-24 w-24 object-cover rounded-lg">
                            </div>
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="logo-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload logo</span>
                                    <input id="logo-upload" name="logo" type="file" class="sr-only" accept="image/*" onchange="previewImage(this, 'logo-preview')">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, JPEG maksimal 2MB</p>
                        </div>
                    </div>
                    @error('logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Thumbnail -->
                <div>
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">
                        Thumbnail
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            <div id="thumbnail-preview" class="hidden mb-3">
                                <img src="" alt="Thumbnail preview" class="mx-auto h-24 w-24 object-cover rounded-lg">
                            </div>
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="thumbnail-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload thumbnail</span>
                                    <input id="thumbnail-upload" name="thumbnail" type="file" class="sr-only" accept="image/*" onchange="previewImage(this, 'thumbnail-preview')">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, JPEG maksimal 2MB</p>
                        </div>
                    </div>
                    @error('thumbnail')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gallery Images -->
                <div class="md:col-span-2">
                    <label for="gallery_images" class="block text-sm font-medium text-gray-700 mb-2">
                        Gallery Images (Maksimal 5 foto)
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            <div id="gallery-preview" class="grid grid-cols-5 gap-2 mb-3 hidden">
                                <!-- Preview akan diisi JavaScript -->
                            </div>
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="gallery-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload gallery</span>
                                    <input id="gallery-upload" name="gallery_images[]" type="file" class="sr-only" accept="image/*" multiple onchange="previewGallery(this)">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, JPEG maksimal 2MB per file</p>
                        </div>
                    </div>
                    @error('gallery_images')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('gallery_images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Meta Title -->
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">
                        Meta Title (SEO)
                    </label>
                    <input type="text" 
                           name="meta_title" 
                           id="meta_title" 
                           value="{{ old('meta_title') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                           placeholder="Title untuk SEO">
                    @error('meta_title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Meta Keywords -->
                <div>
                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">
                        Meta Keywords (SEO)
                    </label>
                    <input type="text" 
                           name="meta_keywords" 
                           id="meta_keywords" 
                           value="{{ old('meta_keywords') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                           placeholder="Keyword1, Keyword2, Keyword3">
                    @error('meta_keywords')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Meta Description -->
                <div class="md:col-span-2">
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Meta Description (SEO)
                    </label>
                    <textarea name="meta_description" 
                              id="meta_description" 
                              rows="3"
                              class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                              placeholder="Deskripsi untuk SEO">{{ old('meta_description') }}</textarea>
                    @error('meta_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Bagian 4: Subscription -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Subscription & Pembayaran</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Subscription Plan -->
                <div>
                    <label for="subscription_plan_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Paket Subscription
                    </label>
                    <select name="subscription_plan_id" 
                            id="subscription_plan_id" 
                            class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                            onchange="togglePaymentProof(this)">
                        <option value="">Pilih Paket (Opsional)</option>
                        @foreach($subscriptionPlans as $plan)
                        <option value="{{ $plan->id }}" {{ old('subscription_plan_id') == $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }} - Rp {{ number_format($plan->price, 0, ',', '.') }} ({{ $plan->duration_days }} hari)
                        </option>
                        @endforeach
                    </select>
                    @error('subscription_plan_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Proof -->
                <div id="payment-proof-container" class="{{ old('subscription_plan_id') ? '' : 'hidden' }}">
                    <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                        Bukti Pembayaran <span id="payment-proof-required" class="text-red-500 {{ old('subscription_plan_id') ? '' : 'hidden' }}">*</span>
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            <div id="payment-proof-preview" class="hidden mb-3">
                                <img src="" alt="Payment proof preview" class="mx-auto h-24 w-24 object-cover rounded-lg">
                            </div>
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="payment-proof-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                    <span>Upload bukti</span>
                                    <input id="payment-proof-upload" name="payment_proof" type="file" class="sr-only" accept="image/*,application/pdf" onchange="previewImage(this, 'payment-proof-preview')">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">JPG, PNG, PDF maksimal 5MB</p>
                        </div>
                    </div>
                    @error('payment_proof')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end gap-3 pt-4 border-t">
            <a href="{{ route('admin.umkm-profiles.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i>Simpan UMKM
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const previewContainer = preview.parentElement;
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.classList.add('hidden');
    }
}

function previewGallery(input) {
    const preview = document.getElementById('gallery-preview');
    preview.innerHTML = '';
    
    if (input.files && input.files.length > 0) {
        preview.classList.remove('hidden');
        
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" class="h-16 w-16 object-cover rounded-lg">
                    <button type="button" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs" onclick="removeFile(this)">×</button>
                `;
                preview.appendChild(div);
            }
            
            reader.readAsDataURL(file);
        });
    } else {
        preview.classList.add('hidden');
    }
}

function togglePaymentProof(select) {
    const container = document.getElementById('payment-proof-container');
    const requiredSpan = document.getElementById('payment-proof-required');
    
    if (select.value) {
        container.classList.remove('hidden');
        requiredSpan.classList.remove('hidden');
        document.getElementById('payment-proof-upload').setAttribute('required', 'required');
    } else {
        container.classList.add('hidden');
        requiredSpan.classList.add('hidden');
        document.getElementById('payment-proof-upload').removeAttribute('required');
    }
}

// Auto hide payment proof on page load if no plan selected
document.addEventListener('DOMContentLoaded', function() {
    const planSelect = document.getElementById('subscription_plan_id');
    if (!planSelect.value) {
        document.getElementById('payment-proof-container').classList.add('hidden');
    }
});
</script>
@endpush
@endsection