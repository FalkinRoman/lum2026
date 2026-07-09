import gsap from 'gsap';

function padSlideNumber(value) {
    return String(value).padStart(2, '0');
}

function buildSrc(base, name, suffix = '') {
    return `${base}/${name}${suffix}.webp`;
}

const imageLoadCache = new Map();

function preloadImage(src) {
    if (! src) {
        return Promise.resolve();
    }

    if (imageLoadCache.has(src)) {
        return imageLoadCache.get(src);
    }

    const promise = new Promise((resolve) => {
        const img = new Image();

        const finish = () => resolve();

        img.onload = finish;
        img.onerror = finish;
        img.decoding = 'async';
        img.src = src;

        if (img.complete) {
            finish();
        }
    });

    imageLoadCache.set(src, promise);

    return promise;
}

function preloadSlideAssets(slides, base, suffix = '') {
    return Promise.all(slides.flatMap((slide) => [
        preloadImage(buildSrc(base, slide.photo, suffix)),
        preloadImage(buildSrc(base, slide.oval, suffix)),
    ]));
}

function getMultilineTextWidth(track, inner) {
    const datasetWidth = Number.parseInt(track?.dataset.lumVillasTextWidth || '', 10);

    if (datasetWidth > 0) {
        return datasetWidth;
    }

    const content = inner.firstElementChild ?? inner;
    const measured = content.getBoundingClientRect().width;

    if (measured > 0) {
        return Math.round(measured);
    }

    return track?.getBoundingClientRect().width || inner.offsetWidth || 0;
}

function applyMultilineTextWidth(nodes, width) {
    if (! width) {
        return;
    }

    const widthPx = `${width}px`;

    nodes.forEach((node) => {
        node.style.width = widthPx;
        node.style.maxWidth = widthPx;
    });
}

const POSITION_CLASS_PREFIXES = ['absolute', 'left-', 'right-', 'top-', 'bottom-', '-translate', 'translate-', 'w-['];

function isPositionClass(className) {
    return POSITION_CLASS_PREFIXES.some((prefix) => className.startsWith(prefix));
}

const MEDIA_SLIDE = 'lum-villas-slide absolute inset-0 overflow-hidden';
const MEDIA_INNER = 'lum-villas-slide__inner absolute inset-0 h-full w-full';
const TEXT_SLIDE = 'lum-villas-slide relative w-full overflow-hidden';
const TEXT_INNER = 'lum-villas-slide__inner relative flex w-full items-center justify-center';
const TEXT_OVERLAY = 'lum-villas-slide__inner absolute inset-0 flex w-full items-center justify-center';

function normalizeTextTrackPosition(positionClasses) {
    return positionClasses
        .filter((className) => ! ['left-1/2', '-translate-x-1/2', 'translate-x-1/2'].includes(className))
        .concat(['left-0', 'w-full']);
}

function wrapTextTrack(element) {
    const existingTrack = element.closest('[data-lum-villas-text-track]');

    if (existingTrack) {
        const slide = existingTrack.querySelector('[data-lum-villas-slide]');
        const inner = existingTrack.querySelector('[data-lum-villas-slide-inner]');

        slide.className = TEXT_SLIDE;
        inner.className = TEXT_INNER;

        return { track: existingTrack, slide, inner, content: element };
    }

    const track = document.createElement('div');
    track.dataset.lumVillasTextTrack = '';
    const positionClasses = normalizeTextTrackPosition([...element.classList].filter(isPositionClass));
    const contentClasses = [...element.classList].filter((className) => ! isPositionClass(className));

    track.className = [...positionClasses, 'overflow-hidden'].join(' ');
    element.className = contentClasses.join(' ');

    if (element.matches('[data-lum-villas-subtitle], [data-lum-villas-subtitle-line2]') || element.querySelector('[data-lum-villas-subtitle-line2]')) {
        const widthMatch = [...element.classList].find((className) => /^w-\[\d+px\]$/.test(className));

        if (widthMatch) {
            track.dataset.lumVillasTextWidth = widthMatch.match(/\d+/)?.[0] ?? '';
        }
    }

    const slide = document.createElement('div');
    slide.className = TEXT_SLIDE;
    slide.dataset.lumVillasSlide = '';

    const inner = document.createElement('div');
    inner.className = TEXT_INNER;
    inner.dataset.lumVillasSlideInner = '';

    element.parentNode.insertBefore(track, element);
    inner.appendChild(element);
    slide.appendChild(inner);
    track.appendChild(slide);

    return { track, slide, inner, content: element };
}

