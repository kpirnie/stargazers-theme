/**
 * Image Modal functionality
 */
export function initImageModal() {
    // Create modal element
    const modal = document.createElement('div');
    modal.className = 'sgu-image-modal';
    modal.innerHTML = `
        <div class="sgu-image-modal-overlay"></div>
        <div class="sgu-image-modal-content">
            <button class="sgu-image-modal-close" aria-label="Close modal">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img src="" alt="">
        </div>
    `;
    document.body.appendChild(modal);

    const overlay = modal.querySelector('.sgu-image-modal-overlay');
    const closeBtn = modal.querySelector('.sgu-image-modal-close');
    const img = modal.querySelector('img');

    function closeModal() {
        modal.classList.remove('active');
        setTimeout(function() {
            img.src = '';
        }, 300);
    }

    // Close on overlay click
    overlay.addEventListener('click', closeModal);

    // Close on button click
    closeBtn.addEventListener('click', closeModal);

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });

    // Open modal on button[data-src] click
    document.addEventListener('click', function(e) {
        const trigger = e.target.closest('button[data-src]');
        if (!trigger) return;

        e.preventDefault();
        const src = trigger.getAttribute('data-src');
        if (src) {
            img.src = src;
            modal.classList.add('active');
        }
    });
}