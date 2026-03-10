{{-- resources/views/pages/admin/umkm-profile/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail UMKM')
@section('page-title', 'Detail UMKM: ' . $umkmProfile->name)

@section('content')
<div class="space-y-6">
    <!-- Action Buttons -->
    <div class="flex justify-between items-center">
        <div>
            <a href="{{ route('admin.umkm-profiles.index') }}" class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
            </a>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.umkm-profiles.edit', $umkmProfile) }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                <i class="fas fa-edit mr-2"></i>Edit UMKM
            </a>
            <button onclick="confirmDelete('{{ $umkmProfile->id }}', '{{ addslashes($umkmProfile->name) }}')"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                <i class="fas fa-trash mr-2"></i>Hapus
            </button>
        </div>
    </div>

    <!-- Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Profile Status</p>
                    <p class="text-lg font-semibold mt-1">
                        <span class="px-3 py-1 text-sm rounded-full 
                            {{ $umkmProfile->profile_status == 'published' ? 'bg-green-100 text-green-800' : 
                               ($umkmProfile->profile_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($umkmProfile->profile_status == 'archived' ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800')) }}">
                            {{ ucfirst($umkmProfile->profile_status) }}
                        </span>
                    </p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-info-circle text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Verifikasi</p>
                    <p class="text-lg font-semibold mt-1">
                        <span class="px-3 py-1 text-sm rounded-full
                            {{ $umkmProfile->verification_status == 'verified' ? 'bg-green-100 text-green-800' : 
                               ($umkmProfile->verification_status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($umkmProfile->verification_status) }}
                        </span>
                    </p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shield-alt text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Subscription</p>
                    <p class="text-lg font-semibold mt-1">
                        <span class="px-3 py-1 text-sm rounded-full
                            {{ $umkmProfile->subscription_status == 'active' ? 'bg-green-100 text-green-800' : 
                               ($umkmProfile->subscription_status == 'expired' ? 'bg-red-100 text-red-800' : 
                               ($umkmProfile->subscription_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                            {{ ucfirst($umkmProfile->subscription_status) }}
                        </span>
                    </p>
                </div>
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-crown text-purple-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Featured</p>
                    <p class="text-lg font-semibold mt-1">
                        @if($umkmProfile->is_featured)
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">
                            <i class="fas fa-star mr-1"></i> Featured
                        </span>
                        @else
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">
                            Non-Featured
                        </span>
                        @endif
                    </p>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-yellow-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Media & Basic Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Thumbnail Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="h-48 bg-gray-200">
                    @if($umkmProfile->thumbnail)
                    <img src="{{ $umkmProfile->thumbnail }}" alt="{{ $umkmProfile->name }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200">
                        <i class="fas fa-store text-6xl text-blue-400"></i>
                    </div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800">{{ $umkmProfile->name }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $umkmProfile->category->name ?? 'Tanpa Kategori' }}</p>
                    
                    @if($umkmProfile->logo)
                    <div class="mt-3 pt-3 border-t">
                        <p class="text-xs text-gray-500 mb-2">Logo UMKM:</p>
                        <img src="{{ $umkmProfile->logo }}" alt="Logo" class="h-12 w-12 object-cover rounded-lg">
                    </div>
                    @endif
                </div>
            </div>

            <!-- Owner Info Card -->
            <div class="bg-white rounded-lg shadow p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Informasi Pemilik</h4>
                <div class="space-y-2">
                    <div>
                        <p class="text-xs text-gray-500">Nama Pemilik</p>
                        <p class="text-sm font-medium">{{ $umkmProfile->nama_pemilik }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Tahun Berdiri</p>
                        <p class="text-sm font-medium">{{ $umkmProfile->tahun_berdiri }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Views</p>
                        <p class="text-sm font-medium">{{ number_format($umkmProfile->views_count) }} dilihat</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Dibuat Pada</p>
                        <p class="text-sm font-medium">{{ $umkmProfile->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Terakhir Update</p>
                        <p class="text-sm font-medium">{{ $umkmProfile->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Verification Info (if verified) -->
            @if($umkmProfile->verified_at)
            <div class="bg-white rounded-lg shadow p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Informasi Verifikasi</h4>
                <div class="space-y-2">
                    <div>
                        <p class="text-xs text-gray-500">Diverifikasi Pada</p>
                        <p class="text-sm font-medium">{{ $umkmProfile->verified_at->format('d M Y H:i') }}</p>
                    </div>
                    @if($umkmProfile->verifiedBy)
                    <div>
                        <p class="text-xs text-gray-500">Diverifikasi Oleh</p>
                        <p class="text-sm font-medium">{{ $umkmProfile->verifiedBy->name }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Contact Info -->
            <div class="bg-white rounded-lg shadow p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Kontak & Sosial Media</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">WhatsApp</p>
                        <a href="https://wa.me/{{ $umkmProfile->whatsapp_number }}" target="_blank" 
                           class="text-sm text-green-600 hover:text-green-800">
                            <i class="fab fa-whatsapp mr-1"></i>+62 {{ $umkmProfile->whatsapp_number }}
                        </a>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Contact Person Phone</p>
                        <p class="text-sm">{{ $umkmProfile->contact_person_phone }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Email</p>
                        @if($umkmProfile->email_umkm)
                        <a href="mailto:{{ $umkmProfile->email_umkm }}" class="text-sm text-blue-600 hover:text-blue-800">
                            {{ $umkmProfile->email_umkm }}
                        </a>
                        @else
                        <p class="text-sm text-gray-400">-</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Website</p>
                        @if($umkmProfile->website)
                        <a href="{{ $umkmProfile->website }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 truncate">
                            {{ $umkmProfile->website }}
                        </a>
                        @else
                        <p class="text-sm text-gray-400">-</p>
                        @endif
                    </div>
                </div>

                <!-- Social Media Links -->
                <div class="mt-3 pt-3 border-t">
                    <p class="text-xs text-gray-500 mb-2">Social Media:</p>
                    <div class="flex gap-3">
                        @if($umkmProfile->instagram_link)
                        <a href="{{ $umkmProfile->instagram_link }}" target="_blank" class="text-pink-600 hover:text-pink-800">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        @endif
                        @if($umkmProfile->facebook_link)
                        <a href="{{ $umkmProfile->facebook_link }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        @endif
                        @if($umkmProfile->twitter_link)
                        <a href="{{ $umkmProfile->twitter_link }}" target="_blank" class="text-gray-600 hover:text-gray-800">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        @endif
                        @if($umkmProfile->tiktok_link)
                        <a href="{{ $umkmProfile->tiktok_link }}" target="_blank" class="text-black hover:text-gray-800">
                            <i class="fab fa-tiktok text-xl"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Address & Location -->
            <div class="bg-white rounded-lg shadow p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Alamat & Lokasi</h4>
                <div class="space-y-2">
                    <p class="text-sm">{{ $umkmProfile->full_address }}</p>
                    <p class="text-sm text-gray-600">Kode Pos: {{ $umkmProfile->postal_code }}</p>
                    
                    @if($umkmProfile->latitude && $umkmProfile->longitude)
                    <div class="mt-2">
                        <p class="text-xs text-gray-500">Koordinat:</p>
                        <p class="text-sm">Lat: {{ $umkmProfile->latitude }}, Long: {{ $umkmProfile->longitude }}</p>
                    </div>
                    @endif

                    <!-- Map placeholder (bisa diintegrasikan dengan Google Maps) -->
                    <div class="mt-3 h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                        <p class="text-gray-500">Map akan ditampilkan di sini</p>
                    </div>
                </div>
            </div>

            <!-- Short Description -->
            <div class="bg-white rounded-lg shadow p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Deskripsi Singkat</h4>
                <p class="text-sm text-gray-700">{{ $umkmProfile->short_description }}</p>
            </div>

            <!-- Full Story -->
            <div class="bg-white rounded-lg shadow p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Full Story</h4>
                <div class="prose max-w-none">
                    {!! nl2br(e($umkmProfile->content)) !!}
                </div>
            </div>

            <!-- Gallery -->
            @if(!empty($umkmProfile->gallery_images))
            <div class="bg-white rounded-lg shadow p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Gallery</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($umkmProfile->gallery_images as $image)
                    <div class="relative group">
                        <img src="{{ $image }}" alt="Gallery" class="w-full h-32 object-cover rounded-lg cursor-pointer" onclick="openModal('{{ $image }}')">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all rounded-lg"></div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Subscription Details -->
            @if($umkmProfile->subscriptionPlan)
            <div class="bg-white rounded-lg shadow p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Detail Subscription</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Paket</p>
                        <p class="text-sm font-medium">{{ $umkmProfile->subscriptionPlan->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Harga</p>
                        <p class="text-sm font-medium">Rp {{ number_format($umkmProfile->subscriptionPlan->price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Mulai</p>
                        <p class="text-sm">{{ $umkmProfile->subscription_start_date ? $umkmProfile->subscription_start_date->format('d M Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Berakhir</p>
                        <p class="text-sm">{{ $umkmProfile->subscription_end_date ? $umkmProfile->subscription_end_date->format('d M Y') : '-' }}</p>
                    </div>
                </div>

                @if($umkmProfile->payment_proof)
                <div class="mt-3 pt-3 border-t">
                    <p class="text-xs text-gray-500 mb-2">Bukti Pembayaran:</p>
                    <a href="{{ $umkmProfile->payment_proof }}" target="_blank" 
                       class="inline-flex items