function setupPhotoTrack(slider) {
    const photo = slider.querySelector('[data-lum-villas-photo]');

    if (! photo) {
        return null;
    }

    let track = slider.querySelector('[data-lum-villas-photo-track]');

    if (! track) {
        track = document.createElement('div');
        track.dataset.lumVillasPhotoTrack = '';
        track.className = 'absolute inset-0 overflow-hidden';

        const slide = document.createElement('div');
        slide.className = MEDIA_SLIDE;
        slide.dataset.lumVillasSlide = '';

        const inner = document.createElement('div');
        inner.className = MEDIA_INNER;
        inner.dataset.lumVillasSlideInner = '';

        photo.classList.add('h-full', 'w-full', 'object-cover');
        slider.insertBefore(track, photo);
        inner.appendChild(photo);
        slide.appendChild(inner);
        track.appendChild(slide);
    }

    return {
        type: 'photo',
        slide: track.querySelector('[data-lum-villas-slide]'),
        inner: track.querySelector('[data-lum-villas-slide-inner]'),
    };
}

function setupOvalTrack(ovalHit) {
    const oval = ovalHit.querySelector('[data-lum-villas-oval]');

    if (! oval) {
        return null;
    }

    if (! ovalHit.querySelector('[data-lum-villas-slide]')) {
        const slide = document.createElement('div');
        slide.className = MEDIA_SLIDE;
        slide.dataset.lumVillasSlide = '';

        const inner = document.createElement('div');
        inner.className = MEDIA_INNER;
        inner.dataset.lumVillasSlideInner = '';

        oval.classList.add('h-full', 'w-full', 'object-cover');
        ovalHit.appendChild(slide);
        inner.appendChild(oval);
        slide.appendChild(inner);
    }

    return {
        type: 'oval',
        slide: ovalHit.querySelector('[data-lum-villas-slide]'),
        inner: ovalHit.querySelector('[data-lum-villas-slide-inner]'),
    };
}

function fillPhoto(inner, slideData, base, suffix) {
    let img = inner.querySelector('img');

    if (! img) {
        img = document.createElement('img');
        img.className = 'h-full w-full object-cover';
        img.alt = '';
        inner.appendChild(img);
    }

    img.src = buildSrc(base, slideData.photo, suffix);
}

function fillOval(inner, slideData, base, suffix) {
    let img = inner.querySelector('[data-lum-villas-oval], img');

    if (! img) {
        img = document.createElement('img');
        img.dataset.lumVillasOval = '';
        img.className = 'h-full w-full object-cover';
        img.alt = '';
        inner.appendChild(img);
    }

    img.src = buildSrc(base, slideData.oval, suffix);
}

function fillTitle(content, slideData, suffix) {
    const normal = content.querySelector('[data-lum-villas-title-normal]');
    const italic = content.querySelector('[data-lum-villas-title-italic]');

    if (normal) {
        normal.textContent = suffix === '-sm'
            ? (slideData.titleMobileNormal ?? slideData.titleNormal)
            : slideData.titleNormal;
    }

    if (italic) {
        italic.textContent = suffix === '-sm'
            ? (slideData.titleMobileItalic ?? slideData.titleItalic)
            : slideData.titleItalic;
    }
}

function fillSubtitle(content, slideData) {
    const line1 = content.matches('[data-lum-villas-subtitle]')
        ? content
        : content.querySelector('[data-lum-villas-subtitle]');
    const line2 = content.querySelector('[data-lum-villas-subtitle-line2]');

    if (! line1) {
        return;
    }

    if (line2) {
        line1.textContent = slideData.subtitleLine1 ?? slideData.subtitle ?? '';
        line2.textContent = slideData.subtitleLine2 ?? '';
    } else {
        line1.textContent = slideData.subtitle
            ?? [slideData.subtitleLine1, slideData.subtitleLine2].filter(Boolean).join(' ');
    }
}

