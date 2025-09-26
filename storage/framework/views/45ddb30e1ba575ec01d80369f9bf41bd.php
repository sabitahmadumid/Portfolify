<!-- Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

<?php $__env->startPush('scripts'); ?>
<script>
function createToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    const icon = type === 'success' ? 
        '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' :
        type === 'error' ?
        '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>' :
        '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
    
    toast.className = `${bgColor} text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 min-w-64 transform translate-x-full opacity-0 transition-all duration-300`;
    toast.innerHTML = `
        <div class="flex-shrink-0">${icon}</div>
        <div class="flex-1">${message}</div>
        <button onclick="removeToast(this.parentElement)" class="flex-shrink-0 hover:text-gray-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
    
    container.appendChild(toast);
    
    // Trigger animation
    setTimeout(() => {
        toast.classList.remove('translate-x-full', 'opacity-0');
    }, 100);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        removeToast(toast);
    }, 4000);
}

function removeToast(toast) {
    toast.classList.add('translate-x-full', 'opacity-0');
    setTimeout(() => {
        if (toast.parentElement) {
            toast.parentElement.removeChild(toast);
        }
    }, 300);
}

function showSuccessToast(message) {
    createToast(message, 'success');
}

function showErrorToast(message) {
    createToast(message, 'error');
}

function showInfoToast(message) {
    createToast(message, 'info');
}
</script>
<?php $__env->stopPush(); ?><?php /**PATH /Users/xcalibur/Herd/portfolify/resources/views/components/toast.blade.php ENDPATH**/ ?>