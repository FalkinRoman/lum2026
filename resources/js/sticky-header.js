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

export function initStickyHeader() {
    const header = document.getElementById('lum-sticky-header');

    if (! header) {
        return;
    }

    const getActiveTrigger = () => (
        [...document.querySelectorAll('[data-lum-sticky-trigger]')]
            .find((element) => element.offsetParent !== null)
    );

    const setVisible = (visible) => {
        header.classList.toggle('is-visible', visible);
        header.setAttribute('aria-hidden', visible ? 'false' : 'true');
    };

    const update = () => {
        const trigger = getActiveTrigger();

        if (! trigger) {
            setVisible(false);

            return;
        }

        const rect = trigger.getBoundingClientRect();

        setVisible(rect.bottom < 0);
    };

    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
    update();
}
