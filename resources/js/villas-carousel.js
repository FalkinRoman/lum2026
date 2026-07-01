import gsap from 'gsap';

function padSlideNumber(value) {
    return String(value).padStart(2, '0');
}

function buildSrc(base, name, suffix = '') {
    return `${base}/${name}${suffix}.webp`;
}

function preloadImage(src) {
    const img = new Image();
    img.src = src;
}

function animateOpacity(el, reducedMotion) {
    if (! el) {
        return Promise.resolve();
    }

    if (reducedMotion) {
        gsap.set(el, { opacity: 1, y: 0 });

        return Promise.resolve();
    }

    return new Promise((resolve) => {
        gsap.fromTo(
            el,
            { opacity: 0, y: 12 },
            {
                opacity: 1,
                y: 0,
                duration: 0.55,
                ease: 'power3.out',
                onComplete: resolve,
            },
        );
    });
}

function animateSwapImage(img, nextSrc, reducedMotion) {
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
            scale: 1.04,
            duration: 0.4,
            ease: 'power2.inOut',
            onComplete: () => {
                img.src = nextSrc;
                img.dataset.currentSrc = nextSrc;
                gsap.fromTo(
                    img,
                    { opacity: 0, scale: 1.06 },
                    {
                        opacity: 1,
                        scale: 1,
                        duration: 0.65,
                        ease: 'power3.out',
                        onComplete: resolve,
                    },
                );
            },
        });
    });
}

function initViewCursor(root, getHref) {
    const sliders = root.querySelectorAll('[data-lum-villas-slider-view]');
    const cursor = root.querySelector('[data-lum-villas-view-cursor]');

    if (! cursor || ! sliders.length || ! window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
        return;
    }

    const fixedView = root.querySelector('[data-lum-villas-view-fixed]');

    if (fixedView) {
        fixedView.classList.add('pointer-events-none', 'opacity-0');
    }

    const offsetX = 4;
    const offsetY = -40;
    let activeSlider = null;
    let rafId = null;
    let targetX = 0;
    let targetY = 0;
    let currentX = 0;
    let currentY = 0;

    const renderCursor = () => {
        currentX += (targetX - currentX) * 0.22;
        currentY += (targetY - currentY) * 0.22;

        cursor.style.transform = `translate3d(${currentX}px, ${currentY}px, 0)`;

        if (Math.abs(targetX - currentX) > 0.5 || Math.abs(targetY - currentY) > 0.5) {
            rafId = requestAnimationFrame(renderCursor);
        } else {
            rafId = null;
        }
    };

    const setTarget = (slider, event) => {
        const rect = slider.getBoundingClientRect();

        targetX = event.clientX - rect.left + offsetX;
        targetY = event.clientY - rect.top + offsetY;
    };

    const showCursor = (slider, event) => {
        activeSlider = slider;
        setTarget(slider, event);
        currentX = targetX;
        currentY = targetY;
        cursor.style.transform = `translate3d(${currentX}px, ${currentY}px, 0)`;
        cursor.classList.remove('opacity-0', 'pointer-events-none');
        cursor.classList.add('opacity-100', 'pointer-events-auto');
    };

    const hideCursor = (slider) => {
        if (activeSlider === slider) {
            activeSlider = null;
        }

        cursor.classList.add('opacity-0', 'pointer-events-none');
        cursor.classList.remove('opacity-100', 'pointer-events-auto');
    };

    sliders.forEach((slider) => {
        slider.addEventListener('mouseenter', (event) => showCursor(slider, event));
        slider.addEventListener('mouseleave', () => hideCursor(slider));
        slider.addEventListener('mousemove', (event) => {
            if (activeSlider !== slider) {
                return;
            }

            setTarget(slider, event);

            if (! rafId) {
                rafId = requestAnimationFrame(renderCursor);
            }
        });
    });

    cursor.addEventListener('click', (event) => {
        event.preventDefault();
        window.location.href = getHref();
    });
}

