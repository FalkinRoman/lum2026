import gsap from 'gsap';

const DEFAULT_TOTAL = 7;
const DEFAULT_START = 0;

function padSlideNumber(value) {
    return String(value).padStart(2, '0');
}

function slideName(slides, index) {
    return slides[((index % slides.length) + slides.length) % slides.length];
}

function buildSrc(base, name, suffix = '') {
    return `${base}/${name}${suffix}.webp`;
}

function preloadImage(src) {
    const img = new Image();
    img.src = src;
}

function setProgressItem(item, active, activeSrc, lineClass) {
    const line = item.querySelector('[data-lum-interior-progress-line]');
    const marker = item.querySelector('[data-lum-interior-progress-active]');

    if (! line || ! marker) {
        return;
    }

    if (active) {
        line.classList.add('hidden');
        marker.classList.remove('hidden');
        marker.src = activeSrc;
    } else {
        line.classList.remove('hidden');
        marker.classList.add('hidden');
        line.className = lineClass;
    }
}

function animateImage(img, nextSrc, reducedMotion) {
    if (! img || img.dataset.currentSrc === nextSrc) {
        return Promise.resolve();
    }

    if (reducedMotion) {
        img.src = nextSrc;
        img.dataset.currentSrc = nextSrc;

        return Promise.resolve();
    }

    return new Promise((resolve) => {
        gsap.to(img, {
            opacity: 0,
            x: -24,
            duration: 0.35,
            ease: 'power2.inOut',
            onComplete: () => {
                img.src = nextSrc;
                img.dataset.currentSrc = nextSrc;
                gsap.fromTo(
                    img,
                    { opacity: 0, x: 24 },
                    {
                        opacity: 1,
                        x: 0,
                        duration: 0.45,
                        ease: 'power2.out',
                        onComplete: resolve,
                    },
                );
            },
        });
    });
}

function animateSingleImage(img, nextSrc, direction, reducedMotion) {
    if (! img || img.dataset.currentSrc === nextSrc) {
        return Promise.resolve();
    }

    if (reducedMotion) {
        img.src = nextSrc;
        img.dataset.currentSrc = nextSrc;

        return Promise.resolve();
    }

    const offset = direction === 'next' ? 48 : -48;

    return new Promise((resolve) => {
        gsap.to(img, {
            opacity: 0,
            x: -offset,
            duration: 0.35,
            ease: 'power2.inOut',
            onComplete: () => {
                img.src = nextSrc;
                img.dataset.currentSrc = nextSrc;
                gsap.fromTo(
                    img,
                    { opacity: 0, x: offset },
                    {
                        opacity: 1,
                        x: 0,
                        duration: 0.45,
                        ease: 'power2.out',
                        onComplete: resolve,
                    },
                );
            },
        });
    });
}

export function initInteriorCarousel() {
    document.querySelectorAll('[data-lum-interior-carousel]').forEach((root) => {
        const slides = JSON.parse(root.dataset.slides || '[]');
        const base = root.dataset.imgBase || '';
        const total = Number.parseInt(root.dataset.total || `${DEFAULT_TOTAL}`, 10);
        let index = Number.parseInt(root.dataset.start || `${DEFAULT_START}`, 10);
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const activeSrc = root.dataset.progressActive || '';
        let isAnimating = false;

        const panels = [...root.querySelectorAll('[data-lum-interior-panel]')];
        const prevButtons = root.querySelectorAll('[data-lum-interior-prev]');
        const nextButtons = root.querySelectorAll('[data-lum-interior-next]');
        const counters = root.querySelectorAll('[data-lum-interior-current]');
        const progressRows = root.querySelectorAll('[data-lum-interior-progress]');

        if (! slides.length || ! panels.length) {
            return;
        }

        const getSources = (panel) => {
            const suffix = panel.dataset.lumInteriorSuffix || '';

            return {
                left: buildSrc(base, slideName(slides, index), suffix),
                right: buildSrc(base, slideName(slides, index + 1), suffix),
                single: buildSrc(base, slideName(slides, index), suffix),
            };
        };

        const syncProgress = () => {
            progressRows.forEach((row) => {
                const lineClass = row.dataset.lineClass || '';
                const items = row.querySelectorAll('[data-lum-interior-progress-item]');

                items.forEach((item, itemIndex) => {
                    setProgressItem(item, itemIndex === index, activeSrc, lineClass);
                });
            });

            counters.forEach((counter) => {
                counter.textContent = padSlideNumber(index + 1);
            });
        };

        const applyState = async (direction = 'next', animate = true) => {
            const tasks = panels.map((panel) => {
                const left = panel.querySelector('[data-lum-interior-left]');
                const right = panel.querySelector('[data-lum-interior-right]');
                const single = panel.querySelector('[data-lum-interior-single]');
                const sources = getSources(panel);

                if (single) {
                    return animate
                        ? animateSingleImage(single, sources.single, direction, reducedMotion)
                        : Promise.resolve((single.src = sources.single, single.dataset.currentSrc = sources.single));
                }

                if (left && right) {
                    if (! animate || reducedMotion) {
                        left.src = sources.left;
                        right.src = sources.right;
                        left.dataset.currentSrc = sources.left;
                        right.dataset.currentSrc = sources.right;

                        return Promise.resolve();
                    }

                    return Promise.all([
                        animateImage(left, sources.left, reducedMotion),
                        animateImage(right, sources.right, reducedMotion),
                    ]);
                }

                return Promise.resolve();
            });

            syncProgress();
            preloadImage(buildSrc(base, slideName(slides, index + 2), ''));
            preloadImage(buildSrc(base, slideName(slides, index - 1), ''));

            await Promise.all(tasks);
        };

        const go = async (direction) => {
            if (isAnimating) {
                return;
            }

            isAnimating = true;

            if (direction === 'next') {
                index = (index + 1) % total;
            } else {
                index = (index - 1 + total) % total;
            }

            await applyState(direction, true);
            isAnimating = false;
        };

        prevButtons.forEach((button) => {
            button.addEventListener('click', () => go('prev'));
        });

        nextButtons.forEach((button) => {
            button.addEventListener('click', () => go('next'));
        });

        panels.forEach((panel) => {
            panel.querySelectorAll('[data-lum-interior-left], [data-lum-interior-right], [data-lum-interior-single]').forEach((img) => {
                gsap.set(img, { opacity: 1, x: 0 });
            });
        });

        applyState('next', false);
    });
}
