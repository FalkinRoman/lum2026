import gsap from 'gsap';

const DEFAULT_TOTAL = 7;
const DEFAULT_START = 0;
const AUTOPLAY_DURATION = 5;
/** Damai double-slider: Swiper speed 1200 + parallax 12.5% */
const SLIDE_DURATION = 1.2;
const PARALLAX_PERCENT = 12.5;

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

function resolveSlideSlot(node) {
    if (! node) {
        return { frame: null, host: null };
    }

    if (node.tagName === 'IMG') {
        const frame = ensureImageFrame(node);

        return {
            frame,
            host: frame.querySelector('[data-lum-interior-host]') ?? frame,
        };
    }

    let host = node.querySelector(':scope > [data-lum-interior-host]');

    if (! host) {
        host = document.createElement('div');
        host.className = 'lum-interior-slide__host absolute inset-0';
        host.dataset.lumInteriorHost = '';

        while (node.firstChild) {
            host.appendChild(node.firstChild);
        }

        node.appendChild(host);

        // keep existing position (absolute frames must stay absolute — never add relative)
        if (! node.classList.contains('overflow-hidden')) {
            node.classList.add('overflow-hidden');
        }
    }

    return { frame: node, host };
}

function ensureImageFrame(img) {
    if (img.parentElement?.hasAttribute('data-lum-interior-frame')) {
        return img.parentElement;
    }

    const frame = document.createElement('div');
    frame.dataset.lumInteriorFrame = '';
    // preserve absolute/top/left classes from the img — only force overflow clip
    frame.className = `${img.className} overflow-hidden`;
    img.className = 'absolute inset-0 h-full w-full object-cover';
    img.parentNode.insertBefore(frame, img);

    const host = document.createElement('div');
    host.className = 'lum-interior-slide__host absolute inset-0';
    host.dataset.lumInteriorHost = '';
    host.appendChild(img);
    frame.appendChild(host);

    return frame;
}

function assignHostSrc(host, src) {
    const img = host.querySelector('img');

    if (! img) {
        return false;
    }

    const normalized = normalizeSrc(src);

    if (img.dataset.currentSrc === normalized) {
        return false;
    }

    img.src = src;
    img.dataset.currentSrc = normalized;

    return true;
}

function fillHost(host, src) {
    assignHostSrc(host, src);
}

/**
 * Counter flips with the same duration/ease as the Damai slide.
 */
function animateCounter(counter, nextLabel, direction, reducedMotion) {
    const viewport = counter.querySelector('.lum-interior-counter__viewport');
    let text = counter.querySelector('[data-lum-interior-current-text]');

    if (! viewport) {
        counter.textContent = nextLabel;

        return Promise.resolve();
    }

    if (! text) {
        text = document.createElement('span');
        text.className = 'lum-interior-counter__text';
        text.dataset.lumInteriorCurrentText = '';
        viewport.appendChild(text);
    }

    if (text.textContent === nextLabel) {
        return Promise.resolve();
    }

    if (reducedMotion) {
        text.textContent = nextLabel;

        return Promise.resolve();
    }

    const dir = direction === 'next' ? 1 : -1;
    const incoming = text.cloneNode(true);

    incoming.textContent = nextLabel;
    incoming.className = 'lum-interior-counter__text';
    incoming.dataset.lumInteriorCurrentText = '';
    viewport.appendChild(incoming);

    const width = Math.ceil(Math.max(text.offsetWidth, incoming.offsetWidth));

    gsap.set(viewport, { position: 'relative', width, height: '1em' });
    gsap.set(text, { position: 'absolute', left: 0, top: 0, yPercent: 0 });
    gsap.set(incoming, { position: 'absolute', left: 0, top: 0, yPercent: dir * 100 });

    return new Promise((resolve) => {
        gsap.timeline({
            defaults: { duration: SLIDE_DURATION, ease: 'power2.inOut' },
            onComplete: () => {
                text.remove();
                gsap.set(incoming, { clearProps: 'transform,y,yPercent,position,left,top' });
                gsap.set(viewport, { clearProps: 'width' });
                resolve();
            },
        })
            .to(text, { yPercent: -dir * 100 }, 0)
            .to(incoming, { yPercent: 0 }, 0);
    });
}

/**
 * Damai dining double-slider feel:
 * https://thedamai.com/dining — synced containers, slide + inner parallax 12.5%, 1.2s
 */
