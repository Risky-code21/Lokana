@extends('layouts.app')

@section('title', 'Pelaku UMKM')
@section('page-title', 'Pelaku UMKM')

@section('content')
    <!-- Include Toast Notification -->
    @include('components.toast-notification')
    
    <!-- Include Confirmation Modal -->
    @include('components.confirmation-modal')
    
    <!-- Bulk Delete Modal -->
    <div id="bulkDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden transition-opacity duration-300 opacity-0">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white transform transition-all duration-300 scale-95">
            <div class="text-center">
                <!-- Icon -->
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                
                <!-- Title & Message -->
                <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Hapus Massal</h3>
                <p id="bulkDeleteMessage" class="text-sm text-gray-500 mb-6">
                    Apakah Anda yakin ingin menghapus data yang dipilih?
                </p>
                
                <!-- Action Buttons -->
                <div class="flex justify-center space-x-3">
                    <button type="button" onclick="closeBulkDeleteModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="button" onclick="submitBulkDelete()"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 flex items-center">
                        <i class="fas fa-trash mr-2"></i>
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

<div class="mb-6">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">MSME Artisan List</h1>
    <p class="text-gray-600 mt-2">Kelola dan pantau semua data pelaku UMKM dalam sistem</p>
</div>

<!-- ==================== CARDS SECTION ==================== -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Card 1: Total Semua -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-5 text-white">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm font-medium opacity-90 uppercase tracking-wider">Total Artisan</p>
                <p class="text-3xl font-bold mt-2">{{ $pelakuUmkms->total() }}</p>
                <p class="text-sm opacity-80 mt-1">Semua data</p>
            </div>
            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                <i class="fas fa-users text-2xl"></i>
            </div>
        </div>
    </div>
</div>
<!-- ==================== END CARDS ==================== -->

