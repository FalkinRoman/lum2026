import gsap from 'gsap';

/** Blog cards — slightly snappier than full Damai 1.2s media slides */
const SLIDE_DURATION = 0.9;
const SLIDE_EASE = 'power2.inOut';

function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

export function initBlogSlider() {
    document.querySelectorAll('[data-lum-blog-slider]').forEach((root) => {
        const track = root.querySelector('[data-lum-blog-track]');
        const prev = root.querySelector('[data-lum-blog-prev]');
        const next = root.querySelector('[data-lum-blog-next]');

        if (! track || ! prev || ! next) {
            return;
        }

        const cards = [...track.querySelectorAll('[data-lum-blog-card]')];

        if (cards.length < 2) {
            prev.disabled = true;
            next.disabled = true;

            return;
        }

        track.style.overflowX = 'visible';
        track.style.willChange = 'transform';
        gsap.set(track, { x: 0, force3D: true });

        let index = 0;
        let tween = null;

        const getViewport = () => {
            const viewport = track.parentElement;

            return viewport?.clientWidth || track.clientWidth;
        };

        const getStartPad = () => Number.parseFloat(getComputedStyle(track).paddingLeft) || 0;

        const getEndPad = () => Number.parseFloat(getComputedStyle(track).paddingRight) || 0;

        /** Max translate so last card keeps trailing pad from the screen edge */
        const getMaxX = () => {
            const last = cards[cards.length - 1];
            const total = last.offsetLeft + last.offsetWidth + getEndPad();

            return Math.max(0, total - getViewport());
        };

        /**
         * Align each card to the leading pad (same inset as the first).
         * Left ivory mask covers the gutter so the previous card never peeks;
         * cards still animate into the full left edge under that mask.
         */
        const xForIndex = (i) => {
            const startPad = getStartPad();
            const desired = Math.max(0, cards[i].offsetLeft - startPad);

            return Math.min(desired, getMaxX());
        };

        const getMaxIndex = () => {
            const maxX = getMaxX();

            if (maxX < 1) {
                return 0;
            }

            const startPad = getStartPad();
            let maxIndex = 0;

            for (let i = 0; i < cards.length; i += 1) {
                const desired = Math.max(0, cards[i].offsetLeft - startPad);

                maxIndex = i;

                if (desired >= maxX - 0.5) {
                    break;
                }
            }

            return maxIndex;
        };

        const syncButtons = () => {
            const maxIndex = getMaxIndex();

            prev.disabled = index <= 0;
            next.disabled = index >= maxIndex;
            prev.classList.toggle('opacity-40', index <= 0);
            next.classList.toggle('opacity-40', index >= maxIndex);
        };

        const goTo = (nextIndex) => {
            const maxIndex = getMaxIndex();
            const clamped = Math.max(0, Math.min(maxIndex, nextIndex));
            const x = xForIndex(clamped);

            index = clamped;
            tween?.kill();
            tween = gsap.to(track, {
                x: -x,
                duration: prefersReducedMotion() ? 0 : SLIDE_DURATION,
                ease: SLIDE_EASE,
                overwrite: true,
                onComplete: () => {
                    tween = null;
                },
            });
            syncButtons();
        };

        prev.addEventListener('click', (event) => {
            event.preventDefault();
            goTo(index - 1);
        });

        next.addEventListener('click', (event) => {
            event.preventDefault();
            goTo(index + 1);
        });

        window.addEventListener('resize', () => {
            tween?.kill();
            const maxIndex = getMaxIndex();
            index = Math.min(index, maxIndex);
            gsap.set(track, { x: -xForIndex(index) });
            syncButtons();
        });

        syncButtons();
    });
}
