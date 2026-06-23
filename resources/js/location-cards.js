const HOVER_MEDIA = '(hover: hover) and (pointer: fine)';

function easeOutCubic(t) {
    return 1 - Math.pow(1 - t, 3);
}

function animateDisplacementScale(displacement, to, duration = 700) {
    const from = parseFloat(displacement.getAttribute('scale') || '0');
    const start = performance.now();
    let frame = null;

    return new Promise((resolve) => {
        const step = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const value = from + (to - from) * easeOutCubic(progress);

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

export function initLocationCards() {
    if (! window.matchMedia(HOVER_MEDIA).matches) {
        return;
    }

    document.querySelectorAll('[data-lum-location-card]').forEach((card) => {
        const filter = document.getElementById(card.dataset.filterId);

        if (! filter) {
            return;
        }

        const displacement = filter.querySelector('feDisplacementMap');

        if (! displacement) {
            return;
        }

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

        card.addEventListener('mouseenter', () => {
            card.classList.add('is-hover');
            run(90);
        });

        card.addEventListener('mouseleave', () => {
            card.classList.remove('is-hover');
            run(0);
        });
    });
}