<div class="bg-white rounded-lg shadow">
    <!-- Header with Search and Actions -->
    <div class="px-6 py-4 border-b flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Daftar Pelaku UMKM</h2>
            <p class="text-sm text-gray-600 mt-1">
                Total: <span class="font-semibold">{{ $pelakuUmkms->total() }}</span> data
                @if(request('search'))
                | Hasil pencarian: "{{ request('search') }}"
                @endif
            </p>
        </div>
        
        <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.pelaku-umkm.index') }}" class="flex">
                <div class="relative w-full md:w-64">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nama, email, atau telepon..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <i class="fas fa-search"></i>
                    </div>
                    @if(request('search'))
                    <a href="{{ route('admin.pelaku-umkm.index') }}" 
                       class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </div>
                <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Cari
                </button>
            </form>
            
            <div class="flex gap-2">
                <!-- Bulk Action Select -->
                <select id="bulkAction" 
                        class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-blue-500"
                        onchange="handleBulkAction(this.value)">
                    <option value="">Aksi Massal</option>
                    <option value="delete">Hapus Data Terpilih</option>
                </select>
                
                <!-- Create Button -->
                <a href="{{ route('admin.pelaku-umkm.create') }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center whitespace-nowrap">
                    <i class="fas fa-plus mr-2"></i> Tambah
                </a>
            </div>
        </div>
    </div>
    
    <!-- Bulk Action Bar (Hidden by default) -->
    <div id="bulkActionBar" class="bg-blue-50 border-b border-blue-200 px-6 py-3 hidden">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <span id="selectedCount" class="font-medium text-blue-800">0 data terpilih</span>
                <button onclick="selectAll()" class="text-sm text-blue-600 hover:text-blue-800">
                    <i class="fas fa-check-double mr-1"></i>Pilih Semua
                </button>
                <button onclick="deselectAll()" class="text-sm text-blue-600 hover:text-blue-800">
                    <i class="fas fa-times mr-1"></i>Batal Pilih
                </button>
            </div>
            <div>
                <button onclick="closeBulkActionBar()" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Content -->
    <div class="p-6">
        @if($pelakuUmkms->isEmpty())
        <div class="text-center py-12 text-gray-500">
            <i class="fas fa-users text-4xl mb-4"></i>
            <p class="text-lg mb-2">Belum ada data pelaku UMKM</p>
            @if(request('search'))
            <p class="text-sm">Coba dengan kata kunci lain</p>
            <a href="{{ route('admin.pelaku-umkm.index') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                Tampilkan semua data
            </a>
            @endif
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                            <input type="checkbox" 
                                   id="selectAllCheckbox" 
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   onclick="toggleSelectAll(this)">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pelakuUmkms as $index => $pelaku)
                    <tr id="row-{{ $pelaku->id }}" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" 
                                   name="selected_ids[]" 
                                   value="{{ $pelaku->id }}"
                                   class="item-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   onclick="updateSelection()">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ ($pelakuUmkms->currentPage() - 1) * $pelakuUmkms->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $pelaku->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pelaku->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $pelaku->phone }}</td>
                        <td class="px-6 py-4 max-w-xs truncate" title="{{ $pelaku->address }}">
                            {{ Str::limit($pelaku->address, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.pelaku-umkm.show', $pelaku) }}" 
                                   class="text-blue-600 hover:text-blue-900 p-2 rounded hover:bg-blue-50"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.pelaku-umkm.edit', $pelaku) }}" 
                                   class="text-green-600 hover:text-green-900 p-2 rounded hover:bg-green-50"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <!-- Delete Button -->
                                <button onclick="confirmDelete('{{ $pelaku->id }}', '{{ addslashes($pelaku->name) }}')" 
                                        class="text-red-600 hover:text-red-900 p-2 rounded hover:bg-red-50"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                                
                                <!-- Hidden Delete Form -->
                                <form id="delete-form-{{ $pelaku->id }}" 
                                      action="{{ route('admin.pelaku-umkm.destroy', $pelaku) }}" 
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
        
        <!-- Pagination with Per Page Selector -->
        <div class="mt-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <!-- Per Page Selector -->
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-700">Tampilkan per halaman:</span>
                <select onchange="changePerPage(this.value)" 
                        class="border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:border-blue-500">
                    <option value="5" {{ request('per_page', 10) == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
            
            <!-- Pagination Links -->
            <div class="flex items-center">
                <p class="text-sm text-gray-700 mr-4">
                    Menampilkan 
                    <span class="font-medium">{{ $pelakuUmkms->firstItem() }}</span>
                    sampai
                    <span class="font-medium">{{ $pelakuUmkms->lastItem() }}</span>
                    dari
                    <span class="font-medium">{{ $pelakuUmkms->total() }}</span>
                    data
                </p>
                
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                    {{-- Previous Page Link --}}
                    @if ($pelakuUmkms->onFirstPage())
                        <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $pelakuUmkms->previousPageUrl() }}" 
                           class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($pelakuUmkms->getUrlRange(1, $pelakuUmkms->lastPage()) as $page => $url)
                        @if ($page == $pelakuUmkms->currentPage())
                            <span class="relative inline-flex items-center px-4 py-2 border border-blue-500 bg-blue-50 text-sm font-medium text-blue-600">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" 
                               class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($pelakuUmkms->hasMorePages())
                        <a href="{{ $pelakuUmkms->nextPageUrl() }}" 
                           class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </nav>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
// Selected IDs array
let selectedIds = [];

// Function untuk delete confirmation (single)
function confirmDelete(id, name) {
    const deleteUrl = `{{ route('admin.pelaku-umkm.destroy', ':id') }}`.replace(':id', id);
    showConfirmationModal(
        'Konfirmasi Hapus',
        `Apakah Anda yakin ingin menghapus pelaku UMKM <strong>"${name}"</strong>?`,
        deleteUrl,
        name
    );
}

// Function untuk submit form delete
function submitDeleteForm() {
    const modal = document.getElementById('confirmationModal');
    const deleteForm = document.getElementById('deleteForm');
    const actionUrl = deleteForm.action;
    
    // Extract ID from URL
    const id = actionUrl.split('/').pop();
    const form = document.getElementById(`delete-form-${id}`);
    
    if (form) {
        // Show loading state
        const submitBtn = deleteForm.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menghapus...';
        submitBtn.disabled = true;
        
        // Submit the actual form
        form.submit();
    }
}

// Update selection count
function updateSelection() {
    const checkboxes = document.querySelectorAll('.item-checkbox:checked');
    selectedIds = Array.from(checkboxes).map(cb => cb.value);
    
    const selectedCount = document.getElementById('selectedCount');
    selectedCount.textContent = `${selectedIds.length} data terpilih`;
    
    // Show/hide bulk action bar
    const bulkActionBar = document.getElementById('bulkActionBar');
    if (selectedIds.length > 0) {
        bulkActionBar.classList.remove('hidden');
    } else {
        bulkActionBar.classList.add('hidden');
    }
    
    // Update select all checkbox
    const totalCheckboxes = document.querySelectorAll('.item-checkbox').length;
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    selectAllCheckbox.checked = selectedIds.length === totalCheckboxes;
    selectAllCheckbox.indeterminate = selectedIds.length > 0 && selectedIds.length < totalCheckboxes;
}

// Toggle select all
function toggleSelectAll(checkbox) {
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    itemCheckboxes.forEach(cb => {
        cb.checked = checkbox.checked;
    });
    updateSelection();
}

// Select all items
function selectAll() {
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    itemCheckboxes.forEach(cb => {
        cb.checked = true;
    });
    updateSelection();
}

// Deselect all items
function deselectAll() {
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    itemCheckboxes.forEach(cb => {
        cb.checked = false;
    });
    updateSelection();
}

// Close bulk action bar
function closeBulkActionBar() {
    deselectAll();
    document.getElementById('bulkActionBar').classList.add('hidden');
}

// Handle bulk action selection
function handleBulkAction(action) {
    if (action === 'delete' && selectedIds.length > 0) {
        showBulkDeleteModal();
    }
    // Reset select
    document.getElementById('bulkAction').value = '';
}

// Show bulk delete modal
function showBulkDeleteModal() {
    const modal = document.getElementById('bulkDeleteModal');
    const message = document.getElementById('bulkDeleteMessage');
    
    message.textContent = `Apakah Anda yakin ingin menghapus ${selectedIds.length} data yang dipilih?`;
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modal.classList.add('opacity-100');
        modal.querySelector('.relative').classList.remove('scale-95');
        modal.querySelector('.relative').classList.add('scale-100');
    }, 10);
}

// Close bulk delete modal
function closeBulkDeleteModal() {
    const modal = document.getElementById('bulkDeleteModal');
    modal.classList.remove('opacity-100');
    modal.classList.add('opacity-0');
    modal.querySelector('.relative').classList.remove('scale-100');
    modal.querySelector('.relative').classList.add('scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('opacity-0');
    }, 300);
}

