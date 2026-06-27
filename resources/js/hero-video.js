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

function setVideoSource(video, shouldPlay) {
    const source = video.querySelector('source');

    if (! source) {
        return;
    }

    const src = source.dataset.src;

    if (! src) {
        return;
    }

    if (shouldPlay) {
        if (source.getAttribute('src') !== src) {
            source.setAttribute('src', src);
            video.load();
        }

        video.play().catch(() => {});
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

    const sync = () => {
        const breakpoint = getActiveBreakpoint();

        if (breakpoint === activeBreakpoint) {
            return;
        }

        activeBreakpoint = breakpoint;

        videos.forEach((video) => {
            setVideoSource(video, video.dataset.lumBp === breakpoint);
        });
    };

    sync();
    window.addEventListener('resize', sync, { passive: true });
}
