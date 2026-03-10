{{-- resources/views/pages/admin/umkm-profile/index.blade.php --}}
@extends('layouts.app')

@section('title', 'UMKM Profile')
@section('page-title', 'UMKM Profile')

@section('content')
    @include('components.toast-notification')
    @include('components.confirmation-modal')
    
    <!-- Bulk Delete Modal -->
    <div id="bulkDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden transition-opacity duration-300 opacity-0">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-trash-alt text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Hapus Multiple UMKM</h3>
                <p class="text-sm text-gray-500 mb-4" id="bulkDeleteMessage"></p>
                
                <form id="bulkDeleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="ids" id="bulkDeleteIds">
                    
                    <div class="flex justify-center gap-3">
                        <button type="button" onclick="closeBulkDeleteModal()" 
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            <i class="fas fa-times mr-2"></i>Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">UMKM Profile</h1>
        <p class="text-gray-600 mt-2">Kelola profil UMKM yang terdaftar</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Total UMKM</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total'] ?? $profiles->total() }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-store text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Aktif</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['active'] ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Pending</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['pending'] ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-5 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Terverifikasi</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['verified'] ?? 0 }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-shield-alt text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-4 border-b">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Filter UMKM</h2>
                </div>
                
                <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                    <!-- Search -->
                    <form method="GET" action="{{ route('admin.umkm-profiles.index') }}" class="flex w-full md:w-auto">
                        <div class="relative w-full md:w-64">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari UMKM atau pemilik..."
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                            @if(request('search'))
                            <a href="{{ route('admin.umkm-profiles.index', array_merge(request()->except(['search', 'page']))) }}" 
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
                    <a href="{{ route('admin.umkm-profiles.create') }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center whitespace-nowrap">
                        <i class="fas fa-plus mr-2"></i> Tambah UMKM
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Options -->
        <div class="p-4 bg-gray-50 rounded-b-lg">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                <!-- Filter Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" onchange="filterBy('status', this.value)" class="w-full border-gray-300 rounded-lg text-sm">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <!-- Filter Verifikasi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Verifikasi</label>
                    <select name="verification" onchange="filterBy('verification', this.value)" class="w-full border-gray-300 rounded-lg text-sm">
                        <option value="">Semua</option>
                        <option value="pending" {{ request('verification') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="verified" {{ request('verification') == 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="rejected" {{ request('verification') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <!-- Filter Kategori -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category" onchange="filterBy('category', this.value)" class="w-full border-gray-300 rounded-lg text-sm">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Kota -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                    <input type="text" 
                           name="city" 
                           value="{{ request('city') }}" 
                           placeholder="Cari kota..."
                           onchange="filterBy('city', this.value)"
                           class="w-full border-gray-300 rounded-lg text-sm">
                </div>

                <!-- Filter Featured -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Featured</label>
                    <select name="featured" onchange="filterBy('featured', this.value)" class="w-full border-gray-300 rounded-lg text-sm">
                        <option value="">Semua</option>
                        <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured</option>
                        <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Non-Featured</option>
                    </select>
                </div>
            </div>

            <!-- Reset Filter Button -->
            @if(request()->anyFilled(['search', 'status', 'verification', 'category', 'city', 'featured']))
            <div class="mt-3 text-right">
                <a href="{{ route('admin.umkm-profiles.index') }}" 
                   class="text-sm text-gray-600 hover:text-gray-900">
                    <i class="fas fa-times-circle mr-1"></i> Reset Semua Filter
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Main Content: Cards Grid -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Daftar UMKM</h2>
                <p class="text-sm text-gray-600 mt-1">
                    Menampilkan {{ $profiles->firstItem() ?? 0 }} - {{ $profiles->lastItem() ?? 0 }} 
                    dari {{ $profiles->total() }} UMKM
                    @if(request('search'))
                    | Hasil pencarian: "{{ request('search') }}"
                    @endif
                </p>
            </div>

            <!-- Bulk Actions -->
            <div class="flex items-center gap-2">
                <button id="selectAllBtn" onclick="toggleSelectAll()" 
                        class="text-sm text-gray-600 hover:text-gray-900 px-3 py-1 border rounded-lg">
                    <i class="far fa-square mr-1"></i> Pilih Semua
                </button>
                <button id="bulkDeleteBtn" 
                        onclick="openBulkDeleteModal()"
                        class="text-sm text-red-600 hover:text-red-900 px-3 py-1 border border-red-200 rounded-lg hidden">
                    <i class="fas fa-trash-alt mr-1"></i> Hapus (<span id="selectedCount">0</span>)
                </button>
            </div>
        </div>
        
        <!-- Cards Grid -->
        <div class="p-6">
            @if($profiles->isEmpty())
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-store text-4xl mb-4"></i>
                <p class="text-lg mb-2">Belum ada data UMKM</p>
                @if(request('search'))
                <p class="text-sm">Coba dengan kata kunci lain</p>
                @endif
                <div class="mt-4">
                    <a href="{{ route('admin.umkm-profiles.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i> Tambah UMKM Pertama
                    </a>
                </div>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($profiles as $profile)
                <div class="bg-white border rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-300" data-profile-id="{{ $profile->id }}">
                    <!-- Card Header with Checkbox & Featured -->
                    <div class="relative">
                        <!-- Thumbnail -->
                        <div class="h-48 bg-gray-200 overflow-hidden">
                            @if($profile->thumbnail)
                            <img src="{{ $profile->thumbnail }}" alt="{{ $profile->name }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200">
                                <i class="fas fa-store text-6xl text-blue-400"></i>
                            </div>
                            @endif
                            
                            <!-- Overlay: Checkbox & Featured Badge -->
                            <div class="absolute top-2 left-2">
                                <input type="checkbox" 
                                       class="profile-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                       value="{{ $profile->id }}">
                            </div>
                            
                            @if($profile->is_featured)
                            <div class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-semibold">
                                <i class="fas fa-star mr-1"></i> FEATURED
                            </div>
                            @endif

                            <!-- Status Badges -->
                            <div class="absolute bottom-2 left-2 flex gap-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $profile->profile_status == 'published' ? 'bg-green-100 text-green-800' : 
                                       ($profile->profile_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($profile->profile_status == 'archived' ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800')) }}">
                                    {{ ucfirst($profile->profile_status) }}
                                </span>
                                
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $profile->verification_status == 'verified' ? 'bg-green-100 text-green-800' : 
                                       ($profile->verification_status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($profile->verification_status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-semibold text-gray-900 hover:text-blue-600">
                                <a href="{{ route('admin.umkm-profiles.show', $profile) }}">
                                    {{ $profile->name }}
                                </a>
                            </h3>
                            
                            <!-- Subscription Status -->
                            @if($profile->subscription_status)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $profile->subscription_status == 'active' ? 'bg-green-100 text-green-800' : 
                                   ($profile->subscription_status == 'expired' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($profile->subscription_status) }}
                            </span>
                            @endif
                        </div>

                        <!-- Category -->
                        <div class="mb-2">
                            <span class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-full">
                                <i class="fas fa-tag mr-1"></i>
                                {{ $profile->category->name ?? 'Tanpa Kategori' }}
                            </span>
                        </div>

                        <!-- Owner Info -->
                        <div class="flex items-center mb-3 text-sm text-gray-600">
                            <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center mr-2">
                                <i class="fas fa-user text-xs text-gray-500"></i>
                            </div>
                            <span>{{ $profile->nama_pemilik }}</span>
                        </div>

                        <!-- Short Description -->
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                            {{ Str::limit($profile->short_description, 100) }}
                        </p>

                        <!-- Location -->
                        <div class="flex items-center text-xs text-gray-500 mb-3">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            <span class="truncate">{{ $profile->city }}, {{ $profile->province }}</span>
                        </div>

                        <!-- Contact Info -->
                        <div class="flex flex-wrap gap-2 mb-3">
                            @if($profile->whatsapp_number)
                            <a href="https://wa.me/{{ $profile->whatsapp_number }}" target="_blank" 
                               class="text-green-600 hover:text-green-700 text-sm" title="WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            @endif
                            @if($profile->instagram_link)
                            <a href="{{ $profile->instagram_link }}" target="_blank" 
                               class="text-pink-600 hover:text-pink-700 text-sm" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            @endif
                            @if($profile->website)
                            <a href="{{ $profile->website }}" target="_blank" 
                               class="text-blue-600 hover:text-blue-700 text-sm" title="Website">
                                <i class="fas fa-globe"></i>
                            </a>
                            @endif
                        </div>

                        <!-- Stats -->
                        <div class="flex items-center justify-between text-xs text-gray-500 border-t pt-3">
                            <div class="flex items-center">
                                <i class="far fa-eye mr-1"></i>
                                {{ number_format($profile->views_count) }} dilihat
                            </div>
                            <div class="flex items-center">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ $profile->created_at->format('d M Y') }}
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-between items-center mt-3 pt-2 border-t">
                            <div class="flex space-x-1">
                                <a href="{{ route('admin.umkm-profiles.show', $profile) }}" 
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.umkm-profiles.edit', $profile) }}" 
                                   class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="toggleFeatured('{{ $profile->id }}')"
                                        class="p-2 {{ $profile->is_featured ? 'text-yellow-600 hover:bg-yellow-50' : 'text-gray-600 hover:bg-gray-50' }} rounded-lg transition-colors"
                                        title="{{ $profile->is_featured ? 'Hapus dari Featured' : 'Jadikan Featured' }}">
                                    <i class="fas {{ $profile->is_featured ? 'fa-star' : 'fa-star-o' }}"></i>
                                </button>
                                <form id="toggle-featured-{{ $profile->id }}" 
                                      action="{{ route('admin.umkm-profiles.toggle-featured', $profile) }}" 
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('POST')
                                </form>
                            </div>
                            
                            <div class="flex space-x-1">
                                @if($profile->verification_status == 'pending')
                                <button onclick="verifyUmkm('{{ $profile->id }}')"
                                        class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                        title="Verifikasi">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                                <button onclick="rejectUmkm('{{ $profile->id }}')"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Tolak">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                                @endif
                                
                                <button onclick="confirmDelete('{{ $profile->id }}', '{{ addslashes($profile->name) }}')" 
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $profile->id }}" 
                                      action="{{ route('admin.umkm-profiles.destroy', $profile) }}" 
                                      method="POST" 
                                      class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $profiles->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Rejection Modal -->
    <div id="rejectionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden transition-opacity duration-300 opacity-0">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tolak UMKM</h3>
                <p class="text-sm text-gray-500 mb-4">Berikan alasan penolakan</p>
                
                <form id="rejectionForm" method="POST">
                    @csrf
                    @method('POST')
                    <textarea name="rejection_reason" rows="3" 
                              class="w-full border border-gray-300 rounded-lg p-2 mb-4"
                              placeholder="Alasan penolakan..." required></textarea>
                    
                    <div class="flex justify-center gap-3">
                        <button type="button" onclick="closeRejectionModal()" 
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            <i class="fas fa-times-circle mr-2"></i>Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    let selectedProfiles = new Set();

    // Filter functions
    function filterBy(type, value) {
        const url = new URL(window.location.href);
        if (value) {
            url.searchParams.set(type, value);
        } else {
            url.searchParams.delete(type);
        }
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }

    // Toggle select all
    function toggleSelectAll() {
        const checkboxes = document.querySelectorAll('.profile-checkbox');
        const selectAllBtn = document.getElementById('selectAllBtn');
        const isAllChecked = Array.from(checkboxes).every(cb => cb.checked);
        
        checkboxes.forEach(cb => {
            cb.checked = !isAllChecked;
            const id = cb.value;
            if (cb.checked) {
                selectedProfiles.add(id);
            } else {
                selectedProfiles.delete(id);
            }
        });
        
        updateBulkDeleteButton();
        updateSelectAllButton();
    }

    // Individual checkbox change
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.profile-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const id = this.value;
                if (this.checked) {
                    selectedProfiles.add(id);
                } else {
                    selectedProfiles.delete(id);
                }
                updateBulkDeleteButton();
                updateSelectAllButton();
            });
        });
    });

    function updateBulkDeleteButton() {
        const bulkBtn = document.getElementById('bulkDeleteBtn');
        const selectedCount = document.getElementById('selectedCount');
        const count = selectedProfiles.size;
        
        if (count > 0) {
            selectedCount.textContent = count;
            bulkBtn.classList.remove('hidden');
        } else {
            bulkBtn.classList.add('hidden');
        }
    }

    function updateSelectAllButton() {
        const checkboxes = document.querySelectorAll('.profile-checkbox');
        const selectAllBtn = document.getElementById('selectAllBtn');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        const someChecked = Array.from(checkboxes).some(cb => cb.checked);
        
        if (allChecked) {
            selectAllBtn.innerHTML = '<i class="far fa-check-square mr-1"></i> Batal Pilih Semua';
        } else if (someChecked) {
            selectAllBtn.innerHTML = '<i class="far fa-minus-square mr-1"></i> Pilih Semua';
        } else {
            selectAllBtn.innerHTML = '<i class="far fa-square mr-1"></i> Pilih Semua';
        }
    }

    // Bulk delete modal
    function openBulkDeleteModal() {
        const modal = document.getElementById('bulkDeleteModal');
        const message = document.getElementById('bulkDeleteMessage');
        const idsInput = document.getElementById('bulkDeleteIds');
        const form = document.getElementById('bulkDeleteForm');
        
        message.innerHTML = `Anda akan menghapus <strong>${selectedProfiles.size}</strong> UMKM. Tindakan ini dapat dikembalikan dari trash.`;
        idsInput.value = Array.from(selectedProfiles).join(',');
        form.action = "{{ route('admin.umkm-profiles.bulk-delete') }}";
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
        }, 10);
    }

    function closeBulkDeleteModal() {
        const modal = document.getElementById('bulkDeleteModal');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Verification functions
    function verifyUmkm(id) {
        if (confirm('Verifikasi UMKM ini? UMKM akan berstatus verified dan published.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin/umkm-profiles') }}/${id}/verify`;
            form.innerHTML = '@csrf @method("POST")';
            document.body.appendChild(form);
            form.submit();
        }
    }

    function rejectUmkm(id) {
        const modal = document.getElementById('rejectionModal');
        const form = document.getElementById('rejectionForm');
        form.action = `{{ url('admin/umkm-profiles') }}/${id}/reject`;
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
        }, 10);
    }

    function closeRejectionModal() {
        const modal = document.getElementById('rejectionModal');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.getElementById('rejectionForm').reset();
        }, 300);
    }

    function toggleFeatured(id) {
        const form = document.getElementById(`toggle-featured-${id}`);
        form.submit();
    }

    // Delete confirmation
    function confirmDelete(id, name) {
        const deleteUrl = `{{ url('admin/umkm-profiles') }}/${id}`;
        showConfirmationModal(
            'Konfirmasi Hapus',
            `Apakah Anda yakin ingin menghapus UMKM <strong>"${name}"</strong>?`,
            deleteUrl,
            name
        );
    }

    // Close modals on click outside
    window.onclick = function(event) {
        const bulkModal = document.getElementById('bulkDeleteModal');
        const rejectionModal = document.getElementById('rejectionModal');
        
        if (event.target == bulkModal) {
            closeBulkDeleteModal();
        }
        if (event.target == rejectionModal) {
            closeRejectionModal();
        }
    }
    </script>

    <style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    </style>
@endsection