function cloneTrackContent(inner) {
    const content = inner.firstElementChild ?? inner;

    return content.cloneNode(true);
}

function animateOvalSlide({ slide, inner, direction, slideData, fill, reducedMotion, duration = 0.95, preload }) {
    const dir = direction === 'next' ? 1 : -1;

    if (reducedMotion) {
        fill(slideData, inner);

        return Promise.resolve();
    }

    const run = async () => {
        if (preload) {
            await preload(slideData);
        }

        const outgoing = document.createElement('div');
        outgoing.className = `${MEDIA_INNER} absolute inset-0 z-[2]`;
        outgoing.appendChild(cloneTrackContent(inner));

        const incoming = document.createElement('div');
        incoming.className = `${MEDIA_INNER} absolute inset-0 z-[1]`;
        fill(slideData, incoming);

        gsap.set(outgoing, { xPercent: 0 });
        gsap.set(incoming, { xPercent: dir * 100 });

        slide.appendChild(outgoing);
        slide.appendChild(incoming);
        inner.style.visibility = 'hidden';

        return new Promise((resolve) => {
            gsap.timeline({
                defaults: { duration, ease: 'power4.out' },
                onComplete: () => {
                    fill(slideData, inner);
                    inner.style.visibility = '';
                    outgoing.remove();
                    incoming.remove();
                    gsap.set([inner, outgoing, incoming], { clearProps: 'transform,x,xPercent,scale' });
                    resolve();
                },
            })
                .to(outgoing, { xPercent: -dir * 100 }, 0)
                .to(incoming, { xPercent: 0 }, 0);
        });
    };

    return run();
}

function createTextLayer(content, zIndex, { fullWidth = false } = {}) {
    const layer = document.createElement('div');
    layer.className = TEXT_OVERLAY;
    layer.style.zIndex = String(zIndex);

    const lane = document.createElement('div');
    lane.className = fullWidth
        ? 'lum-villas-slide__lane w-full'
        : 'lum-villas-slide__lane w-max max-w-full';
    lane.appendChild(content);
    layer.appendChild(lane);

    return { layer, lane };
}

function fillMobileSubtitle(content, slideData) {
    const lines = content.querySelectorAll('p');

    if (lines[0]) {
        lines[0].textContent = slideData.subtitleLine1 ?? slideData.subtitle ?? '';
    }

    if (lines[1]) {
        lines[1].textContent = slideData.subtitleLine2 ?? '';
    }
}

function cloneMobileSubtitleBlock(content) {
    const block = document.createElement('div');
    block.className = 'w-full text-center';
    block.innerHTML = content.innerHTML;

    return block;
}

function animateMobileSubtitle({ root, stage, content, direction, slideData, fill, reducedMotion, duration = 0.72 }) {
    const dir = direction === 'next' ? 1 : -1;

    if (reducedMotion) {
        fill(slideData, content);

        return Promise.resolve();
    }

    const travel = (root?.offsetWidth || stage.offsetWidth) * 1.05;

    stage.style.height = `${stage.offsetHeight}px`;
    stage.style.overflow = 'hidden';

    const outgoingContent = cloneMobileSubtitleBlock(content);
    const incomingContent = cloneMobileSubtitleBlock(content);
    fill(slideData, incomingContent);

    const outgoing = createTextLayer(outgoingContent, 2, { fullWidth: true });
    const incoming = createTextLayer(incomingContent, 1, { fullWidth: true });

    outgoing.layer.className = `${TEXT_OVERLAY} absolute inset-0 z-[2] overflow-hidden`;
    incoming.layer.className = `${TEXT_OVERLAY} absolute inset-0 z-[1] overflow-hidden`;

    gsap.set(outgoing.lane, { x: 0 });
    gsap.set(incoming.lane, { x: dir * travel });

    content.style.opacity = '0';
    stage.appendChild(outgoing.layer);
    stage.appendChild(incoming.layer);

    return new Promise((resolve) => {
        gsap.timeline({
            defaults: { duration, ease: 'power3.out' },
            onComplete: () => {
                fill(slideData, content);
                content.style.opacity = '';
                stage.style.height = '';
                stage.style.overflow = '';
                outgoing.layer.remove();
                incoming.layer.remove();
                gsap.set([outgoing.lane, incoming.lane], { clearProps: 'transform,x,xPercent' });
                resolve();
            },
        })
            .to(outgoing.lane, { x: -dir * travel }, 0)
            .to(incoming.lane, { x: 0 }, 0);
    });
}

