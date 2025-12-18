import { initAccordion } from './accordion.js';
import { initDropdownMenu } from './dropdown-menu.js';
import { initImageModal } from './image-modal.js';
import { initMobileMenu } from './mobile-menu.js';
import { initCollapsibleMenu } from './collapsible-menu.js';
import { initParallax } from './parallax.js';
import { initScrollToTop } from './scroll-to-top.js';
import { initSmoothScroll } from './smooth-scroll.js';

let initialized = false;

document.addEventListener('DOMContentLoaded', function () {
    if (initialized) return;
    initialized = true;

    initMobileMenu();
    initDropdownMenu();
    initAccordion();
    initImageModal();
    initCollapsibleMenu();
    initParallax();
    initSmoothScroll();
    initScrollToTop();
});