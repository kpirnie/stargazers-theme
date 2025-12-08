/**
 * Accordion functionality
 */
import { slideToggle } from './dropdown-menu.js';

export function initAccordion() {
    const accordions = document.querySelectorAll('.uk-accordion');

    accordions.forEach(function (accordion) {
        const items = accordion.querySelectorAll('li');

        items.forEach(function (item) {
            const title = item.querySelector('.uk-accordion-title');
            const content = item.querySelector('.uk-accordion-content');

            if (title && content) {
                // Hide content by default
                content.style.display = 'none';
                content.removeAttribute('hidden');
                content.style.removeProperty('display');

                title.addEventListener('click', function (e) {
                    e.preventDefault();

                    // Close all other items in this accordion
                    items.forEach(function (otherItem) {
                        if (otherItem !== item) {
                            const otherContent = otherItem.querySelector('.uk-accordion-content');
                            const otherTitle = otherItem.querySelector('.uk-accordion-title');

                            if (otherContent && otherContent.style.display !== 'none' && otherContent.offsetHeight > 0) {
                                slideToggle(otherContent, 250);
                                otherTitle.classList.remove('active');
                                otherTitle.setAttribute('aria-expanded', 'false');
                            }
                        }
                    });

                    // Toggle this item
                    slideToggle(content, 250);
                    title.classList.toggle('active');

                    const isExpanded = title.getAttribute('aria-expanded') === 'true';
                    title.setAttribute('aria-expanded', !isExpanded);
                });
            }
        });
    });
}