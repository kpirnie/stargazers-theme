/**
 * Parallax functionality
 */
export function initParallax() {
    const parallaxElements = document.querySelectorAll('.parallax');

    if (parallaxElements.length === 0) return;

    parallaxElements.forEach(function (element) {
        const speed = parseFloat(element.getAttribute('data-parallax-speed')) || 0.5;
        const direction = element.getAttribute('data-parallax-direction') || 'vertical';

        element.style.willChange = 'transform';

        // Calculate initial centering offset
        const containerHeight = element.parentElement.offsetHeight;
        const imageHeight = element.offsetHeight;
        const initialCenterOffset = (containerHeight - imageHeight) / 2;

        function updateParallax() {
            const scrolled = window.pageYOffset;
            const rect = element.getBoundingClientRect();
            const windowHeight = window.innerHeight;

            // Calculate parallax offset relative to viewport center
            const elementCenter = rect.top + (containerHeight / 2);
            const viewportCenter = windowHeight / 2;
            const distanceFromCenter = elementCenter - viewportCenter;

            // Apply parallax based on distance from center, plus initial centering
            const yPos = initialCenterOffset + (distanceFromCenter * speed * -1);

            if (direction === 'horizontal') {
                element.style.transform = `translateX(${yPos}px)`;
            } else if (direction === 'both') {
                element.style.transform = `translate(${yPos}px, ${yPos}px)`;
            } else {
                element.style.transform = `translateY(${yPos}px)`;
            }
        }

        let ticking = false;
        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(function () {
                    updateParallax();
                    ticking = false;
                });
                ticking = true;
            }
        });

        updateParallax();
    });
}