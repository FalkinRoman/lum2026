const HOVER_MEDIA = '(hover: hover) and (pointer: fine)';

function animateDisplacementScale(displacement, to, duration = 800) {
    const from = parseFloat(displacement.getAttribute('scale') || '0');
    const start = performance.now();
    let frame = null;

    return new Promise((resolve) => {
        const step = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            // Damai smooth ≈ cubic-bezier(.3, 1, .3, 1) — soft ease-out
            const eased = 1 - Math.pow(1 - progress, 3);
            const value = from + (to - from) * eased;

            displacement.setAttribute('scale', String(value));

            if (progress < 1) {
                frame = requestAnimationFrame(step);
                return;
            }

            displacement.setAttribute('scale', String(to));
            resolve();
        };

        if (frame) {
            cancelAnimationFrame(frame);
        }

        frame = requestAnimationFrame(step);
    });
}

function initScrollGuard() {
    let scrolling = false;
    let timer = null;

    window.addEventListener('scroll', () => {
        scrolling = true;
        clearTimeout(timer);
        timer = setTimeout(() => {
            scrolling = false;
        }, 150);
    }, { passive: true });

    return () => scrolling;
}

export function initLocationCards() {
    if (! window.matchMedia(HOVER_MEDIA).matches) {
        return;
    }

    const isScrolling = initScrollGuard();

    document.querySelectorAll('[data-lum-location-card]').forEach((card) => {
        const filterId = card.dataset.filterId;
        const filter = filterId ? document.getElementById(filterId) : null;
        const photo = card.querySelector('[data-lum-location-photo]');
        const displacement = filter?.querySelector('feDisplacementMap') ?? null;

        if (! displacement || ! photo) {
            return;
        }

        const filterUrl = `url(#${filterId})`;
        let running = null;

        const run = (to) => {
            if (running) {
                running.cancelled = true;
            }

            const token = { cancelled: false };
            running = token;

            animateDisplacementScale(displacement, to).then(() => {
                if (! token.cancelled) {
                    running = null;
                }
            });
        };

        const enter = () => {
            if (isScrolling()) {
                return;
            }

            card.classList.add('is-hover');
            photo.style.filter = filterUrl;
            run(90);
        };

        const leave = () => {
            card.classList.remove('is-hover');
            photo.style.filter = '';
            run(0);
        };

        card.addEventListener('mouseenter', enter);
        card.addEventListener('mouseleave', leave);
    });
}
