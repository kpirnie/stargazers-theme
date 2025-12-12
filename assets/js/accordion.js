/**
 * Simple Accordion functionality
 */
export function initAccordion() {
    document.addEventListener('click', function (e) {
        const trigger = e.target.closest('[data-accordion-trigger]');
        if (!trigger) return;

        e.preventDefault();

        const targetId = trigger.getAttribute('data-accordion-trigger');
        const content = document.getElementById(targetId);
        const icon = trigger.querySelector('svg');

        if (content) {
            content.classList.toggle('hidden');
            if (icon) {
                icon.classList.toggle('rotate-180');
            }
        }
    });
}