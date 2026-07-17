import gsap from 'gsap';
import { prepareFlipLinks } from './menu-flip';
import { getLenis } from './smooth-scroll';

export function syncBurgerMenuDrawer() {
    const menuScaled = document.querySelector('.lum-burger-menu__scaled');
    const drawer = document.querySelector('.lum-burger-menu__drawer');

    if (! menuScaled || ! drawer) {
        return;
    }

    // Visual height after scale — keeps clip/backdrop aligned and avoids clipping the contact footer
    const layoutHeight = menuScaled.offsetHeight;

    if (layoutHeight <= 0) {
        drawer.style.removeProperty('height');

        return;
    }

    const scaleMatch = /scale\(([^)]+)\)/.exec(menuScaled.style.transform || '');
    const scale = scaleMatch ? Number.parseFloat(scaleMatch[1]) : 1;
    const visualHeight = layoutHeight * (Number.isFinite(scale) && scale > 0 ? scale : 1);

    drawer.style.height = `${visualHeight}px`;
}

function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function visibleFlipTexts(texts) {
    return texts.filter((node) => {
        const nav = node.closest('[data-lum-menu-nav]');

        return nav && nav.getClientRects().length > 0;
    });
}

export function initBurgerMenu() {
    const menu = document.getElementById('lum-burger-menu');

    if (! menu || menu.dataset.lumBurgerReady === '1') {
        return;
    }

    menu.dataset.lumBurgerReady = '1';

    const toggles = document.querySelectorAll('[data-lum-menu-toggle]');
    const closeButtons = menu.querySelectorAll('[data-lum-menu-close]');
    const backdropTargets = menu.querySelectorAll('[data-lum-menu-backdrop]');
    const scroll = menu.querySelector('.lum-burger-menu__scroll');
    const drawer = menu.querySelector('.lum-burger-menu__drawer');
    const backdrop = menu.querySelector('.lum-burger-menu__backdrop');
    const revealNodes = [...menu.querySelectorAll('[data-lum-menu-reveal]')];
    const { texts: flipTexts, stacks: flipStacks } = prepareFlipLinks(menu);
    let lastTrigger = null;
    let isAnimating = false;
    let isOpen = false;
    let activeTween = null;

    gsap.set(drawer, { clipPath: 'inset(0 0 100% 0)' });
    gsap.set(backdrop, { opacity: 0 });
    gsap.set(flipTexts, { yPercent: 100 });
    gsap.set(flipStacks, { yPercent: 0 });
    gsap.set(revealNodes, { opacity: 0, y: 20 });

    const killActive = () => {
        if (activeTween) {
            activeTween.kill();
            activeTween = null;
        }
    };

    const setExpanded = (expanded) => {
        toggles.forEach((toggle) => {
            toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        });
    };

    const showShell = () => {
        menu.classList.remove('hidden');
        menu.removeAttribute('hidden');
        menu.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');
        getLenis()?.stop();

        if (scroll) {
            scroll.scrollTop = 0;
        }
    };

    const hideShell = () => {
        menu.classList.add('hidden');
        menu.setAttribute('hidden', '');
        menu.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
        getLenis()?.start();

        if (scroll) {
            scroll.scrollTop = 0;
        }
    };

    const open = (trigger) => {
        if (isOpen || isAnimating) {
            return;
        }

        lastTrigger = trigger ?? null;
        isAnimating = true;
        isOpen = true;
        showShell();
        setExpanded(true);
        menu.classList.add('is-open');
        syncBurgerMenuDrawer();
        killActive();

        const flips = visibleFlipTexts(flipTexts);
        const reveals = revealNodes.filter((node) => node.getClientRects().length > 0);

        if (prefersReducedMotion()) {
            gsap.set(drawer, { clipPath: 'inset(0 0 0% 0)' });
            gsap.set(backdrop, { opacity: 1 });
            gsap.set(flips, { yPercent: 0 });
            gsap.set(flipStacks, { yPercent: 0 });
            gsap.set(reveals, { opacity: 1, y: 0 });
            isAnimating = false;

            return;
        }

        gsap.set(flips, { yPercent: 100 });
        gsap.set(flipStacks, { yPercent: 0 });
        gsap.set(reveals, { opacity: 0, y: 20 });

        activeTween = gsap.timeline({
            defaults: { ease: 'power3.inOut' },
            onComplete: () => {
                isAnimating = false;
                activeTween = null;
            },
        })
            .fromTo(backdrop, { opacity: 0 }, { opacity: 1, duration: 0.7, ease: 'power2.out' }, 0)
            .fromTo(
                drawer,
                { clipPath: 'inset(0 0 100% 0)' },
                { clipPath: 'inset(0 0 0% 0)', duration: 1.25, ease: 'expo.inOut' },
                0,
            )
            .fromTo(
                flips,
                { yPercent: 100 },
                {
                    yPercent: 0,
                    duration: 1.5,
                    ease: 'power3.inOut',
                    stagger: 0.07,
                },
                0.12,
            )
            .to(
                reveals,
                {
                    opacity: 1,
                    y: 0,
                    duration: 0.7,
                    ease: 'power3.out',
                    stagger: 0.06,
                },
                0.45,
            );

        const firstFocusable = menu.querySelector('.lum-burger-menu__panel [data-lum-menu-close]');

        if (firstFocusable) {
            firstFocusable.focus({ preventScroll: true });
        }
    };

    const close = () => {
        if (! isOpen || isAnimating) {
            return;
        }

        document.dispatchEvent(new CustomEvent('lum:close-lang-panels'));
        isAnimating = true;
        isOpen = false;
        setExpanded(false);
        menu.classList.remove('is-open');
        killActive();

        const flips = visibleFlipTexts(flipTexts);
        const reveals = revealNodes.filter((node) => node.getClientRects().length > 0);

        const finish = () => {
            hideShell();
            gsap.set(drawer, { clipPath: 'inset(0 0 100% 0)' });
            gsap.set(backdrop, { opacity: 0 });
            gsap.set(flips, { yPercent: 100 });
            gsap.set(flipStacks, { yPercent: 0 });
            gsap.set(reveals, { opacity: 0, y: 20 });
            isAnimating = false;
            activeTween = null;

            if (lastTrigger) {
                lastTrigger.focus({ preventScroll: true });
            }
        };

        if (prefersReducedMotion()) {
            finish();

            return;
        }

        activeTween = gsap.timeline({
            defaults: { ease: 'power3.inOut' },
            onComplete: finish,
        })
            .to(flips, {
                yPercent: 100,
                duration: 0.85,
                stagger: { each: 0.04, from: 'end' },
            }, 0)
            .to(reveals, {
                opacity: 0,
                y: 12,
                duration: 0.45,
                ease: 'power2.in',
            }, 0)
            .to(drawer, {
                clipPath: 'inset(0 0 100% 0)',
                duration: 1.15,
                ease: 'expo.inOut',
            }, 0.05)
            .to(backdrop, {
                opacity: 0,
                duration: 0.55,
                ease: 'power2.in',
            }, 0.2);
    };

    const handleClose = (event) => {
        event.preventDefault();
        event.stopPropagation();
        close();
    };

    const handleBackdropClose = (event) => {
        if (! isOpen) {
            return;
        }

        if (event.target.closest('[data-lum-lang-toggle], .lum-lang-panel')) {
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

            if (isOpen) {
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
        if (event.key === 'Escape' && isOpen) {
            close();
        }
    });
}
