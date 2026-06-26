export function initHeroTitle() {
    const titles = document.querySelectorAll('[data-lum-hero-title]');

    if (! titles.length) {
        return;
    }

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    titles.forEach((title) => {
        if (prefersReducedMotion) {
            title.classList.add('is-revealed');

            return;
        }

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                title.classList.add('is-revealed');
            });
        });
    });
}
