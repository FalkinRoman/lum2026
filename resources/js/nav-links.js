export function initNavLinks() {
    if (! window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
        return;
    }

    document.querySelectorAll('.lum-nav').forEach((nav) => {
        const links = [...nav.querySelectorAll('.lum-nav-link--inline')];

        links.forEach((link) => {
            const slide = link.querySelector('.lum-nav-link__slide');

            if (! slide) {
                return;
            }

            link.addEventListener('mouseenter', () => {
                if (slide.classList.contains('is-shifted')) {
                    return;
                }

                links.forEach((other) => {
                    const otherSlide = other.querySelector('.lum-nav-link__slide');

                    if (! otherSlide || other === link) {
                        return;
                    }

                    otherSlide.classList.add('is-resetting');
                    otherSlide.classList.remove('is-shifted');
                    other.classList.remove('is-shifted');
                    window.requestAnimationFrame(() => {
                        otherSlide.classList.remove('is-resetting');
                    });
                });

                slide.classList.add('is-shifted');
                link.classList.add('is-shifted');
            });
        });

        nav.addEventListener('mouseleave', () => {
            links.forEach((link) => {
                const slide = link.querySelector('.lum-nav-link__slide');

                if (! slide) {
                    return;
                }

                slide.classList.add('is-resetting');
                slide.classList.remove('is-shifted');
                link.classList.remove('is-shifted');
                window.requestAnimationFrame(() => {
                    slide.classList.remove('is-resetting');
                });
            });
        });
    });
}
