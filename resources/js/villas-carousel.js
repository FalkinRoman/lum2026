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

/** Damai dining — slide xPercent + inner parallax 12.5%, speed 1200 */
const MEDIA_DURATION = 1.2;
const MEDIA_EASE = 'power2.inOut';
const MEDIA_PARALLAX = 12.5;

function animateDamaiMedia({ slide, inner, direction, slideData, fill, reducedMotion, duration = MEDIA_DURATION, preload }) {
    const dir = direction === 'next' ? 1 : -1;

    if (reducedMotion) {
        fill(slideData, inner);

        return Promise.resolve();
    }

    const run = async () => {
        if (preload) {
            await preload(slideData);
        }

        const outgoingSlide = document.createElement('div');
        outgoingSlide.className = 'lum-villas-slide absolute inset-0 z-[2] overflow-hidden';
        const outgoingInner = document.createElement('div');
        outgoingInner.className = `${MEDIA_INNER} will-change-transform`;
        outgoingInner.appendChild(cloneTrackContent(inner));
        outgoingSlide.appendChild(outgoingInner);

        const incomingSlide = document.createElement('div');
        incomingSlide.className = 'lum-villas-slide absolute inset-0 z-[1] overflow-hidden';
        const incomingInner = document.createElement('div');
        incomingInner.className = `${MEDIA_INNER} will-change-transform`;
        fill(slideData, incomingInner);
        incomingSlide.appendChild(incomingInner);

        gsap.set(outgoingSlide, { xPercent: 0 });
        gsap.set(outgoingInner, { xPercent: 0 });
        gsap.set(incomingSlide, { xPercent: dir * 100 });
        gsap.set(incomingInner, { xPercent: -dir * MEDIA_PARALLAX });

        slide.appendChild(outgoingSlide);
        slide.appendChild(incomingSlide);
        inner.style.visibility = 'hidden';

        return new Promise((resolve) => {
            gsap.timeline({
                defaults: { duration, ease: MEDIA_EASE },
                onComplete: () => {
                    fill(slideData, inner);
                    inner.style.visibility = '';
                    outgoingSlide.remove();
                    incomingSlide.remove();
                    gsap.set([outgoingSlide, outgoingInner, incomingSlide, incomingInner], {
                        clearProps: 'transform,x,xPercent',
                    });
                    resolve();
                },
            })
                .to(outgoingSlide, { xPercent: -dir * 100 }, 0)
                .to(outgoingInner, { xPercent: dir * MEDIA_PARALLAX }, 0)
                .to(incomingSlide, { xPercent: 0 }, 0)
                .to(incomingInner, { xPercent: 0 }, 0);
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

const TEXT_EASE = 'power2.inOut';
const TEXT_DURATION = 1.2;
const TEXT_TRAVEL_RATIO = 0.5;
const SUBTITLE_STAGGER = 0.1;

function animateMobileSubtitle({
    root,
    stage,
    content,
    direction,
    slideData,
    fill,
    reducedMotion,
    duration = TEXT_DURATION,
    delay = 0,
}) {
    const dir = direction === 'next' ? 1 : -1;

    if (reducedMotion) {
        fill(slideData, content);

        return Promise.resolve();
    }

    const travel = (root?.offsetWidth || stage.offsetWidth) * TEXT_TRAVEL_RATIO;

    stage.style.height = `${stage.offsetHeight}px`;
    stage.style.overflow = 'hidden';

    const outgoingContent = cloneMobileSubtitleBlock(content);
    const incomingContent = cloneMobileSubtitleBlock(content);
    fill(slideData, incomingContent);

    const outgoing = createTextLayer(outgoingContent, 2, { fullWidth: true });
    const incoming = createTextLayer(incomingContent, 1, { fullWidth: true });

    outgoing.layer.className = `${TEXT_OVERLAY} absolute inset-0 z-[2] overflow-hidden`;
    incoming.layer.className = `${TEXT_OVERLAY} absolute inset-0 z-[1] overflow-hidden`;

    gsap.set(outgoing.lane, { x: 0, opacity: 1 });
    gsap.set(incoming.lane, { x: dir * travel, opacity: 0 });

    content.style.opacity = '0';
    stage.appendChild(outgoing.layer);
    stage.appendChild(incoming.layer);

    return new Promise((resolve) => {
        gsap.timeline({
            delay,
            defaults: { duration, ease: TEXT_EASE },
            onComplete: () => {
                fill(slideData, content);
                content.style.opacity = '';
                stage.style.height = '';
                stage.style.overflow = '';
                outgoing.layer.remove();
                incoming.layer.remove();
                gsap.set([outgoing.lane, incoming.lane], { clearProps: 'transform,x,xPercent,opacity' });
                resolve();
            },
        })
            .to(outgoing.lane, { x: -dir * travel, opacity: 0 }, 0)
            .to(incoming.lane, { x: 0, opacity: 1 }, 0);
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

function animateMultilineTextSlide({
    slide,
    inner,
    direction,
    slideData,
    fill,
    reducedMotion,
    duration = TEXT_DURATION,
    delay = 0,
}) {
    const dir = direction === 'next' ? 1 : -1;
    const travelPercent = TEXT_TRAVEL_RATIO * 100;

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

    gsap.set(outgoing, { xPercent: 0, opacity: 1 });
    gsap.set(incoming, { xPercent: dir * travelPercent, opacity: 0 });

    slide.appendChild(outgoing);
    slide.appendChild(incoming);
    inner.style.visibility = 'hidden';

    return new Promise((resolve) => {
        gsap.timeline({
            delay,
            defaults: { duration, ease: TEXT_EASE },
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
                gsap.set([outgoing, incoming], { clearProps: 'transform,x,xPercent,opacity' });
                resolve();
            },
        })
            .to(outgoing, { xPercent: -dir * travelPercent, opacity: 0 }, 0)
            .to(incoming, { xPercent: 0, opacity: 1 }, 0);
    });
}

function animateTextSlide({
    slide,
    inner,
    direction,
    slideData,
    fill,
    reducedMotion,
    duration = TEXT_DURATION,
    delay = 0,
}) {
    const dir = direction === 'next' ? 1 : -1;

    if (reducedMotion) {
        fill(slideData, inner);

        return Promise.resolve();
    }

    const track = slide.closest('[data-lum-villas-text-track]');
    const travel = (track?.offsetWidth ?? slide.offsetWidth) * TEXT_TRAVEL_RATIO;

    slide.style.height = `${slide.offsetHeight}px`;

    const outgoingContent = cloneTrackContent(inner);
    const incomingContent = cloneTrackContent(inner);
    fill(slideData, incomingContent);

    const outgoing = createTextLayer(outgoingContent, 2);
    const incoming = createTextLayer(incomingContent, 1);

    outgoing.layer.classList.add('overflow-hidden');
    incoming.layer.classList.add('overflow-hidden');

    gsap.set(outgoing.lane, { x: 0, opacity: 1 });
    gsap.set(incoming.lane, { x: dir * travel, opacity: 0 });

    slide.appendChild(outgoing.layer);
    slide.appendChild(incoming.layer);
    inner.style.visibility = 'hidden';

    return new Promise((resolve) => {
        gsap.timeline({
            delay,
            defaults: { duration, ease: TEXT_EASE },
            onComplete: () => {
                fill(slideData, inner);
                inner.style.visibility = '';
                slide.style.height = '';
                outgoing.layer.remove();
                incoming.layer.remove();
                gsap.set([outgoing.lane, incoming.lane], { clearProps: 'transform,x,xPercent,opacity' });
                resolve();
            },
        })
            .to(outgoing.lane, { x: -dir * travel, opacity: 0 }, 0)
            .to(incoming.lane, { x: 0, opacity: 1 }, 0);
    });
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
        case 'oval':
            return animateDamaiMedia({ slide, inner, direction, slideData, fill, reducedMotion, preload: track.preload });
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
                delay: SUBTITLE_STAGGER,
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
                    delay: SUBTITLE_STAGGER,
                });
            }

            return animateTextSlide({
                slide,
                inner,
                direction,
                slideData,
                fill,
                reducedMotion,
                delay: SUBTITLE_STAGGER,
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

function getViewSafeInsets(slider) {
    return {
        left: Number.parseInt(slider.dataset.lumVillasViewSafeLeft || '104', 10),
        right: Number.parseInt(slider.dataset.lumVillasViewSafeRight || '72', 10),
        top: Number.parseInt(slider.dataset.lumVillasViewSafeTop || '48', 10),
        bottom: Number.parseInt(slider.dataset.lumVillasViewSafeBottom || '48', 10),
    };
}

function getPageScale() {
    const page = document.querySelector('.lum-page');

    if (! page) {
        return 1;
    }

    const match = /scale\(([^)]+)\)/.exec(page.style.transform || '');
    const scale = match ? Number.parseFloat(match[1]) : 1;

    return Number.isFinite(scale) && scale > 0 ? scale : 1;
}

function getSliderPoint(slider, event) {
    const rect = slider.getBoundingClientRect();
    const scale = getPageScale();

    return {
        x: (event.clientX - rect.left) / scale,
        y: (event.clientY - rect.top) / scale,
        layoutWidth: rect.width / scale,
        layoutHeight: rect.height / scale,
    };
}

function isInActiveViewZone(slider, event) {
    const { left, right, top, bottom } = getViewSafeInsets(slider);
    const { x, y, layoutWidth, layoutHeight } = getSliderPoint(slider, event);

    return x >= left
        && x <= layoutWidth - right
        && y >= top
        && y <= layoutHeight - bottom;
}

function isInViewSlider(slider, event) {
    const { x, y, layoutWidth, layoutHeight } = getSliderPoint(slider, event);

    return x >= 0
        && x <= layoutWidth
        && y >= 0
        && y <= layoutHeight;
}

function setViewHoverState(slider, active) {
    slider.classList.toggle('is-villas-view-hover', active);
}

function initViewCursor(root, { getHref, isBusy }) {
    const sliders = root.querySelectorAll('[data-lum-villas-slider-view]');
    const cursor = root.querySelector('[data-lum-villas-view-cursor]');
    const cursorText = cursor?.querySelector('.lum-villas-view-cursor__text');
    const fixedView = root.querySelector('[data-lum-villas-view-fixed]');

    if (! cursor || ! sliders.length || ! window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
        return;
    }

    if (fixedView) {
        fixedView.classList.add('pointer-events-none', 'opacity-0');
    }

    // Fixed on body: ancestors with transform (lum-page scale) break position:fixed inside them.
    document.body.appendChild(cursor);
    cursor.classList.remove('opacity-0');

    let activeSlider = null;
    let isVisible = false;
    let hideTween = null;

    gsap.set(cursor, {
        position: 'fixed',
        left: 0,
        top: 0,
        xPercent: -50,
        yPercent: -50,
        transformOrigin: '50% 50%',
        autoAlpha: 0,
        scale: 0,
        rotation: -10,
    });

    if (cursorText) {
        gsap.set(cursorText, { opacity: 0 });
    }

    const setMouseFromEvent = (_slider, event) => {
        gsap.set(cursor, { x: event.clientX, y: event.clientY });
    };

    const showCursor = (slider, event) => {
        if (! isInViewSlider(slider, event)) {
            hideCursor(slider);

            return;
        }

        activeSlider = slider;
        setViewHoverState(slider, true);
        setMouseFromEvent(slider, event);

        if (isVisible) {
            return;
        }

        isVisible = true;
        hideTween?.kill();
        gsap.killTweensOf(cursor);

        if (cursorText) {
            gsap.killTweensOf(cursorText);
        }

        gsap.fromTo(cursor, {
            autoAlpha: 0,
            scale: 0,
            rotation: -10,
        }, {
            autoAlpha: 1,
            scale: 1,
            rotation: 0.001,
            duration: 0.45,
            ease: 'power3.out',
            overwrite: true,
        });

        if (cursorText) {
            gsap.to(cursorText, {
                opacity: 1,
                duration: 0.28,
                delay: 0.08,
                ease: 'power2.out',
                overwrite: true,
            });
        }
    };

    const hideCursor = (slider) => {
        if (activeSlider !== slider) {
            return;
        }

        activeSlider = null;
        setViewHoverState(slider, false);
        if (! isVisible) {
            return;
        }

        isVisible = false;
        gsap.killTweensOf(cursor);

        if (cursorText) {
            gsap.killTweensOf(cursorText);
            gsap.set(cursorText, { opacity: 0 });
        }

        hideTween = gsap.to(cursor, {
            autoAlpha: 0,
            scale: 0,
            rotation: -10,
            duration: 0.28,
            ease: 'power2.in',
        });
    };

    sliders.forEach((slider) => {
        slider.addEventListener('mouseenter', (event) => showCursor(slider, event));
        slider.addEventListener('mouseleave', () => hideCursor(slider));
        slider.addEventListener('mousemove', (event) => {
            if (! isInViewSlider(slider, event)) {
                if (activeSlider === slider) {
                    hideCursor(slider);
                }

                return;
            }

            if (activeSlider !== slider || ! isVisible) {
                showCursor(slider, event);

                return;
            }

            setMouseFromEvent(slider, event);
        });

        slider.addEventListener('click', (event) => {
            if (isBusy?.()) {
                return;
            }

            if (! isInActiveViewZone(slider, event)) {
                return;
            }

            const href = getHref?.();

            if (! href || href === '#') {
                return;
            }

            window.location.assign(href);
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
        initViewCursor(root, {
            getHref: () => slides[index]?.href || '#',
            isBusy: () => isAnimating,
        });

        panels.forEach((panel) => {
            if (! isPanelVisible(panel)) {
                return;
            }

            preloadSlideAssets(slides, base, panel.dataset.lumVillasSuffix || '');
        });
    });
}
