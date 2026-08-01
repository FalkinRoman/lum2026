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

function hardenAutoplayAttrs(video) {
    video.muted = true;
    video.defaultMuted = true;
    video.playsInline = true;
    video.autoplay = true;
    video.loop = true;
    video.setAttribute('muted', '');
    video.setAttribute('playsinline', '');
    video.setAttribute('webkit-playsinline', '');
    video.setAttribute('autoplay', '');
    video.removeAttribute('controls');
}

function tryPlay(video) {
    hardenAutoplayAttrs(video);

    const attempt = video.play();

    if (attempt && typeof attempt.then === 'function') {
        attempt.catch(() => {
            // Autoplay blocked (Telegram/iOS) — retry on next gesture / canplay.
        });
    }
}

function setVideoSource(video, shouldPlay) {
    const source = video.querySelector('source');

    if (! source) {
        return;
    }

    const src = source.dataset.src;

    if (! src) {
        return;
    }

    hardenAutoplayAttrs(video);

    if (shouldPlay) {
        if (source.getAttribute('src') !== src) {
            source.setAttribute('src', src);
            video.load();
        }

        const kick = () => tryPlay(video);

        if (video.readyState >= 2) {
            kick();
        } else {
            video.addEventListener('loadeddata', kick, { once: true });
            video.addEventListener('canplay', kick, { once: true });
            kick();
        }

        return;
    }

    video.pause();

    if (source.hasAttribute('src')) {
        source.removeAttribute('src');
        video.load();
    }
}

export function initHeroVideo() {
    const videos = [...document.querySelectorAll('[data-lum-hero-video]')];

    if (! videos.length) {
        return;
    }

    let activeBreakpoint = null;

    const sync = (force = false) => {
        const breakpoint = getActiveBreakpoint();

        if (! force && breakpoint === activeBreakpoint) {
            return;
        }

        activeBreakpoint = breakpoint;

        videos.forEach((video) => {
            setVideoSource(video, video.dataset.lumBp === breakpoint);
        });
    };

    const playActive = () => {
        videos.forEach((video) => {
            if (video.dataset.lumBp === activeBreakpoint) {
                tryPlay(video);
            }
        });
    };

    sync(true);

    window.addEventListener('resize', () => sync(false), { passive: true });
    document.addEventListener('visibilitychange', () => {
        if (! document.hidden) {
            playActive();
        }
    });
    window.addEventListener('pageshow', playActive);

    // Telegram / iOS WebViews often need one user gesture — unlock without showing UI.
    const unlock = () => {
        playActive();
        document.removeEventListener('touchstart', unlock, true);
        document.removeEventListener('click', unlock, true);
        document.removeEventListener('scroll', unlock, true);
    };

    document.addEventListener('touchstart', unlock, { capture: true, passive: true });
    document.addEventListener('click', unlock, { capture: true });
    document.addEventListener('scroll', unlock, { capture: true, passive: true });
}