function setupMobileSubtitle(panel) {
    const root = panel.querySelector('[data-lum-villas-mobile-subtitle]');

    if (! root) {
        return null;
    }

    const stage = root.querySelector('[data-lum-villas-mobile-subtitle-stage]');
    const content = root.querySelector('[data-lum-villas-mobile-subtitle-content]');

    if (! stage || ! content) {
        return null;
    }

    return {
        type: 'mobileSubtitle',
        root,
        stage,
        content,
        fill: (slideData, target = content) => fillMobileSubtitle(target, slideData),
    };
}

function createMultilineTextBlock(inner, slideData, fill, track, { fillIncoming = false } = {}) {
    const textWidth = getMultilineTextWidth(track, inner);
    const content = cloneTrackContent(inner);

    if (fillIncoming) {
        fill(slideData, content);
    }

    applyMultilineTextWidth([content], textWidth);

    return { content, textWidth };
}

function animateMultilineTextSlide({ slide, inner, direction, slideData, fill, reducedMotion, duration = 0.72 }) {
    const dir = direction === 'next' ? 1 : -1;

    if (reducedMotion) {
        fill(slideData, inner);

        return Promise.resolve();
    }

    const track = slide.closest('[data-lum-villas-text-track]');
    const { content: outgoingContent, textWidth } = createMultilineTextBlock(inner, slideData, fill, track);
    const { content: incomingContent } = createMultilineTextBlock(inner, slideData, fill, track, { fillIncoming: true });

    slide.style.height = `${slide.offsetHeight}px`;

    if (textWidth) {
        slide.style.width = `${textWidth}px`;
        slide.style.marginLeft = 'auto';
        slide.style.marginRight = 'auto';
    }

    slide.style.overflow = 'hidden';

    const outgoing = document.createElement('div');
    outgoing.className = 'absolute inset-0 z-[2] flex items-center justify-center';
    outgoing.appendChild(outgoingContent);

    const incoming = document.createElement('div');
    incoming.className = 'absolute inset-0 z-[1] flex items-center justify-center';
    incoming.appendChild(incomingContent);

    gsap.set(outgoing, { xPercent: 0 });
    gsap.set(incoming, { xPercent: dir * 100 });

    slide.appendChild(outgoing);
    slide.appendChild(incoming);
    inner.style.visibility = 'hidden';

    return new Promise((resolve) => {
        gsap.timeline({
            defaults: { duration, ease: 'power3.out' },
            onComplete: () => {
                fill(slideData, inner);
                if (textWidth) {
                    applyMultilineTextWidth([inner.firstElementChild ?? inner], textWidth);
                }
                inner.style.visibility = '';
                slide.style.height = '';
                slide.style.width = '';
                slide.style.marginLeft = '';
                slide.style.marginRight = '';
                slide.style.overflow = '';
                outgoing.remove();
                incoming.remove();
                gsap.set([outgoing, incoming], { clearProps: 'transform,x,xPercent' });
                resolve();
            },
        })
            .to(outgoing, { xPercent: -dir * 100 }, 0)
            .to(incoming, { xPercent: 0 }, 0);
    });
}