export function initVillasCarousel() {
    document.querySelectorAll('[data-lum-villas-carousel]').forEach((root) => {
        const slides = JSON.parse(root.dataset.slides || '[]');
        const base = root.dataset.imgBase || '';
        const total = slides.length;
        let index = Number.parseInt(root.dataset.start || '0', 10);
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let isAnimating = false;

        const panels = [...root.querySelectorAll('[data-lum-villas-panel]')];
        const prevButtons = root.querySelectorAll('[data-lum-villas-prev]');
        const nextButtons = root.querySelectorAll('[data-lum-villas-next]');

        if (! slides.length || ! panels.length) {
            return;
        }

        const getSources = (panel, slide) => {
            const suffix = panel.dataset.lumVillasSuffix || '';

            return {
                photo: buildSrc(base, slide.photo, suffix),
                oval: buildSrc(base, slide.oval, suffix),
            };
        };

        const syncText = (animate = true) => {
            const slide = slides[index];
            const tasks = [];

            panels.forEach((panel) => {
                const titleNormal = panel.querySelector('[data-lum-villas-title-normal]');
                const titleItalic = panel.querySelector('[data-lum-villas-title-italic]');
                const subtitle = panel.querySelector('[data-lum-villas-subtitle]');
                const subtitleLine2 = panel.querySelector('[data-lum-villas-subtitle-line2]');
                const current = panel.querySelector('[data-lum-villas-current]');
                const textTargets = [titleNormal, titleItalic, subtitle, subtitleLine2].filter(Boolean);

                if (titleNormal) {
                    titleNormal.textContent = panel.dataset.lumVillasSuffix === '-sm'
                        ? (slide.titleMobileNormal ?? slide.titleNormal)
                        : slide.titleNormal;
                }

                if (titleItalic) {
                    titleItalic.textContent = panel.dataset.lumVillasSuffix === '-sm'
                        ? (slide.titleMobileItalic ?? slide.titleItalic)
                        : slide.titleItalic;
                }

                if (subtitle) {
                    if (subtitleLine2 && (slide.subtitleLine1 ?? slide.subtitle)) {
                        subtitle.textContent = slide.subtitleLine1 ?? slide.subtitle;
                        subtitleLine2.textContent = slide.subtitleLine2 ?? '';
                    } else {
                        subtitle.textContent = slide.subtitle ?? slide.subtitleLine1 ?? '';
                    }
                }

                if (current) {
                    current.textContent = padSlideNumber(index + 1);
                }

                if (animate && ! reducedMotion) {
                    textTargets.forEach((target) => {
                        tasks.push(animateOpacity(target, reducedMotion));
                    });
                }
            });

            return Promise.all(tasks);
        };

        const applyState = async (animate = true) => {
            const slide = slides[index];
            const imageTasks = panels.map((panel) => {
                const photo = panel.querySelector('[data-lum-villas-photo]');
                const oval = panel.querySelector('[data-lum-villas-oval]');
                const sources = getSources(panel, slide);

                return Promise.all([
                    animate
                        ? animateSwapImage(photo, sources.photo, reducedMotion)
                        : (photo && (photo.src = sources.photo, photo.dataset.currentSrc = sources.photo, Promise.resolve())),
                    animate
                        ? animateSwapImage(oval, sources.oval, reducedMotion)
                        : (oval && (oval.src = sources.oval, oval.dataset.currentSrc = sources.oval, Promise.resolve())),
                ]);
            });

            const nextSlide = slides[(index + 1) % total];
            const prevSlide = slides[(index - 1 + total) % total];

            preloadImage(buildSrc(base, nextSlide.photo, ''));
            preloadImage(buildSrc(base, prevSlide.photo, ''));
            preloadImage(buildSrc(base, slide.oval, ''));

            if (animate && ! reducedMotion) {
                panels.forEach((panel) => {
                    panel.querySelectorAll('[data-lum-villas-title-normal], [data-lum-villas-title-italic], [data-lum-villas-subtitle], [data-lum-villas-subtitle-line2]').forEach((el) => {
                        gsap.to(el, { opacity: 0, y: -10, duration: 0.25, ease: 'power2.inOut' });
                    });
                });

                await Promise.all(imageTasks);
                await syncText(true);
            } else {
                await Promise.all(imageTasks);
                syncText(false);
            }
        };

        const state = { index };

        state.index = index;

        const getCurrentHref = () => slides[state.index]?.href || '#';

        const navigateToCurrent = () => {
            const href = getCurrentHref();

            if (href && href !== '#') {
                window.location.href = href;
            }
        };

        const syncViewLinks = () => {
            const href = getCurrentHref();
            root.querySelector('[data-lum-villas-view-fixed]')?.setAttribute('href', href);
        };

        initViewCursor(root, getCurrentHref);

        panels.forEach((panel) => {
            const slider = panel.querySelector('[data-lum-villas-slider]');

            if (slider) {
                slider.addEventListener('click', (event) => {
                    if (event.target.closest('[data-lum-villas-prev], [data-lum-villas-next], [data-lum-villas-view-cursor]')) {
                        return;
                    }

                    navigateToCurrent();
                });
            }

            panel.querySelectorAll('[data-lum-villas-oval-hit]').forEach((target) => {
                target.addEventListener('click', navigateToCurrent);
            });
        });

        root.querySelector('[data-lum-villas-view-fixed]')?.addEventListener('click', (event) => {
            event.preventDefault();
            navigateToCurrent();
        });

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

            state.index = index;
            await applyState(true);
            syncViewLinks();
            isAnimating = false;
        };

        prevButtons.forEach((button) => {
            button.addEventListener('click', () => go('prev'));
        });

        nextButtons.forEach((button) => {
            button.addEventListener('click', () => go('next'));
        });

        panels.forEach((panel) => {
            panel.querySelectorAll('[data-lum-villas-photo], [data-lum-villas-oval]').forEach((img) => {
                gsap.set(img, { opacity: 1, scale: 1, transformOrigin: 'center center' });
            });
        });

        applyState(false);
        syncViewLinks();
    });
}
