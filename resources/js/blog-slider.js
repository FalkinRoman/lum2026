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

        const getStep = () => {
            const delta = cards[1].offsetLeft - cards[0].offsetLeft;

            return delta > 1
                ? delta
                : cards[0].offsetWidth + (Number(root.dataset.gap) || 0);
        };

        const getViewport = () => track.parentElement?.clientWidth || track.clientWidth;

        /** Max translate so the last card sits flush with the viewport right edge */
        const getMaxX = () => {
            const last = cards[cards.length - 1];
            const total = last.offsetLeft + last.offsetWidth;

            return Math.max(0, total - getViewport());
        };

        const getMaxIndex = () => {
            const step = getStep();
            const maxX = getMaxX();

            if (step < 1 || maxX < 1) {
                return 0;
            }

            return Math.max(0, Math.ceil(maxX / step - 0.01));
        };

        const xForIndex = (i) => Math.min(i * getStep(), getMaxX());

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

            if (getStep() < 1) {
                return;
            }

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