function animateTextSlide({ slide, inner, direction, slideData, fill, reducedMotion, duration = 0.72 }) {
    const dir = direction === 'next' ? 1 : -1;

    if (reducedMotion) {
        fill(slideData, inner);

        return Promise.resolve();
    }

    const track = slide.closest('[data-lum-villas-text-track]');
    const travel = (track?.offsetWidth ?? slide.offsetWidth) * 1.05;

    slide.style.height = `${slide.offsetHeight}px`;

    const outgoingContent = cloneTrackContent(inner);
    const incomingContent = cloneTrackContent(inner);
    fill(slideData, incomingContent);

    const outgoing = createTextLayer(outgoingContent, 2);
    const incoming = createTextLayer(incomingContent, 1);

    outgoing.layer.classList.add('overflow-hidden');
    incoming.layer.classList.add('overflow-hidden');

    gsap.set(outgoing.lane, { x: 0 });
    gsap.set(incoming.lane, { x: dir * travel });

    slide.appendChild(outgoing.layer);
    slide.appendChild(incoming.layer);
    inner.style.visibility = 'hidden';

    return new Promise((resolve) => {
        gsap.timeline({
            defaults: { duration, ease: 'power3.out' },
            onComplete: () => {
                fill(slideData, inner);
                inner.style.visibility = '';
                slide.style.height = '';
                outgoing.layer.remove();
                incoming.layer.remove();
                gsap.set([outgoing.lane, incoming.lane], { clearProps: 'transform,x,xPercent' });
                resolve();
            },
        })
            .to(outgoing.lane, { x: -dir * travel }, 0)
            .to(incoming.lane, { x: 0 }, 0);
    });
}
function animatePhotoBreath({ slide, inner, slideData, fill, reducedMotion, duration = 1.15, preload }) {
    if (reducedMotion) {
        fill(slideData, inner);

        return Promise.resolve();
    }

    const run = async () => {
        if (preload) {
            await preload(slideData);
        }

        const incoming = document.createElement('div');
        incoming.className = `${MEDIA_INNER} absolute inset-0 z-[2]`;
        fill(slideData, incoming);
        slide.appendChild(incoming);

        const currentImg = inner.querySelector('img');
        const nextImg = incoming.querySelector('img');

        gsap.set(nextImg, { opacity: 0, scale: 1.06 });
        gsap.set(currentImg, { opacity: 1, scale: 1 });

        return new Promise((resolve) => {
            gsap.timeline({
                defaults: { ease: 'power2.out' },
                onComplete: () => {
                    fill(slideData, inner);
                    incoming.remove();
                    gsap.set(currentImg, { clearProps: 'opacity,transform,scale' });
                    resolve();
                },
            })
                .to(currentImg, { opacity: 0, duration: duration * 0.55, ease: 'power2.in' }, 0)
                .to(nextImg, { opacity: 1, scale: 1, duration, ease: 'power2.out' }, 0);
        });
    };

    return run();
}

function isPanelVisible(panel) {
    return panel.getClientRects().length > 0;
}

function resetTrackState(track, slideData) {
    if (track.type === 'mobileSubtitle') {
        track.fill(slideData, track.content);
        track.content.style.opacity = '';
        track.stage.style.height = '';

        return;
    }

    const { slide, inner, fill } = track;

    fill(slideData, inner);
    slide.style.visibility = '';
    inner.style.visibility = '';
    slide.style.height = '';
}

function animateTrack(track, direction, slideData, reducedMotion) {
    const { type, slide, inner, fill, multiline } = track;

    switch (type) {
        case 'photo':
            return animatePhotoBreath({ slide, inner, slideData, fill, reducedMotion, preload: track.preload });
        case 'oval':
            return animateOvalSlide({ slide, inner, direction, slideData, fill, reducedMotion, preload: track.preload });
        case 'title':
            return animateTextSlide({ slide, inner, direction, slideData, fill, reducedMotion });
        case 'mobileSubtitle':
            return animateMobileSubtitle({
                root: track.root,
                stage: track.stage,
                content: track.content,
                direction,
                slideData,
                fill: track.fill,
                reducedMotion,
            });
        case 'subtitle':
            if (multiline) {
                return animateMultilineTextSlide({
                    slide,
                    inner,
                    direction,
                    slideData,
                    fill,
                    reducedMotion,
                });
            }

            return animateTextSlide({
                slide,
                inner,
                direction,
                slideData,
                fill,
                reducedMotion,
            });
        default:
            return Promise.resolve();
    }
}