function animateDamaiSlot(frame, host, nextSrc, direction, reducedMotion) {
    if (! frame || ! host) {
        return Promise.resolve();
    }

    const img = host.querySelector('img');
    const current = normalizeSrc(img?.dataset.currentSrc || img?.src);
    const next = normalizeSrc(nextSrc);

    if (current === next) {
        return Promise.resolve();
    }

    if (reducedMotion) {
        fillHost(host, nextSrc);

        return Promise.resolve();
    }

    const dir = direction === 'next' ? 1 : -1;

    return ensureImageLoaded(nextSrc).then(() => new Promise((resolve) => {
        const outgoingSlide = document.createElement('div');
        outgoingSlide.className = 'lum-interior-slide absolute inset-0 z-[2] overflow-hidden';
        const outgoingInner = document.createElement('div');
        outgoingInner.className = 'lum-interior-slide__inner absolute inset-0 h-full w-full will-change-transform';
        [...host.childNodes].forEach((node) => outgoingInner.appendChild(node.cloneNode(true)));
        outgoingSlide.appendChild(outgoingInner);

        const incomingSlide = document.createElement('div');
        incomingSlide.className = 'lum-interior-slide absolute inset-0 z-[1] overflow-hidden';
        const incomingInner = document.createElement('div');
        incomingInner.className = 'lum-interior-slide__inner absolute inset-0 h-full w-full will-change-transform';
        [...host.childNodes].forEach((node) => incomingInner.appendChild(node.cloneNode(true)));
        incomingSlide.appendChild(incomingInner);

        const incomingImg = incomingInner.querySelector('img');

        if (incomingImg) {
            incomingImg.src = nextSrc;
            incomingImg.dataset.currentSrc = next;
        }

        // Swiper parallax: slide moves 100%, inner counters ~12.5%
        gsap.set(outgoingSlide, { xPercent: 0 });
        gsap.set(outgoingInner, { xPercent: 0 });
        gsap.set(incomingSlide, { xPercent: dir * 100 });
        gsap.set(incomingInner, { xPercent: -dir * PARALLAX_PERCENT });

        frame.appendChild(outgoingSlide);
        frame.appendChild(incomingSlide);
        host.style.visibility = 'hidden';

        gsap.timeline({
            defaults: { duration: SLIDE_DURATION, ease: 'power2.inOut' },
            onComplete: () => {
                fillHost(host, nextSrc);
                host.style.visibility = '';
                outgoingSlide.remove();
                incomingSlide.remove();
                gsap.set([outgoingSlide, outgoingInner, incomingSlide, incomingInner], {
                    clearProps: 'transform,x,xPercent',
                });
                resolve();
            },
        })
            .to(outgoingSlide, { xPercent: -dir * 100 }, 0)
            .to(outgoingInner, { xPercent: dir * PARALLAX_PERCENT }, 0)
            .to(incomingSlide, { xPercent: 0 }, 0)
            .to(incomingInner, { xPercent: 0 }, 0);
    }));
}

