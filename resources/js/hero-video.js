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

function revealWhenPlaying(video) {
    const show = () => {
        video.classList.remove('opacity-0');
        video.classList.add('opacity-100');
    };

    if (! video.paused && video.readyState >= 2) {
        show();
    }

    video.addEventListener('playing', show);
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
        video.addEventListener('loadeddata', run, { once: true });
        run();
    }
}

export function initHeroVideo() {
    const videos = [...document.querySelectorAll('[data-lum-hero-video]')];

    if (! videos.length) {
        return;
    }

    videos.forEach((video) => {
        harden(video);
        revealWhenPlaying(video);
    });

    let activeBreakpoint = null;

    const sync = (force = false) => {
        const breakpoint = getActiveBreakpoint();

        if (! force && breakpoint === activeBreakpoint) {
            videos.forEach((video) => {
                if (video.dataset.lumBp === breakpoint) {
                    tryPlay(video);
                }
            });

            return;
        }

        activeBreakpoint = breakpoint;

        videos.forEach((video) => {
            const active = video.dataset.lumBp === breakpoint;

            if (active) {
                tryPlay(video);
            } else {
                video.pause();
                video.classList.add('opacity-0');
                video.classList.remove('opacity-100');
            }
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

    // Keep hammering play briefly — Telegram WebView often unlocks a tick late.
    let ticks = 0;
    const boot = window.setInterval(() => {
        playActive();
        ticks += 1;

        if (ticks >= 20) {
            window.clearInterval(boot);
        }
    }, 250);

    window.addEventListener('resize', () => sync(false), { passive: true });
    document.addEventListener('visibilitychange', () => {
        if (! document.hidden) {
            playActive();
        }
    });
    window.addEventListener('pageshow', playActive);

    const unlock = () => playActive();
    document.addEventListener('touchstart', unlock, { capture: true, passive: true });
    document.addEventListener('touchend', unlock, { capture: true, passive: true });
    document.addEventListener('click', unlock, { capture: true });
    document.addEventListener('scroll', unlock, { capture: true, passive: true });
}
