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

    return img;
}

function ensureImageLoaded(src) {
    const img = preloadImage(src);

    if (typeof img.decode === 'function') {
        return img.decode().catch(() => undefined);
    }

    return new Promise((resolve) => {
        if (img.complete) {
            resolve();
            return;
        }

        img.onload = () => resolve();
        img.onerror = () => resolve();
    });
}

function isVisiblePanel(panel) {
    return panel.offsetParent !== null;
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

function assignImage(img, src) {
    img.src = src;
    img.dataset.currentSrc = src;
}

function swapSlideImage(img, nextSrc, direction, reducedMotion) {
    if (! img || img.dataset.currentSrc === nextSrc) {
        return Promise.resolve();
    }

    if (reducedMotion) {
        assignImage(img, nextSrc);

        return Promise.resolve();
    }

    const offset = direction === 'next' ? 48 : -48;

    return ensureImageLoaded(nextSrc).then(() => new Promise((resolve) => {
        gsap.to(img, {
            opacity: 0,
            x: direction === 'next' ? -offset : offset,
            duration: 0.35,
            ease: 'power2.inOut',
            onComplete: () => {
                gsap.set(img, {
                    opacity: 0,
                    x: direction === 'next' ? offset : -offset,
                });
                assignImage(img, nextSrc);
                gsap.to(img, {
                    opacity: 1,
                    x: 0,
                    duration: 0.45,
                    ease: 'power2.out',
                    onComplete: resolve,
                });
            },
        });
    }));
}

function transferImage(target, source, src) {
    gsap.set(target, { opacity: 1, x: 0 });
    assignImage(target, src);

    if (source && source.dataset.currentSrc === src) {
        gsap.set(source, { opacity: 1, x: 0 });
    }
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

        const preloadAdjacent = () => {
            panels.forEach((panel) => {
                const suffix = panel.dataset.lumInteriorSuffix || '';

                ensureImageLoaded(buildSrc(base, slideName(slides, index + 1), suffix));
                ensureImageLoaded(buildSrc(base, slideName(slides, index - 1), suffix));
                ensureImageLoaded(buildSrc(base, slideName(slides, index + 2), suffix));
            });
        };

        const setStateSync = () => {
            panels.forEach((panel) => {
                const left = panel.querySelector('[data-lum-interior-left]');
                const right = panel.querySelector('[data-lum-interior-right]');
                const single = panel.querySelector('[data-lum-interior-single]');
                const sources = getSources(panel);

                if (single) {
                    assignImage(single, sources.single);
                    gsap.set(single, { opacity: 1, x: 0 });

                    return;
                }

                if (left && right) {
                    assignImage(left, sources.left);
                    assignImage(right, sources.right);
                    gsap.set([left, right], { opacity: 1, x: 0 });
                }
            });

            syncProgress();
            preloadAdjacent();
        };

        const animatePanel = async (panel, direction) => {
            const left = panel.querySelector('[data-lum-interior-left]');
            const right = panel.querySelector('[data-lum-interior-right]');
            const single = panel.querySelector('[data-lum-interior-single]');
            const sources = getSources(panel);

            if (single) {
                await swapSlideImage(single, sources.single, direction, reducedMotion);

                return;
            }

            if (! left || ! right) {
                return;
            }

            if (reducedMotion) {
                assignImage(left, sources.left);
                assignImage(right, sources.right);

                return;
            }

            await ensureImageLoaded(sources.left);
            await ensureImageLoaded(sources.right);

            if (direction === 'next' && right.dataset.currentSrc === sources.left) {
                transferImage(left, right, sources.left);
                await swapSlideImage(right, sources.right, direction, reducedMotion);

                return;
            }

            if (direction === 'prev' && left.dataset.currentSrc === sources.right) {
                transferImage(right, left, sources.right);
                await swapSlideImage(left, sources.left, direction, reducedMotion);

                return;
            }

            await Promise.all([
                swapSlideImage(left, sources.left, direction, reducedMotion),
                swapSlideImage(right, sources.right, direction, reducedMotion),
            ]);
        };

        const applyState = async (direction = 'next', animate = true) => {
            const visiblePanels = panels.filter(isVisiblePanel);

            if (! animate || reducedMotion) {
                setStateSync();

                return;
            }

            await Promise.all(visiblePanels.map((panel) => animatePanel(panel, direction)));

            syncProgress();
            preloadAdjacent();
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
                img.dataset.currentSrc = img.currentSrc || img.src;
                gsap.set(img, { opacity: 1, x: 0 });
            });
        });

        setStateSync();
    });
}
