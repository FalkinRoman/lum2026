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

function isVisibleElement(element) {
    return element.offsetParent !== null || element.getClientRects().length > 0;
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
        const trigger = [...document.querySelectorAll('[data-lum-sticky-trigger]')]
            .find(isVisibleElement);

        if (! trigger) {
            setVisible(false);

            return;
        }

        setVisible(trigger.getBoundingClientRect().bottom < 0);
    };

    window.addEventListener('scroll', update, { passive: true });

    let lastWidth = window.innerWidth;

    window.addEventListener('resize', () => {
        if (window.innerWidth === lastWidth) {
            return;
        }

        lastWidth = window.innerWidth;
        update();
    }, { passive: true });

    update();
}