export function initInteriorCarousel() {
    document.querySelectorAll('[data-lum-interior-carousel]').forEach((root) => {
        const slides = JSON.parse(root.dataset.slides || '[]');
        const base = root.dataset.imgBase || '';
        const total = Number.parseInt(root.dataset.total || `${DEFAULT_TOTAL}`, 10);
        let index = Number.parseInt(root.dataset.start || `${DEFAULT_START}`, 10);
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let isAnimating = false;
        let progressTween = null;
        let autoplayEnabled = ! reducedMotion;

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

        const killProgress = () => {
            if (progressTween) {
                progressTween.kill();
                progressTween = null;
            }
        };

        const syncProgressUi = ({ animateDots = false } = {}) => {
            progressRows.forEach((row) => {
                row.querySelectorAll('[data-lum-interior-progress-item]').forEach((item) => {
                    const itemIndex = Number.parseInt(item.dataset.index || '0', 10);
                    const fill = item.querySelector('[data-lum-interior-progress-fill]');
                    const dot = item.querySelector('[data-lum-interior-progress-dot]');
                    const active = itemIndex === index;

                    if (fill) {
                        gsap.killTweensOf(fill);
                        gsap.set(fill, { scaleX: 0, opacity: active ? 1 : 0 });
                    }

                    if (! dot) {
                        return;
                    }

                    gsap.killTweensOf(dot);

                    if (animateDots && ! reducedMotion) {
                        gsap.to(dot, {
                            opacity: active ? 1 : 0,
                            y: active ? 0 : 4,
                            duration: SLIDE_DURATION * 0.55,
                            ease: 'power2.inOut',
                            overwrite: true,
                        });
                    } else {
                        gsap.set(dot, { opacity: active ? 1 : 0, y: active ? 0 : 4 });
                    }
                });
            });
        };

        const syncCountersInstant = () => {
            const label = padSlideNumber(index + 1);

            counters.forEach((counter) => {
                const text = counter.querySelector('[data-lum-interior-current-text]');

                if (text) {
                    text.textContent = label;
                } else {
                    counter.textContent = label;
                }
            });
        };

        const animateCounters = (direction) => {
            const label = padSlideNumber(index + 1);

            return Promise.all(
                [...counters].map((counter) => {
                    const panel = counter.closest('[data-lum-interior-panel]');

                    if (panel && ! isVisiblePanel(panel)) {
                        const text = counter.querySelector('[data-lum-interior-current-text]');

                        if (text) {
                            text.textContent = label;
                        } else {
                            counter.textContent = label;
                        }

                        return Promise.resolve();
                    }

                    return animateCounter(counter, label, direction, reducedMotion);
                }),
            );
        };

        const startProgress = () => {
            killProgress();

            if (! autoplayEnabled) {
                return;
            }

            const fills = [];

            progressRows.forEach((row) => {
                const panel = row.closest('[data-lum-interior-panel]');

                if (panel && ! isVisiblePanel(panel)) {
                    return;
                }

                const item = row.querySelector(`[data-lum-interior-progress-item][data-index="${index}"]`);
                const fill = item?.querySelector('[data-lum-interior-progress-fill]');

                if (fill) {
                    fills.push(fill);
                }
            });

            if (! fills.length) {
                return;
            }

            gsap.set(fills, { scaleX: 0, opacity: 1, transformOrigin: 'left center' });

            // Damai: tl.to('.swiper-progress', { duration: 5, scaleX: 1, ease: Power1.easeInOut })
            progressTween = gsap.to(fills, {
                scaleX: 1,
                duration: AUTOPLAY_DURATION,
                ease: 'power1.inOut',
                overwrite: true,
                onComplete: () => {
                    progressTween = null;
                    go('next');
                },
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

                if (singleSlot.host) {
                    fillHost(singleSlot.host, sources.single);

                    return;
                }

                if (leftSlot.host && rightSlot.host) {
                    fillHost(leftSlot.host, sources.left);
                    fillHost(rightSlot.host, sources.right);
                }
            });

            syncProgressUi();
            syncCountersInstant();
            preloadAdjacent();
        };

        const animatePanel = async (panel, direction) => {
            const leftSlot = resolveSlideSlot(panel.querySelector('[data-lum-interior-left]'));
            const rightSlot = resolveSlideSlot(panel.querySelector('[data-lum-interior-right]'));
            const singleSlot = resolveSlideSlot(panel.querySelector('[data-lum-interior-single]'));
            const sources = getSources(panel);

            if (singleSlot.frame && singleSlot.host) {
                await animateDamaiSlot(singleSlot.frame, singleSlot.host, sources.single, direction, reducedMotion);

                return;
            }

            if (! leftSlot.frame || ! rightSlot.frame) {
                return;
            }

            await Promise.all([
                animateDamaiSlot(leftSlot.frame, leftSlot.host, sources.left, direction, reducedMotion),
                animateDamaiSlot(rightSlot.frame, rightSlot.host, sources.right, direction, reducedMotion),
            ]);
        };

        const go = async (direction) => {
            if (isAnimating) {
                return;
            }

            isAnimating = true;
            killProgress();

            try {
                if (direction === 'next') {
                    index = (index + 1) % total;
                } else {
                    index = (index - 1 + total) % total;
                }

                syncProgressUi({ animateDots: true });
                preloadAdjacent();

                const visiblePanels = panels.filter(isVisiblePanel);

                if (reducedMotion || ! visiblePanels.length) {
                    setStateSync();
                } else {
                    // preload first so slide + counter start together
                    await Promise.all(visiblePanels.flatMap((panel) => {
                        const sources = getSources(panel);

                        if (panel.querySelector('[data-lum-interior-single]')) {
                            return [ensureImageLoaded(sources.single)];
                        }

                        return [
                            ensureImageLoaded(sources.left),
                            ensureImageLoaded(sources.right),
                        ];
                    }));

                    await Promise.all([
                        ...visiblePanels.map((panel) => animatePanel(panel, direction)),
                        animateCounters(direction),
                    ]);
                    preloadAdjacent();
                }
            } catch {
                setStateSync();
            } finally {
                isAnimating = false;
                startProgress();
            }
        };

        prevButtons.forEach((button) => {
            button.addEventListener('click', () => {
                killProgress();
                go('prev');
            });
        });

        nextButtons.forEach((button) => {
            button.addEventListener('click', () => {
                killProgress();
                go('next');
            });
        });

        // Damai: pause progress while hovering controls
        [...prevButtons, ...nextButtons].forEach((button) => {
            button.addEventListener('mouseenter', () => {
                progressTween?.pause();
            });
            button.addEventListener('mouseleave', () => {
                if (autoplayEnabled && progressTween) {
                    progressTween.resume();
                }
            });
        });

        panels.forEach((panel) => {
            panel.querySelectorAll('[data-lum-interior-left], [data-lum-interior-right], [data-lum-interior-single]').forEach((node) => {
                const { host } = resolveSlideSlot(node);
                const img = host?.querySelector('img');

                if (img) {
                    img.dataset.currentSrc = normalizeSrc(img.currentSrc || img.src);
                }
            });
        });

        setStateSync();
        startProgress();

        if (typeof IntersectionObserver === 'function') {
            const observer = new IntersectionObserver((entries) => {
                const visible = entries.some((entry) => entry.isIntersecting);

                autoplayEnabled = visible && ! reducedMotion;

                if (! autoplayEnabled) {
                    killProgress();
                } else if (! isAnimating && ! progressTween) {
                    startProgress();
                }
            }, { threshold: 0.25 });

            observer.observe(root);
        }
    });
}
