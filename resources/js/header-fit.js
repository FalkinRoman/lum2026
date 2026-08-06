/**
 * If desktop nav would collide with centered LUM logo, force tablet (burger) chrome.
 * Uses hysteresis so it doesn't flicker at the threshold.
 */

const MIN_GAP_PX = 28;
const EXIT_HYSTERESIS_PX = 96;

let compactExitWidth = 0;

function measureDesktopNavGap() {
    const headers = document.querySelectorAll('[data-lum-desk-header]');

    for (const header of headers) {
        const style = window.getComputedStyle(header);

        if (style.display === 'none' || style.visibility === 'hidden') {
            continue;
        }

        const nav = header.querySelector('[data-lum-header-nav]');
        const logo = header.querySelector('[data-lum-header-logo]');
        const right = header.querySelector('[data-lum-header-right]');

        if (! nav || ! logo) {
            continue;
        }

        const navBox = nav.getBoundingClientRect();
        const logoBox = logo.getBoundingClientRect();
        const rightBox = right?.getBoundingClientRect();

        if (navBox.width < 1 || logoBox.width < 1) {
            continue;
        }

        const leftGap = logoBox.left - navBox.right;
        const rightGap = rightBox ? rightBox.left - logoBox.right : MIN_GAP_PX;

        return Math.min(leftGap, rightGap);
    }

    return null;
}

export function syncHeaderFitMode() {
    const root = document.documentElement;
    const width = window.innerWidth;

    if (width <= 1023) {
        if (root.dataset.lumHeaderMode !== 'full') {
            root.dataset.lumHeaderMode = 'full';
            compactExitWidth = 0;

            return true;
        }

        return false;
    }

    const mode = root.dataset.lumHeaderMode || 'full';

    if (mode === 'compact') {
        if (width < compactExitWidth) {
            return false;
        }

        // Wide enough to re-probe desktop.
        root.dataset.lumHeaderMode = 'full';

        return true;
    }

    const gap = measureDesktopNavGap();

    if (gap === null) {
        return false;
    }

    if (gap < MIN_GAP_PX) {
        compactExitWidth = width + EXIT_HYSTERESIS_PX;
        root.dataset.lumHeaderMode = 'compact';

        return true;
    }

    return false;
}

export function getHeaderForcedBreakpoint(viewportBreakpoint) {
    if (
        viewportBreakpoint === 'desktop'
        && document.documentElement.dataset.lumHeaderMode === 'compact'
    ) {
        return 'tablet';
    }

    return viewportBreakpoint;
}
