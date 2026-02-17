@if(session('success') || session('error') || session('warning') || session('info'))
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-3">
    @if(session('success'))
    <div id="success-toast" class="toast-message bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-lg max-w-sm transform transition-all duration-500 translate-x-full opacity-0">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
            <button onclick="closeToast('success-toast')" class="ml-auto -mx-1.5 -my-1.5 text-green-500 hover:text-green-700 rounded-lg p-1.5">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="progress-bar bg-green-500 h-1 w-0 mt-2 rounded-full"></div>
    </div>
    @endif

    @if(session('error'))
    <div id="error-toast" class="toast-message bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-lg max-w-sm transform transition-all duration-500 translate-x-full opacity-0">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
            <button onclick="closeToast('error-toast')" class="ml-auto -mx-1.5 -my-1.5 text-red-500 hover:text-red-700 rounded-lg p-1.5">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="progress-bar bg-red-500 h-1 w-0 mt-2 rounded-full"></div>
    </div>
    @endif

    @if(session('warning'))
    <div id="warning-toast" class="toast-message bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg shadow-lg max-w-sm transform transition-all duration-500 translate-x-full opacity-0">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-yellow-800">{{ session('warning') }}</p>
            </div>
            <button onclick="closeToast('warning-toast')" class="ml-auto -mx-1.5 -my-1.5 text-yellow-500 hover:text-yellow-700 rounded-lg p-1.5">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="progress-bar bg-yellow-500 h-1 w-0 mt-2 rounded-full"></div>
    </div>
    @endif

    @if(session('info'))
    <div id="info-toast" class="toast-message bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg shadow-lg max-w-sm transform transition-all duration-500 translate-x-full opacity-0">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-blue-800">{{ session('info') }}</p>
            </div>
            <button onclick="closeToast('info-toast')" class="ml-auto -mx-1.5 -my-1.5 text-blue-500 hover:text-blue-700 rounded-lg p-1.5">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="progress-bar bg-blue-500 h-1 w-0 mt-2 rounded-full"></div>
    </div>
    @endif
</div>
@endif

<script>
// Toast Notification System
document.addEventListener('DOMContentLoaded', function() {
    // Show all toasts with animation
    setTimeout(() => {
        document.querySelectorAll('.toast-message').forEach(toast => {
            toast.classList.remove('translate-x-full', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');
            
            // Animate progress bar
            const progressBar = toast.querySelector('.progress-bar');
            if (progressBar) {
                progressBar.style.transition = 'width 5s linear';
                progressBar.style.width = '100%';
            }
        });
    }, 100);

    // Auto hide toasts after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.toast-message').forEach(toast => {
            hideToast(toast.id);
        });
    }, 5000);
});

function showToast(type, message) {
    // Create new toast element
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    
    const toastId = `${type}-toast-${Date.now()}`;
    const colors = {
        success: { bg: 'green', icon: 'check-circle' },
        error: { bg: 'red', icon: 'exclamation-circle' },
        warning: { bg: 'yellow', icon: 'exclamation-triangle' },
        info: { bg: 'blue', icon: 'info-circle' }
    };
    
    const color = colors[type];
    
    const toastHTML = `
        <div id="${toastId}" class="toast-message bg-${color.bg}-50 border-l-4 border-${color.bg}-500 p-4 rounded-r-lg shadow-lg max-w-sm transform transition-all duration-500 translate-x-full opacity-0 mb-3">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-${color.icon} text-${color.bg}-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-${color.bg}-800">${message}</p>
                </div>
                <button onclick="closeToast('${toastId}')" class="ml-auto -mx-1.5 -my-1.5 text-${color.bg}-500 hover:text-${color.bg}-700 rounded-lg p-1.5">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="progress-bar bg-${color.bg}-500 h-1 w-0 mt-2 rounded-full"></div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('afterbegin', toastHTML);
    
    // Animate in
    setTimeout(() => {
        const toast = document.getElementById(toastId);
        toast.classList.remove('translate-x-full', 'opacity-0');
        toast.classList.add('translate-x-0', 'opacity-100');
        
        // Animate progress bar
        const progressBar = toast.querySelector('.progress-bar');
        progressBar.style.transition = 'width 5s linear';
        progressBar.style.width = '100%';
    }, 100);
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        hideToast(toastId);
    }, 5000);
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'fixed top-4 right-4 z-50 space-y-3';
    document.body.appendChild(container);
    return container;
}

function closeToast(toastId) {
    hideToast(toastId);
}

function hideToast(toastId) {
    const toast = document.getElementById(toastId);
    if (toast) {
        toast.classList.remove('translate-x-0', 'opacity-100');
        toast.classList.add('translate-x-full', 'opacity-0');
        
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 500);
    }
}
</script>

<style>
.toast-message {
    animation: slideInRight 0.5s ease-out;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>