// Submit bulk delete
async function submitBulkDelete() {
    if (selectedIds.length === 0) return;
    
    const submitBtn = document.querySelector('#bulkDeleteModal button[onclick="submitBulkDelete()"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menghapus...';
    submitBtn.disabled = true;
    
    try {
        const response = await fetch('{{ route("admin.pelaku-umkm.bulk-destroy") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ ids: selectedIds })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Show success toast
            showToast('success', data.message);
            
            // Remove selected rows from table
            selectedIds.forEach(id => {
                const row = document.getElementById(`row-${id}`);
                if (row) row.remove();
            });
            
            // Update total count
            const totalSpan = document.querySelector('p.text-sm.text-gray-600 span');
            if (totalSpan) {
                const currentTotal = parseInt(totalSpan.textContent);
                totalSpan.textContent = currentTotal - data.count;
            }
            
            // Close modals and reset
            closeBulkDeleteModal();
            closeBulkActionBar();
            selectedIds = [];
            
            // Refresh page after 2 seconds
            setTimeout(() => {
                window.location.reload();
            }, 2000);
            
        } else {
            showToast('error', data.message);
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
        
    } catch (error) {
        showToast('error', 'Terjadi kesalahan: ' + error.message);
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
}

// Change per page
function changePerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    window.location.href = url.toString();
}

// Close bulk modal when clicking outside
document.getElementById('bulkDeleteModal')?.addEventListener('click', function(e) {
    if (e.target.id === 'bulkDeleteModal') {
        closeBulkDeleteModal();
    }
});

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Update delete form submit handler
    const deleteForm = document.getElementById('deleteForm');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitDeleteForm();
        });
    }
    
    // Initialize selection
    updateSelection();
});

// Export functions
window.confirmDelete = confirmDelete;
window.submitDeleteForm = submitDeleteForm;
</script>

<style>
#bulkActionBar {
    transition: all 0.3s ease;
}

.item-checkbox:checked + label {
    background-color: #dbeafe;
}

/* Highlight selected rows */
tr.selected {
    background-color: #eff6ff !important;
}
</style>
@endsection