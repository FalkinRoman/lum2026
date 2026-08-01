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
    video.loop = true;
    video.controls = false;
    video.setAttribute('muted', '');
    video.setAttribute('playsinline', '');
    video.setAttribute('webkit-playsinline', '');
    video.removeAttribute('controls');
}

function tryPlay(video) {
    harden(video);

    const run = () => {
        const p = video.play();

        if (p && typeof p.catch === 'function') {
            p.catch(() => {});
        }
    };

    if (video.readyState >= 2) {
        run();
    } else {
        video.addEventListener('canplay', run, { once: true });
        run();
    }
}

function markPlaying(video) {
    video.classList.add('is-playing');
    const media = video.closest('[data-lum-hero-media]');

    if (media) {
        media.classList.add('is-playing');
    }
}

function ensureSource(video) {
    const src = video.dataset.src;

    if (! src) {
        return false;
    }

    if (video.getAttribute('src') === src) {
        return true;
    }

    video.setAttribute('src', src);
    video.load();

    return true;
}

function activateVideo(video) {
    harden(video);

    if (! ensureSource(video)) {
        return;
    }

    video.addEventListener('playing', () => markPlaying(video), { once: true });
    tryPlay(video);
}

function deactivateVideo(video) {
    video.pause();
    video.classList.remove('is-playing');

    const media = video.closest('[data-lum-hero-media]');

    if (media) {
        media.classList.remove('is-playing');
    }

    // Drop source so hidden breakpoints don't keep buffering.
    if (video.hasAttribute('src')) {
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

    // Poster paints first; start video after first paint so LCP stays snappy.
    const start = () => sync();

    if (typeof window.requestIdleCallback === 'function') {
        window.requestIdleCallback(start, { timeout: 400 });
    } else {
        window.setTimeout(start, 100);
    }

    window.addEventListener('resize', sync, { passive: true });
    document.addEventListener('visibilitychange', () => {
        if (! document.hidden) {
            playActive();
        }
    });
    window.addEventListener('pageshow', playActive);

    const unlock = () => playActive();
    document.addEventListener('touchstart', unlock, { capture: true, passive: true });
    document.addEventListener('click', unlock, { capture: true });
}
