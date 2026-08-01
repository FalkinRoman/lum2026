function getActiveBreakpoint() {
    const width = window.innerWidth;

    if (width <= 430) {
        return 'mobile';
    }

    if (width <= 1023) {
        return 'tablet';
    }

    return 'desktop';
}

function harden(video) {
    video.muted = true;
    video.defaultMuted = true;
    video.volume = 0;
    video.playsInline = true;
    video.autoplay = true;
    video.loop = true;
    video.controls = false;
    video.setAttribute('muted', '');
    video.setAttribute('playsinline', '');
    video.setAttribute('webkit-playsinline', '');
    video.setAttribute('autoplay', '');
    video.removeAttribute('controls');
}

function markPlaying(video) {
    video.classList.add('is-playing');
    const media = video.closest('[data-lum-hero-media]');

    if (media) {
        media.classList.add('is-playing');
    }
}

function tryPlay(video) {
    harden(video);

    const p = video.play();

    if (p && typeof p.then === 'function') {
        p.then(() => markPlaying(video)).catch(() => {});
    }

    if (! video.paused && video.readyState >= 2) {
        markPlaying(video);
    }
}

function ensureSource(video) {
    const src = video.dataset.src;

    if (! src) {
        return false;
    }

    if (video.getAttribute('src') === src || (video.currentSrc && video.currentSrc.includes(src.split('/').pop()))) {
        return true;
    }

    video.preload = 'auto';
    video.setAttribute('src', src);
    video.load();

    return true;
}

function bindReadyPlay(video) {
    if (video.dataset.lumPlayBound === '1') {
        return;
    }

    video.dataset.lumPlayBound = '1';

    const onReady = () => tryPlay(video);

    video.addEventListener('loadeddata', onReady);
    video.addEventListener('canplay', onReady);
    video.addEventListener('canplaythrough', onReady);
    video.addEventListener('playing', () => markPlaying(video));
}

function activateVideo(video) {
    harden(video);
    bindReadyPlay(video);

    if (! ensureSource(video)) {
        return;
    }

    tryPlay(video);
}

function deactivateVideo(video) {
    video.pause();
    video.classList.remove('is-playing');

    const media = video.closest('[data-lum-hero-media]');

    if (media) {
        media.classList.remove('is-playing');
    }

    if (video.hasAttribute('src') && video.dataset.lumBp !== window.__lumHeroEarlyBp) {
        video.removeAttribute('src');
        video.load();
    }
}

export function initHeroVideo() {
    const videos = [...document.querySelectorAll('[data-lum-hero-video]')];

    if (! videos.length) {
        return;
    }

    let activeBreakpoint = null;

    const sync = () => {
        const breakpoint = getActiveBreakpoint();

        if (breakpoint === activeBreakpoint) {
            const active = videos.find((v) => v.dataset.lumBp === breakpoint);

            if (active) {
                tryPlay(active);
            }

            return;
        }

        activeBreakpoint = breakpoint;

        videos.forEach((video) => {
            if (video.dataset.lumBp === breakpoint) {
                activateVideo(video);
            } else {
                deactivateVideo(video);
            }
        });
    };

    const playActive = () => {
        const active = videos.find((v) => v.dataset.lumBp === activeBreakpoint);

        if (active) {
            tryPlay(active);
        }
    };

    sync();

    // Page starts with opacity:0 (lum-is-loading). Retry once it becomes visible —
    // WebKit often rejects play() while ancestors are effectively invisible.
    const onVisible = () => {
        playActive();
        requestAnimationFrame(playActive);
    };

    if (document.documentElement.classList.contains('lum-is-loading')) {
        const observer = new MutationObserver(() => {
            if (! document.documentElement.classList.contains('lum-is-loading')) {
                observer.disconnect();
                onVisible();
            }
        });

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class'],
        });
    } else {
        onVisible();
    }

    window.addEventListener('resize', sync, { passive: true });
    document.addEventListener('visibilitychange', () => {
        if (! document.hidden) {
            playActive();
        }
    });
    window.addEventListener('pageshow', playActive);
    window.addEventListener('load', playActive, { once: true });

    // Last-resort unlock (Low Power Mode / some WebViews still need a gesture).
    const unlock = () => playActive();
    document.addEventListener('touchstart', unlock, { capture: true, passive: true });
    document.addEventListener('touchend', unlock, { capture: true, passive: true });
    document.addEventListener('pointerdown', unlock, { capture: true });
    document.addEventListener('click', unlock, { capture: true });
    document.addEventListener('scroll', unlock, { capture: true, passive: true });
}
