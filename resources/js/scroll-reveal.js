import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const REVEAL_EASE = 'power2.out';
const REVEAL_DURATION = 0.95;

function isVisibleElement(element) {
    return element.offsetParent !== null || element.getClientRects().length > 0;
}

function parseStart(element) {
    return element.dataset.lumScrollStart || 'top 88%';
}

function isCenteredElement(element) {
    return element.classList.contains('-translate-x-1/2');
}

function revealMotionProps(element, travel, fadeOnly) {
    if (fadeOnly) {
        return { from: {}, to: {}, clearProps: 'opacity' };
    }

    if (isCenteredElement(element)) {
        return {
            from: { marginTop: travel, opacity: 0 },
            to: { marginTop: 0, opacity: 1 },
            clearProps: 'marginTop,opacity',
        };
    }

    return {
        from: { y: travel, opacity: 0 },
        to: { y: 0, opacity: 1 },
        clearProps: 'transform,opacity',
    };
}

function revealElement(element) {
    if (element.closest('[data-lum-scroll-stagger]') && element.hasAttribute('data-lum-scroll-item')) {
        return;
    }

    const fadeOnly = element.hasAttribute('data-lum-scroll-fade');
    const travel = fadeOnly ? 0 : (Number(element.dataset.lumScrollRevealY) || 48);
    const delay = Number(element.dataset.lumScrollRevealDelay) || 0;
    const motion = revealMotionProps(element, travel, fadeOnly);

    gsap.fromTo(
        element,
        fadeOnly ? { opacity: 0 } : motion.from,
        {
            opacity: 1,
            ...(fadeOnly ? {} : motion.to),
            duration: REVEAL_DURATION,
            delay,
            ease: REVEAL_EASE,
            force3D: ! fadeOnly && ! isCenteredElement(element),
            scrollTrigger: {
                trigger: element,
                start: parseStart(element),
                once: true,
                invalidateOnRefresh: true,
            },
            onComplete: () => {
                gsap.set(element, { clearProps: motion.clearProps });
            },
        },
    );
}

export function initScrollReveal() {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion) {
        return;
    }

    document.querySelectorAll('[data-lum-scroll-stagger]').forEach((group) => {
        if (! isVisibleElement(group)) {
            return;
        }

        const items = [...group.querySelectorAll('[data-lum-scroll-item]')];

        if (! items.length) {
            return;
        }

        const fadeOnly = group.hasAttribute('data-lum-scroll-stagger-fade');

        gsap.fromTo(
            items,
            fadeOnly ? { opacity: 0 } : { y: 56, opacity: 0 },
            {
                ...(fadeOnly ? {} : { y: 0 }),
                opacity: 1,
                duration: fadeOnly ? 0.7 : REVEAL_DURATION,
                ease: REVEAL_EASE,
                stagger: fadeOnly ? 0.08 : 0.14,
                scrollTrigger: {
                    trigger: group,
                    start: 'top 85%',
                    once: true,
                    invalidateOnRefresh: true,
                },
                onComplete: () => {
                    gsap.set(items, { clearProps: fadeOnly ? 'opacity' : 'transform,opacity' });
                },
            },
        );
    });

    document.querySelectorAll('[data-lum-scroll-reveal]')
        .forEach((element) => {
            if (isVisibleElement(element)) {
                revealElement(element);
            }
        });

    ScrollTrigger.refresh();
}
