/**
 * Main JavaScript for Stargazers theme
 */
import { initDropdownMenu } from './dropdown-menu.js';
import { initMobileMenu } from './mobile-menu.js';
import { initParallax } from './parallax.js';
import { initScrollToTop } from './scroll-to-top.js';
import { initSmoothScroll } from './smooth-scroll.js';

let initialized = false;

document.addEventListener('DOMContentLoaded', function () {
    if (initialized) return;
    initialized = true;

    initMobileMenu();
    initDropdownMenu();
    initParallax();
    initSmoothScroll();
    initScrollToTop();
});