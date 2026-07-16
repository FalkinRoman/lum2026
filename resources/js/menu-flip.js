import gsap from 'gsap';

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

export function wrapFlipLink(link, index) {
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

export function prepareFlipLinks(menu) {
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

export function initTextFlipLinks(root = document) {
    root.querySelectorAll('[data-lum-text-flip]').forEach((link, index) => {
        wrapFlipLink(link, index);
    });
}
