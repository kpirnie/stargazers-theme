/**
 * Collapsible Menu functionality for mobile
 */
export function initCollapsibleMenu() {
    const toggles = document.querySelectorAll('.sgu-menu-toggle');
    
    toggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const targetId = toggle.getAttribute('data-menu-target');
            const menu = document.getElementById(targetId);
            const iconOpen = toggle.querySelector('.sgu-menu-icon-open');
            const iconClose = toggle.querySelector('.sgu-menu-icon-close');

            if (!menu) return;

            const isExpanded = toggle.getAttribute('aria-expanded') === 'true';

            if (isExpanded) {
                menu.classList.add('hidden');
                menu.classList.remove('mobile-open', 'md:flex');
                toggle.setAttribute('aria-expanded', 'false');
                if (iconOpen) iconOpen.classList.remove('hidden');
                if (iconClose) iconClose.classList.add('hidden');
            } else {
                menu.classList.remove('hidden');
                menu.classList.add('mobile-open');
                toggle.setAttribute('aria-expanded', 'true');
                if (iconOpen) iconOpen.classList.add('hidden');
                if (iconClose) iconClose.classList.remove('hidden');
            }
        });
    });
}