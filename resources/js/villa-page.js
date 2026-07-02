import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const INTRO_EASE = 'power3.out';
const INTRO_DURATION = 1.15;
const INTRO_STAGGER = 0.18;

function isVisibleElement(element) {
    return element.offsetParent !== null || element.getClientRects().length > 0;
}

function initVillaEyebrow(node) {
    gsap.fromTo(
        node,
        { marginTop: 20, opacity: 0 },
        {
            marginTop: 0,
            opacity: 1,
            duration: 0.9,
            ease: INTRO_EASE,
            scrollTrigger: {
                trigger: node,
                start: 'top 92%',
                once: true,
                invalidateOnRefresh: true,
            },
            onComplete: () => {
                gsap.set(node, { clearProps: 'marginTop,opacity' });
            },
        },
    );
}

function initVillaIntro(root) {
    const items = [...root.querySelectorAll('[data-lum-stay-intro-item]')]
        .filter((item) => ! item.closest('[data-lum-hero-title]'))
        .sort((left, right) => (
            Number(left.dataset.lumStayIntroOrder || 0) - Number(right.dataset.lumStayIntroOrder || 0)
        ));

    if (! items.length) {
        return;
    }

    gsap.fromTo(
        items,
        { y: 56, opacity: 0 },
        {
            y: 0,
            opacity: 1,
            duration: INTRO_DURATION,
            ease: INTRO_EASE,
            stagger: INTRO_STAGGER,
            delay: 0.22,
            onComplete: () => {
                gsap.set(items, { clearProps: 'y,opacity' });
            },
        },
    );
}

function initVillaPolaroid(node, index) {
    const rotate = node.style.transform || '';

    gsap.fromTo(
        node,
        { y: 48, opacity: 0 },
        {
            y: 0,
            opacity: 1,
            duration: 1.1,
            delay: index * 0.1,
            ease: INTRO_EASE,
            onUpdate() {
                const y = gsap.getProperty(node, 'y') || 0;
                node.style.transform = `${rotate} translateY(${y}px)`.trim();
            },
            onComplete() {
                node.style.transform = rotate;
            },
            scrollTrigger: {
                trigger: node,
                start: 'top 92%',
                once: true,
                invalidateOnRefresh: true,
            },
        },
    );
}

function initVillaCard(card, index) {
    gsap.fromTo(
        card,
        { y: 44, opacity: 0, scale: 1.06 },
        {
            y: 0,
            opacity: 1,
            scale: 1,
            duration: 1.05,
            delay: index * 0.1,
            ease: INTRO_EASE,
            scrollTrigger: {
                trigger: card,
                start: 'top 88%',
                once: true,
                invalidateOnRefresh: true,
            },
            onComplete: () => {
                gsap.set(card, { clearProps: 'y,opacity,scale' });
            },
        },
    );
}

export function initVillaPage() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    document.querySelectorAll('[data-lum-villa-intro]').forEach((root) => {
        if (isVisibleElement(root)) {
            initVillaIntro(root);
        }
    });

    document.querySelectorAll('[data-lum-villa-polaroid]').forEach((node, index) => {
        if (isVisibleElement(node)) {
            initVillaPolaroid(node, index);
        }
    });

    document.querySelectorAll('[data-lum-villa-card]').forEach((card, index) => {
        if (isVisibleElement(card)) {
            initVillaCard(card, index);
        }
    });

    document.querySelectorAll('[data-lum-villa-eyebrow]').forEach((node) => {
        if (isVisibleElement(node)) {
            initVillaEyebrow(node);
        }
    });

    ScrollTrigger.refresh();
}