function setupPanelTracks(panel, base) {
    const suffix = panel.dataset.lumVillasSuffix || '';
    const tracks = [];
    const slider = panel.querySelector('[data-lum-villas-slider]');
    const photoTrack = slider ? setupPhotoTrack(slider) : null;

    if (photoTrack) {
        tracks.push({
            ...photoTrack,
            fill: (slideData, inner) => fillPhoto(inner, slideData, base, suffix),
            preload: (slideData) => preloadImage(buildSrc(base, slideData.photo, suffix)),
        });
    }

    const ovalHit = panel.querySelector('[data-lum-villas-oval-hit]');
    const ovalTrack = ovalHit ? setupOvalTrack(ovalHit) : null;

    if (ovalTrack) {
        tracks.push({
            ...ovalTrack,
            fill: (slideData, inner) => fillOval(inner, slideData, base, suffix),
            preload: (slideData) => preloadImage(buildSrc(base, slideData.oval, suffix)),
        });
    }

    const title = panel.querySelector('[data-lum-villas-title-normal]')?.closest('h2');

    if (title) {
        const wrapped = wrapTextTrack(title);
        tracks.push({
            type: 'title',
            slide: wrapped.slide,
            inner: wrapped.inner,
            fill: (slideData, inner) => fillTitle(inner.querySelector('h2') ?? inner, slideData, suffix),
        });
    }

    const mobileSubtitle = setupMobileSubtitle(panel);

    if (mobileSubtitle) {
        tracks.push(mobileSubtitle);
    } else {
        const subtitleLine1 = panel.querySelector('[data-lum-villas-subtitle]');

        if (subtitleLine1) {
            const subtitleTarget = subtitleLine1.parentElement?.querySelector('[data-lum-villas-subtitle-line2]')
                ? subtitleLine1.parentElement
                : subtitleLine1;
            const wrapped = wrapTextTrack(subtitleTarget);
            const multiline = Boolean(subtitleTarget.querySelector('[data-lum-villas-subtitle-line2]'));

            tracks.push({
                type: 'subtitle',
                multiline,
                slide: wrapped.slide,
                inner: wrapped.inner,
                fill: (slideData, inner) => fillSubtitle(inner.firstElementChild ?? inner, slideData),
            });
        }
    }

    return tracks;
}

function syncCounter(panels, slides, index, base) {
    panels.forEach((panel) => {
        const current = panel.querySelector('[data-lum-villas-current]');

        if (current) {
            current.textContent = padSlideNumber(index + 1);
        }

        const suffix = panel.dataset.lumVillasSuffix || '';
        preloadImage(buildSrc(base, slides[(index + 1) % slides.length].photo, suffix));
        preloadImage(buildSrc(base, slides[(index - 1 + slides.length) % slides.length].photo, suffix));
        preloadImage(buildSrc(base, slides[(index + 1) % slides.length].oval, suffix));
        preloadImage(buildSrc(base, slides[(index - 1 + slides.length) % slides.length].oval, suffix));
        preloadImage(buildSrc(base, slides[index].photo, suffix));
        preloadImage(buildSrc(base, slides[index].oval, suffix));
    });
}

