/**
 * Dropdown Menu functionality
 */

// UIKit3 Accordion-style animation helper
export function slideToggle(element, duration = 300) {

    if (element.style.display === 'none' || !element.style.display || element.offsetHeight === 0) {
        // Slide down
        element.style.display = 'block';
        element.style.height = '0';
        element.style.overflow = 'hidden';

        const height = element.scrollHeight;

        element.style.transition = `height ${duration}ms cubic-bezier(0.4, 0, 0.2, 1)`;

        requestAnimationFrame(function () {
            element.style.height = height + 'px';
        });

        setTimeout(function () {
            element.style.height = '';
            element.style.overflow = '';
            element.style.transition = '';
        }, duration);
    } else {
        // Slide up
        element.style.height = element.scrollHeight + 'px';
        element.style.overflow = 'hidden';
        element.style.transition = `height ${duration}ms cubic-bezier(0.4, 0, 0.2, 1)`;

        requestAnimationFrame(function () {
            element.style.height = '0';
        });

        setTimeout(function () {
            element.style.display = 'none';
            element.style.height = '';
            element.style.overflow = '';
            element.style.transition = '';
        }, duration);
    }
}

// Add arrows to menu items with children
function addArrowsToMenuItems(selector) {
    const menuItems = document.querySelectorAll(selector + ' .menu-item-has-children > a');

    menuItems.forEach(function (link) {
        if (!link.querySelector('.menu-arrow')) {
            const arrow = document.createElement('span');
            arrow.className = 'menu-arrow inline-block ml-1 transition-transform duration-200';
            arrow.innerHTML = '<svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>';
            link.appendChild(arrow);
        }
    });
}

// Desktop dropdown menu handling
function handleDesktopMenu() {
    const menuItems = document.querySelectorAll('#site-navigation .menu-item-has-children');

    menuItems.forEach(function (item) {
        const link = item.querySelector(':scope > a');
        const submenu = item.querySelector(':scope > .submenu');
        const arrow = link ? link.querySelector('.menu-arrow') : null;

        if (submenu && link) {
            submenu.style.display = 'none';

            link.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                const isOpen = submenu.style.display !== 'none' && submenu.offsetHeight > 0;

                // Close all sibling submenus
                const parentItem = item.parentElement;
                if (parentItem) {
                    parentItem.querySelectorAll(':scope > .menu-item-has-children > .submenu').forEach(function (otherSubmenu) {
                        if (otherSubmenu !== submenu && otherSubmenu.style.display !== 'none') {
                            slideToggle(otherSubmenu, 250);
                            const otherItem = otherSubmenu.closest('.menu-item-has-children');
                            const otherArrow = otherItem.querySelector(':scope > a .menu-arrow');
                            if (otherArrow) {
                                otherArrow.style.transform = 'rotate(0deg)';
                            }
                        }
                    });
                }

                // Toggle this submenu
                slideToggle(submenu, 250);

                if (arrow) {
                    arrow.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
                }

                // Close nested submenus when closing parent
                submenu.querySelectorAll('.submenu').forEach(function (nestedSubmenu) {
                    if (nestedSubmenu.style.display !== 'none') {
                        slideToggle(nestedSubmenu, 250);
                        const nestedArrow = nestedSubmenu.closest('.menu-item-has-children').querySelector(':scope > a .menu-arrow');
                        if (nestedArrow) {
                            nestedArrow.style.transform = 'rotate(0deg)';
                        }
                    }
                });
            });

            submenu.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        }
    });
}

// Mobile dropdown menu handling
function handleMobileMenu() {
    const menuItems = document.querySelectorAll('#mobile-menu .menu-item-has-children');

    menuItems.forEach(function (item) {
        const link = item.querySelector(':scope > a');
        const submenu = item.querySelector(':scope > ul');
        const arrow = link ? link.querySelector('.menu-arrow') : null;

        if (submenu && link) {
            submenu.style.display = 'none';
            submenu.classList.add('ml-4', 'mt-2', 'space-y-2');

            link.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                const isOpen = submenu.style.display !== 'none' && submenu.offsetHeight > 0;

                slideToggle(submenu, 250);

                if (arrow) {
                    if (isOpen) {
                        arrow.style.transform = 'rotate(0deg)';

                        submenu.querySelectorAll('ul').forEach(function (nestedSubmenu) {
                            if (nestedSubmenu.style.display !== 'none') {
                                slideToggle(nestedSubmenu, 250);
                                const nestedArrow = nestedSubmenu.closest('.menu-item-has-children').querySelector(':scope > a .menu-arrow');
                                if (nestedArrow) {
                                    nestedArrow.style.transform = 'rotate(0deg)';
                                }
                            }
                        });
                    } else {
                        arrow.style.transform = 'rotate(180deg)';
                    }
                }
            });

            submenu.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        }
    });
}

// Close dropdowns when clicking outside
function handleOutsideClick() {
    document.addEventListener('click', function (event) {
        const nav = document.querySelector('#site-navigation');
        if (nav && !nav.contains(event.target)) {
            document.querySelectorAll('#site-navigation .submenu').forEach(function (submenu) {
                if (submenu.style.display !== 'none' && submenu.offsetHeight > 0) {
                    slideToggle(submenu, 250);
                    const item = submenu.closest('.menu-item-has-children');
                    const arrow = item ? item.querySelector(':scope > a .menu-arrow') : null;
                    if (arrow) {
                        arrow.style.transform = 'rotate(0deg)';
                    }
                }
            });
        }
    });
}

export function initDropdownMenu() {
    addArrowsToMenuItems('#site-navigation');
    addArrowsToMenuItems('#mobile-menu');
    handleDesktopMenu();
    handleMobileMenu();
    handleOutsideClick();
}