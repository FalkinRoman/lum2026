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

    const loaded = typeof img.decode === 'function'
        ? img.decode().catch(() => undefined)
        : new Promise((resolve) => {
            if (img.complete) {
                resolve();
                return;
            }

            img.onload = () => resolve();
            img.onerror = () => resolve();
        });

    return Promise.race([
        loaded,
        new Promise((resolve) => {
            window.setTimeout(resolve, 400);
        }),
    ]);
}

function isVisiblePanel(panel) {
    return panel.offsetParent !== null;
}

function normalizeSrc(src) {
    if (! src) {
        return '';
    }

    try {
        return new URL(src, window.location.origin).pathname;
    } catch {
        return src;
    }
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
    const normalized = normalizeSrc(src);

    if (img.dataset.currentSrc === normalized) {
        return false;
    }

    img.src = src;
    img.dataset.currentSrc = normalized;

    return true;
}

function resolveSlideSlot(node) {
    if (! node) {
        return { frame: null, img: null };
    }

    if (node.tagName === 'IMG') {
        return { frame: node, img: node };
    }

    return {
        frame: node,
        img: node.querySelector('img'),
    };
}

function resetSlideMotion(frame) {
    if (! frame) {
        return;
    }

    gsap.killTweensOf(frame);
    frame.getAnimations().forEach((animation) => animation.cancel());
    frame.style.opacity = '';
    frame.style.transform = '';
    gsap.set(frame, { opacity: 1, x: 0, clearProps: 'transform' });
}

function swapSlideImage(slot, nextSrc, direction, reducedMotion) {
    const { frame, img } = resolveSlideSlot(slot);

    if (! frame || ! img || img.dataset.currentSrc === normalizeSrc(nextSrc)) {
        return Promise.resolve();
    }

    if (reducedMotion) {
        assignImage(img, nextSrc);
        resetSlideMotion(frame);

        return Promise.resolve();
    }

    const offset = direction === 'next' ? 48 : -48;

    resetSlideMotion(frame);

    return ensureImageLoaded(nextSrc).then(() => new Promise((resolve) => {
        gsap.to(frame, {
            opacity: 0,
            x: direction === 'next' ? -offset : offset,
            duration: 0.35,
            ease: 'power2.inOut',
            overwrite: 'auto',
            onComplete: () => {
                gsap.set(frame, {
                    opacity: 0,
                    x: direction === 'next' ? offset : -offset,
                });
                assignImage(img, nextSrc);
                gsap.to(frame, {
                    opacity: 1,
                    x: 0,
                    duration: 0.45,
                    ease: 'power2.out',
                    overwrite: 'auto',
                    onComplete: () => {
                        resetSlideMotion(frame);
                        resolve();
                    },
                });
            },
        });
    }));
}

function swapDualSlideImage(slot, nextSrc, direction, reducedMotion) {
    const { frame, img } = resolveSlideSlot(slot);

    if (! frame || ! img || img.dataset.currentSrc === normalizeSrc(nextSrc)) {
        return Promise.resolve();
    }

    if (reducedMotion) {
        assignImage(img, nextSrc);
        resetSlideMotion(frame);

        return Promise.resolve();
    }

    resetSlideMotion(frame);

    const offset = direction === 'next' ? 48 : -48;
    const exitX = direction === 'next' ? -offset : offset;
    const enterX = direction === 'next' ? offset : -offset;

    return ensureImageLoaded(nextSrc).then(() => new Promise((resolve) => {
        const fadeOut = frame.animate(
            [
                { opacity: 1, transform: 'translateX(0px)' },
                { opacity: 0, transform: `translateX(${exitX}px)` },
            ],
            { duration: 350, easing: 'ease-in-out', fill: 'forwards' },
        );

        Promise.race([
            fadeOut.finished,
            new Promise((done) => {
                window.setTimeout(done, 500);
            }),
        ]).then(() => {
            assignImage(img, nextSrc);

            const fadeIn = frame.animate(
                [
                    { opacity: 0, transform: `translateX(${enterX}px)` },
                    { opacity: 1, transform: 'translateX(0px)' },
                ],
                { duration: 450, easing: 'ease-out', fill: 'forwards' },
            );

            return Promise.race([
                fadeIn.finished,
                new Promise((done) => {
                    window.setTimeout(done, 600);
                }),
            ]);
        }).then(() => {
            resetSlideMotion(frame);
            resolve();
        });
    }));
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
                const leftSlot = resolveSlideSlot(panel.querySelector('[data-lum-interior-left]'));
                const rightSlot = resolveSlideSlot(panel.querySelector('[data-lum-interior-right]'));
                const singleSlot = resolveSlideSlot(panel.querySelector('[data-lum-interior-single]'));
                const sources = getSources(panel);

                if (singleSlot.img) {
                    assignImage(singleSlot.img, sources.single);
                    resetSlideMotion(singleSlot.frame);

                    return;
                }

                if (leftSlot.img && rightSlot.img) {
                    assignImage(leftSlot.img, sources.left);
                    assignImage(rightSlot.img, sources.right);
                    resetSlideMotion(leftSlot.frame);
                    resetSlideMotion(rightSlot.frame);
                }
            });

            syncProgress();
            preloadAdjacent();
        };

        const animatePanel = async (panel, direction) => {
            const leftSlot = resolveSlideSlot(panel.querySelector('[data-lum-interior-left]'));
            const rightSlot = resolveSlideSlot(panel.querySelector('[data-lum-interior-right]'));
            const singleSlot = resolveSlideSlot(panel.querySelector('[data-lum-interior-single]'));
            const sources = getSources(panel);

            if (singleSlot.img) {
                await swapSlideImage(singleSlot.frame, sources.single, direction, reducedMotion);

                return;
            }

            if (! leftSlot.frame || ! rightSlot.frame) {
                return;
            }

            if (reducedMotion) {
                assignImage(leftSlot.img, sources.left);
                assignImage(rightSlot.img, sources.right);
                resetSlideMotion(leftSlot.frame);
                resetSlideMotion(rightSlot.frame);

                return;
            }

            await ensureImageLoaded(sources.left);
            await ensureImageLoaded(sources.right);

            await Promise.all([
                swapDualSlideImage(leftSlot.frame, sources.left, direction, reducedMotion),
                swapDualSlideImage(rightSlot.frame, sources.right, direction, reducedMotion),
            ]);
        };

        const go = async (direction) => {
            if (isAnimating) {
                return;
            }

            isAnimating = true;

            try {
                if (direction === 'next') {
                    index = (index + 1) % total;
                } else {
                    index = (index - 1 + total) % total;
                }

                syncProgress();
                preloadAdjacent();

                const visiblePanels = panels.filter(isVisiblePanel);

                if (reducedMotion) {
                    setStateSync();

                    return;
                }

                await Promise.all(visiblePanels.map((panel) => animatePanel(panel, direction)));
                preloadAdjacent();
            } catch {
                setStateSync();
            } finally {
                isAnimating = false;
            }
        };

        prevButtons.forEach((button) => {
            button.addEventListener('click', () => go('prev'));
        });

        nextButtons.forEach((button) => {
            button.addEventListener('click', () => go('next'));
        });

        panels.forEach((panel) => {
            panel.querySelectorAll('[data-lum-interior-left], [data-lum-interior-right], [data-lum-interior-single]').forEach((node) => {
                const { frame, img } = resolveSlideSlot(node);

                if (img) {
                    img.dataset.currentSrc = normalizeSrc(img.currentSrc || img.src);
                }

                resetSlideMotion(frame);
            });
        });

        setStateSync();
    });
}