function initViewCursor(root) {
    const sliders = root.querySelectorAll('[data-lum-villas-slider-view]');
    const cursor = root.querySelector('[data-lum-villas-view-cursor]');
    const fixedView = root.querySelector('[data-lum-villas-view-fixed]');

    if (! cursor || ! sliders.length || ! window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
        return;
    }

    if (fixedView) {
        fixedView.classList.add('pointer-events-none', 'opacity-0');
    }

    cursor.classList.remove('opacity-0');

    const offsetX = 4;
    const offsetY = -40;
    let activeSlider = null;
    let rafId = null;
    let targetX = 0;
    let targetY = 0;
    let currentX = 0;
    let currentY = 0;
    let isVisible = false;

    gsap.set(cursor, {
        xPercent: -50,
        yPercent: -50,
        transformOrigin: '50% 50%',
        autoAlpha: 0,
        scale: 0.12,
    });

    const renderCursor = () => {
        currentX += (targetX - currentX) * 0.22;
        currentY += (targetY - currentY) * 0.22;

        gsap.set(cursor, { x: currentX, y: currentY });

        if (isVisible && (Math.abs(targetX - currentX) > 0.5 || Math.abs(targetY - currentY) > 0.5)) {
            rafId = requestAnimationFrame(renderCursor);
        } else {
            rafId = null;
        }
    };

    const setTarget = (slider, event) => {
        const rect = slider.getBoundingClientRect();

        targetX = event.clientX - rect.left + offsetX;
        targetY = event.clientY - rect.top + offsetY;

        if (! rafId) {
            rafId = requestAnimationFrame(renderCursor);
        }
    };

    const showCursor = (slider, event) => {
        activeSlider = slider;
        isVisible = true;

        const rect = slider.getBoundingClientRect();
        targetX = event.clientX - rect.left + offsetX;
        targetY = event.clientY - rect.top + offsetY;
        currentX = targetX;
        currentY = targetY;

        gsap.set(cursor, { x: currentX, y: currentY });

        gsap.killTweensOf(cursor);
        gsap.fromTo(cursor, {
            autoAlpha: 0,
            scale: 0.12,
        }, {
            autoAlpha: 1,
            scale: 1,
            duration: 0.5,
            ease: 'power3.out',
            overwrite: true,
        });

        if (! rafId) {
            rafId = requestAnimationFrame(renderCursor);
        }
    };

    const hideCursor = (slider) => {
        if (activeSlider !== slider) {
            return;
        }

        activeSlider = null;
        isVisible = false;

        if (rafId) {
            cancelAnimationFrame(rafId);
            rafId = null;
        }

        gsap.killTweensOf(cursor);
        gsap.to(cursor, {
            autoAlpha: 0,
            scale: 0.12,
            duration: 0.25,
            ease: 'power2.in',
        });
    };

    sliders.forEach((slider) => {
        slider.addEventListener('mouseenter', (event) => showCursor(slider, event));
        slider.addEventListener('mouseleave', () => hideCursor(slider));
        slider.addEventListener('mousemove', (event) => {
            if (activeSlider !== slider) {
                return;
            }

            setTarget(slider, event);
        });
    });
}

function syncViewLinks(root, slides, index) {
    const href = slides[index]?.href || '#';
    root.querySelector('[data-lum-villas-view-fixed]')?.setAttribute('href', href);
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

        const panelTracks = panels.map((panel) => setupPanelTracks(panel, base));

        const applyState = (targetIndex) => {
            const slideData = slides[targetIndex];

            panelTracks.forEach((tracks) => {
                tracks.forEach((track) => resetTrackState(track, slideData));
            });

            syncCounter(panels, slides, targetIndex, base);
        };

        const go = async (direction) => {
            if (isAnimating) {
                return;
            }

            isAnimating = true;

            const nextIndex = direction === 'next'
                ? (index + 1) % total
                : (index - 1 + total) % total;
            const slideData = slides[nextIndex];

            index = nextIndex;
            syncCounter(panels, slides, index, base);
            syncViewLinks(root, slides, index);

            const animationTasks = [];
            const staticUpdates = [];

            panelTracks.forEach((tracks, panelIndex) => {
                if (isPanelVisible(panels[panelIndex])) {
                    tracks.forEach((track) => {
                        animationTasks.push(animateTrack(track, direction, slideData, reducedMotion));
                    });

                    return;
                }

                tracks.forEach((track) => {
                    staticUpdates.push(() => resetTrackState(track, slideData));
                });
            });

            await Promise.all(animationTasks);
            staticUpdates.forEach((update) => update());

            isAnimating = false;
        };

        prevButtons.forEach((button) => {
            button.addEventListener('click', () => go('prev'));
        });

        nextButtons.forEach((button) => {
            button.addEventListener('click', () => go('next'));
        });

        applyState(index);
        syncViewLinks(root, slides, index);
        initViewCursor(root);

        panels.forEach((panel) => {
            if (! isPanelVisible(panel)) {
                return;
            }

            preloadSlideAssets(slides, base, panel.dataset.lumVillasSuffix || '');
        });
    });
}
