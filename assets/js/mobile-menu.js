/**
 * Mobile Menu functionality
 */
export function initMobileMenu() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuToggle && mobileMenu) {
        const hamburgerIcon = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>';
        const closeIcon = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';

        mobileMenuToggle.addEventListener('click', function (event) {
            event.stopPropagation();
            const isCurrentlyHidden = mobileMenu.classList.contains('hidden');
            
            if (isCurrentlyHidden) {
                mobileMenu.classList.remove('hidden');
                mobileMenuToggle.innerHTML = closeIcon;
                mobileMenuToggle.setAttribute('aria-expanded', 'true');
            } else {
                mobileMenu.classList.add('hidden');
                mobileMenuToggle.innerHTML = hamburgerIcon;
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function (event) {
            if (!mobileMenu.classList.contains('hidden')) {
                const isClickInsideMenu = mobileMenu.contains(event.target);
                const isClickOnToggle = event.target.closest('#mobile-menu-toggle');

                if (!isClickInsideMenu && !isClickOnToggle) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuToggle.innerHTML = hamburgerIcon;
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                }
            }
        });
    }
}