import gsap from 'gsap';

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

function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function canHoverFine() {
    return window.matchMedia('(hover: hover) and (pointer: fine)').matches;
}

function appendFlipChars(target, value, stacks) {
    [...value].forEach((ch) => {
        const cell = document.createElement('span');
        cell.className = 'lum-menu-flip__char';

        const stack = document.createElement('span');
        stack.className = 'lum-menu-flip__char-stack';

        const top = document.createElement('span');
        top.className = 'lum-menu-flip__glyph';
        top.textContent = ch === ' ' ? '\u00A0' : ch;

        const bottom = top.cloneNode(true);
        bottom.setAttribute('aria-hidden', 'true');

        stack.append(top, bottom);
        cell.append(stack);
        target.append(cell);
        stacks.push(stack);
    });
}

function appendFlipDot(target) {
    const cell = document.createElement('span');
    cell.className = 'lum-menu-flip__dot';
    cell.setAttribute('aria-hidden', 'true');

    const dot = document.createElement('span');
    dot.className = 'lum-menu-dot';
    dot.dataset.lumMenuDot = '';
    cell.append(dot);
    target.append(cell);
}

function bindFlipHover(link, stacks, index) {
    if (! canHoverFine() || prefersReducedMotion() || ! stacks.length) {
        return;
    }

    const staggerFrom = index % 2 === 0 ? 'start' : 'end';
    let tween = null;

    link.addEventListener('mouseenter', () => {
        tween?.kill();
        tween = gsap.to(stacks, {
            yPercent: -50,
            duration: 0.55,
            ease: 'power3.out',
            stagger: { each: 0.02, from: staggerFrom },
            overwrite: true,
        });
    });

    link.addEventListener('mouseleave', () => {
        tween?.kill();
        tween = gsap.to(stacks, {
            yPercent: 0,
            duration: 0.55,
            ease: 'power3.out',
            stagger: { each: 0.02, from: staggerFrom },
            overwrite: true,
        });
    });
}

function wrapFlipLink(link, index) {
    if (link.dataset.lumMenuFlipReady === '1') {
        return {
            text: link.querySelector('.lum-menu-flip__text'),
            stacks: [...link.querySelectorAll('.lum-menu-flip__char-stack')],
        };
    }

    const extras = [];
    let label = '';
    let hasDot = link.classList.contains('is-active');

    [...link.childNodes].forEach((node) => {
        if (node.nodeType === Node.TEXT_NODE) {
            label += node.textContent ?? '';

            return;
        }

        if (node.nodeType !== Node.ELEMENT_NODE) {
            return;
        }

        if (node.matches?.('[data-lum-menu-dot], .lum-menu-dot') || node.querySelector?.('[data-lum-menu-dot], .lum-menu-dot')) {
            hasDot = true;

            return;
        }

        extras.push(node);
    });

    label = label.replace(/\s+/g, ' ').trim();
    link.replaceChildren();

    const mask = document.createElement('span');
    mask.className = 'lum-menu-flip__mask';

    const text = document.createElement('span');
    text.className = 'lum-menu-flip__text';

    const line = document.createElement('span');
    line.className = 'lum-menu-flip__line';

    const stacks = [];
    appendFlipChars(line, label, stacks);

    if (hasDot) {
        appendFlipDot(line);
    }

    text.append(line);
    mask.append(text);
    link.append(mask);
    extras.forEach((node) => link.append(node));

    link.classList.add('lum-menu-flip', 'lum-menu-item');
    link.dataset.lumMenuFlipReady = '1';
    bindFlipHover(link, stacks, index);

    return { text, stacks };
}

function prepareFlipLinks(menu) {
    const texts = [];
    const allStacks = [];
    let index = 0;

    menu.querySelectorAll('[data-lum-menu-nav]').forEach((nav) => {
        nav.querySelectorAll('a').forEach((link) => {
            const wrapped = wrapFlipLink(link, index);
            texts.push(wrapped.text);
            allStacks.push(...wrapped.stacks);
            index += 1;
        });
    });

    return { texts, stacks: allStacks };
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

        if (scroll) {
            scroll.scrollTop = 0;
        }
    };

    const hideShell = () => {
        menu.classList.add('hidden');
        menu.setAttribute('hidden', '');
        menu.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');

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
