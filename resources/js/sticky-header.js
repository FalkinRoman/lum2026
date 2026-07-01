export function syncStickyHeader() {
    const stickyScaled = document.querySelector('.lum-sticky-header__scaled');
    const stickyHeader = document.getElementById('lum-sticky-header');

    if (! stickyScaled || ! stickyHeader) {
        return;
    }

    const rect = stickyScaled.getBoundingClientRect();

    if (rect.height <= 0) {
        stickyHeader.style.removeProperty('height');

        return;
    }

    stickyHeader.style.height = `${rect.height}px`;
}

function isVisibleTrigger(element) {
    if (! element.isConnected) {
        return false;
    }

    let node = element;

    while (node) {
        const style = window.getComputedStyle(node);

        if (style.display === 'none' || style.visibility === 'hidden') {
            return false;
        }

        node = node.parentElement;
    }

    const rect = element.getBoundingClientRect();

    return rect.height > 0 || rect.width > 0 || element.getClientRects().length > 0;
}

function getInlineHeaderHeight() {
    return window.innerWidth >= 1024 ? 132 : 80;
}

function shouldShowStickyHeader() {
    const triggers = [...document.querySelectorAll('[data-lum-sticky-trigger]')].filter(isVisibleTrigger);

    if (triggers.length) {
        return triggers.some((trigger) => trigger.getBoundingClientRect().bottom < 0);
    }

    return window.scrollY > getInlineHeaderHeight();
}

export function initStickyHeader() {
    const header = document.getElementById('lum-sticky-header');

    if (! header) {
        return;
    }

    const setVisible = (visible) => {
        header.classList.toggle('is-visible', visible);
        header.setAttribute('aria-hidden', visible ? 'false' : 'true');
    };

    const update = () => {
        setVisible(shouldShowStickyHeader());
        syncStickyHeader();
    };

    window.addEventListener('scroll', update, { passive: true });
    document.addEventListener('lum:layout-change', update);

    let lastWidth = window.innerWidth;

    window.addEventListener('resize', () => {
        if (window.innerWidth === lastWidth) {
            return;
        }

        lastWidth = window.innerWidth;
        update();
    }, { passive: true });

    window.addEventListener('load', update, { once: true });

    update();
}
