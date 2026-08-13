/**
 * Header chrome fit:
 * - desktop nav↔logo collision → force tablet (`compact`)
 * - tablet CTA/actions↔logo collision → force mobile (`mobile`)
 * Hysteresis avoids flicker at the threshold.
 */

const MIN_GAP_PX = 28;
const EXIT_HYSTERESIS_PX = 96;
const MOBILE_MAX_PX = 430;
const DESKTOP_MIN_PX = 1024;

let compactExitWidth = 0;
let mobileExitWidth = 0;

function isLaidOut(el) {
    const style = window.getComputedStyle(el);

    if (style.display === 'none' || style.visibility === 'hidden') {
        return false;
    }

    const box = el.getBoundingClientRect();

    return box.width >= 1 && box.height >= 1;
}

function measureDesktopNavGap() {
    const headers = document.querySelectorAll('[data-lum-desk-header]');

    for (const header of headers) {
        if (! isLaidOut(header)) {
            continue;
        }

        const nav = header.querySelector('[data-lum-header-nav]');
        const logo = header.querySelector('[data-lum-header-logo]');
        const right = header.querySelector('[data-lum-header-right]');

        if (! nav || ! logo || ! isLaidOut(nav) || ! isLaidOut(logo)) {
            continue;
        }

        const navBox = nav.getBoundingClientRect();
        const logoBox = logo.getBoundingClientRect();
        const rightBox = right && isLaidOut(right) ? right.getBoundingClientRect() : null;

        const leftGap = logoBox.left - navBox.right;
        const rightGap = rightBox ? rightBox.left - logoBox.right : MIN_GAP_PX;

        return Math.min(leftGap, rightGap);
    }

    return null;
}

function measureTabletHeaderGap() {
    const headers = document.querySelectorAll('[data-lum-tab-header]');

    for (const header of headers) {
        if (! isLaidOut(header)) {
            continue;
        }

        const logo = header.querySelector('[data-lum-header-logo]');
        const actions = header.querySelector('[data-lum-header-actions]');

        if (! logo || ! actions || ! isLaidOut(logo) || ! isLaidOut(actions)) {
            continue;
        }

        const logoBox = logo.getBoundingClientRect();
        const actionsBox = actions.getBoundingClientRect();

        return actionsBox.left - logoBox.right;
    }

    return null;
}

function setMode(mode) {
    const root = document.documentElement;
    const prev = root.dataset.lumHeaderMode || 'full';

    if (prev === mode) {
        return false;
    }

    root.dataset.lumHeaderMode = mode;

    return true;
}

export function syncHeaderFitMode() {
    const root = document.documentElement;
    const width = window.innerWidth;

    if (width <= MOBILE_MAX_PX) {
        if (root.dataset.lumHeaderMode !== 'full') {
            compactExitWidth = 0;
            mobileExitWidth = 0;

            return setMode('full');
        }

        return false;
    }

    let mode = root.dataset.lumHeaderMode || 'full';
    let changed = false;

    // Exit forced modes only after growing past hysteresis, then re-probe.
    if (mode === 'mobile') {
        if (width < mobileExitWidth) {
            return false;
        }

        changed = setMode('full') || changed;
        mode = 'full';
    }

    if (mode === 'compact') {
        if (width < compactExitWidth) {
            const tabGap = measureTabletHeaderGap();

            if (tabGap !== null && tabGap < MIN_GAP_PX) {
                mobileExitWidth = width + EXIT_HYSTERESIS_PX;

                return setMode('mobile');
            }

            return changed;
        }

        changed = setMode('full') || changed;
        mode = 'full';
    }

    if (width >= DESKTOP_MIN_PX) {
        const deskGap = measureDesktopNavGap();

        if (deskGap !== null && deskGap < MIN_GAP_PX) {
            compactExitWidth = width + EXIT_HYSTERESIS_PX;
            changed = setMode('compact') || changed;

            return true;
        }
    }

    const tabGap = measureTabletHeaderGap();

    if (tabGap !== null && tabGap < MIN_GAP_PX) {
        mobileExitWidth = width + EXIT_HYSTERESIS_PX;
        changed = setMode('mobile') || changed;

        return true;
    }

    return changed;
}

export function getHeaderForcedBreakpoint(viewportBreakpoint) {
    const mode = document.documentElement.dataset.lumHeaderMode;

    if (mode === 'mobile') {
        return 'mobile';
    }

    if (viewportBreakpoint === 'desktop' && mode === 'compact') {
        return 'tablet';
    }

    return viewportBreakpoint;
}
