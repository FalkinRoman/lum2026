export function syncBurgerMenuDrawer() {
    const menuScaled = document.querySelector('.lum-burger-menu__scaled');
    const drawer = document.querySelector('.lum-burger-menu__drawer');

    if (! menuScaled || ! drawer) {
        return;
    }

    const rect = menuScaled.getBoundingClientRect();

    if (rect.height <= 0) {
        drawer.style.removeProperty('height');

        return;
    }

    drawer.style.height = `${rect.height}px`;
}

export function initBurgerMenu() {
    const menu = document.getElementById('lum-burger-menu');

    if (! menu) {
        return;
    }

    const toggles = document.querySelectorAll('[data-lum-menu-toggle]');
    const closeButtons = menu.querySelectorAll('[data-lum-menu-close]');
    const backdropTargets = menu.querySelectorAll('[data-lum-menu-backdrop]');
    const scroll = menu.querySelector('.lum-burger-menu__scroll');
    const drawer = menu.querySelector('.lum-burger-menu__drawer');
    let lastTrigger = null;

    const open = (trigger) => {
        lastTrigger = trigger ?? null;
        menu.classList.remove('hidden');
        menu.removeAttribute('hidden');
        menu.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');

        if (scroll) {
            scroll.scrollTop = 0;
        }

        toggles.forEach((toggle) => {
            toggle.setAttribute('aria-expanded', 'true');
        });

        requestAnimationFrame(() => {
            menu.classList.add('is-open');
            syncBurgerMenuDrawer();
        });

        const firstFocusable = menu.querySelector('.lum-burger-menu__panel [data-lum-menu-close]');

        if (firstFocusable) {
            firstFocusable.focus({ preventScroll: true });
        }
    };

    const close = () => {
        menu.classList.remove('is-open');
        menu.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');

        toggles.forEach((toggle) => {
            toggle.setAttribute('aria-expanded', 'false');
        });

        window.setTimeout(() => {
            if (! menu.classList.contains('is-open')) {
                menu.classList.add('hidden');
                menu.setAttribute('hidden', '');
            }

            if (scroll) {
                scroll.scrollTop = 0;
            }
        }, 700);

        if (lastTrigger) {
            lastTrigger.focus({ preventScroll: true });
        }
    };

    const handleClose = (event) => {
        event.preventDefault();
        event.stopPropagation();
        close();
    };

    const handleBackdropClose = (event) => {
        if (! menu.classList.contains('is-open')) {
            return;
        }

        if (drawer?.contains(event.target)) {
            return;
        }

        handleClose(event);
    };

    toggles.forEach((toggle) => {
        toggle.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();

            if (menu.classList.contains('is-open')) {
                close();
                return;
            }

            open(toggle);
        });
    });

    closeButtons.forEach((button) => {
        button.addEventListener('click', handleClose);
    });

    backdropTargets.forEach((target) => {
        target.addEventListener('click', handleBackdropClose);
    });

    scroll?.addEventListener('click', handleBackdropClose);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && menu.classList.contains('is-open')) {
            close();
        }
    });
}
