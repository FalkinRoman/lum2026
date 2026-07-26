/**
 * Exely iframe (cross-origin) глотает wheel/touch и не форвардит родителю.
 * На /booking iframe ≈ viewport → «скролл умер», пока курсор/палец над формой.
 *
 * Bridge: прозрачный слой ловит scroll-жесты → window.scrollBy.
 * Клик/тап снимает слой (форма кликабельна), mouseleave / уход пальца — возвращает.
 */
export function initExelyScrollBridge() {
    const mounts = document.querySelectorAll('#be-booking-form');

    if (! mounts.length) {
        return;
    }

    mounts.forEach((mount) => {
        if (mount.dataset.lumScrollBridge === '1') {
            return;
        }

        mount.dataset.lumScrollBridge = '1';
        bindBridge(mount);
    });
}

function bindBridge(mount) {
    if (getComputedStyle(mount).position === 'static') {
        mount.style.position = 'relative';
    }

    let bridge = null;
    let armed = true;
    let touchY = null;
    let touchMoved = false;

    const arm = () => {
        armed = true;

        if (bridge) {
            bridge.classList.remove('is-disarmed');
        }
    };

    const disarm = () => {
        armed = false;

        if (bridge) {
            bridge.classList.add('is-disarmed');
        }
    };

    const attachBridgeListeners = (el) => {
        el.addEventListener(
            'wheel',
            (event) => {
                if (! armed) {
                    return;
                }

                event.preventDefault();
                window.scrollBy({
                    top: event.deltaY,
                    left: event.deltaX,
                    behavior: 'instant',
                });
            },
            { passive: false },
        );

        el.addEventListener(
            'touchstart',
            (event) => {
                if (! armed || event.touches.length !== 1) {
                    return;
                }

                touchY = event.touches[0].clientY;
                touchMoved = false;
            },
            { passive: true },
        );

        el.addEventListener(
            'touchmove',
            (event) => {
                if (! armed || touchY === null || event.touches.length !== 1) {
                    return;
                }

                const y = event.touches[0].clientY;
                const delta = touchY - y;

                if (Math.abs(delta) < 2 && ! touchMoved) {
                    return;
                }

                touchMoved = true;
                touchY = y;
                event.preventDefault();
                window.scrollBy(0, delta);
            },
            { passive: false },
        );

        el.addEventListener(
            'touchend',
            () => {
                if (armed && ! touchMoved) {
                    disarm();
                }

                touchY = null;
                touchMoved = false;
            },
            { passive: true },
        );

        el.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            disarm();
        });
    };

    const ensureBridge = () => {
        bridge = mount.querySelector(':scope > .lum-exely-scroll-bridge');

        if (! bridge) {
            bridge = document.createElement('div');
            bridge.className = 'lum-exely-scroll-bridge';
            bridge.setAttribute('aria-hidden', 'true');
            mount.appendChild(bridge);
            attachBridgeListeners(bridge);
        }

        if (! armed) {
            bridge.classList.add('is-disarmed');
        } else {
            bridge.classList.remove('is-disarmed');
        }
    };

    ensureBridge();

    mount.addEventListener('mouseleave', arm);

    document.addEventListener(
        'touchstart',
        (event) => {
            if (! armed && ! mount.contains(event.target)) {
                arm();
            }
        },
        { passive: true },
    );

    // Exely перерисовывает mount — вернуть bridge если снесли
    const observer = new MutationObserver(() => {
        ensureBridge();
    });

    observer.observe(mount, { childList: true });
}
