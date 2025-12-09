/**
 * Scroll to Top functionality
 */
export function initScrollToTop() {
    // Create the button
    const button = document.createElement('button');
    button.id = 'scroll-to-top';
    button.setAttribute('aria-label', 'Scroll to top');
    button.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>';

    // Add button to page
    document.body.appendChild(button);

    // Show/hide button based on scroll position
    function toggleButton() {
        if (window.pageYOffset > 150) {
            button.classList.add('show');
        } else {
            button.classList.remove('show');
        }
    }

    // Scroll to top when clicked
    button.addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Listen for scroll events
    let ticking = false;
    window.addEventListener('scroll', function () {
        if (!ticking) {
            window.requestAnimationFrame(function () {
                toggleButton();
                ticking = false;
            });
            ticking = true;
        }
    });

    // Initial check
    toggleButton();
}