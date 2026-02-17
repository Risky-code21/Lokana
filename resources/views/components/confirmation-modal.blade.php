<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="text-center">
            <!-- Icon -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            
            <!-- Title & Message -->
            <h3 id="modalTitle" class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Hapus</h3>
            <p id="modalMessage" class="text-sm text-gray-500 mb-6">
                Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
            </p>
            
            <!-- Form -->
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                
                <div class="flex justify-center space-x-3">
                    <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 flex items-center">
                        <i class="fas fa-trash mr-2"></i>
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentDeleteUrl = '';

function showConfirmationModal(title, message, deleteUrl, itemName = '') {
    const modal = document.getElementById('confirmationModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const deleteForm = document.getElementById('deleteForm');
    
    // Set modal content
    modalTitle.textContent = title || 'Konfirmasi Hapus';
    
    if (itemName) {
        modalMessage.innerHTML = `Apakah Anda yakin ingin menghapus <span class="font-semibold">"${itemName}"</span>? Tindakan ini tidak dapat dibatalkan.`;
    } else {
        modalMessage.textContent = message || 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.';
    }
    
    // Set form action
    deleteForm.action = deleteUrl;
    currentDeleteUrl = deleteUrl;
    
    // Show modal with animation
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.add('opacity-100');
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('confirmationModal');
    modal.classList.add('opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('opacity-0');
    }, 300);
}

// Close modal when clicking outside
document.getElementById('confirmationModal')?.addEventListener('click', function(e) {
    if (e.target.id === 'confirmationModal') {
        closeModal();
    }
});

// Handle form submission
document.getElementById('deleteForm')?.addEventListener('submit', function(e) {
    // You can add loading state here if needed
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menghapus...';
    submitBtn.disabled = true;
    
    // The form will submit normally
});
</script>

<style>
#confirmationModal {
    transition: opacity 0.3s ease;
}
</style>