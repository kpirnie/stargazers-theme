/**
 * Night Vision Mode functionality
 */
export function initNightVision() {
    // Create the button
    const button = document.createElement('button');
    button.id = 'night-vision-toggle';
    button.setAttribute('aria-label', 'Toggle Night Vision');
    button.innerHTML = `
        <svg class="moon-crescent w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>
        <svg class="moon-full w-6 h-6 hidden" fill="currentColor" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="9"></circle>
        </svg>
    `;

    // Create overlay
    const overlay = document.createElement('div');
    overlay.id = 'night-vision-overlay';
    overlay.className = 'hidden';

    // Add to page
    document.body.appendChild(button);
    document.body.appendChild(overlay);

    // Toggle functionality
    button.addEventListener('click', function () {
        const isActive = overlay.classList.contains('active');
        const crescent = button.querySelector('.moon-crescent');
        const full = button.querySelector('.moon-full');

        if (isActive) {
            overlay.classList.remove('active');
            overlay.classList.add('hidden');
            crescent.classList.remove('hidden');
            full.classList.add('hidden');
            localStorage.setItem('nightVision', 'false');
        } else {
            overlay.classList.remove('hidden');
            overlay.classList.add('active');
            crescent.classList.add('hidden');
            full.classList.remove('hidden');
            localStorage.setItem('nightVision', 'true');
        }
    });

    // Check saved preference
    if (localStorage.getItem('nightVision') === 'true') {
        overlay.classList.remove('hidden');
        overlay.classList.add('active');
        button.querySelector('.moon-crescent').classList.add('hidden');
        button.querySelector('.moon-full').classList.remove('hidden');
    }
}