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
    return /(?:^|\s)-?translate-x-/.test(element.className);
}

function revealMotionProps(element, travel, fadeOnly) {
    if (fadeOnly) {
        return { from: {}, to: {}, clearProps: 'opacity' };
    }

    // Centered (-translate-x-*) : fade only — marginTop thrash under Lenis + page scale.
    if (isCenteredElement(element)) {
        return {
            from: { opacity: 0 },
            to: { opacity: 1 },
            clearProps: 'opacity',
            fadeOnly: true,
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

    // Heavy media sections opt out (gallery/facilities) — no hide-until-trigger.
    if (element.closest('[data-lum-gallery], [data-lum-facilities]')) {
        return;
    }

    const fadeOnly = element.hasAttribute('data-lum-scroll-fade') || isCenteredElement(element);
    const travel = fadeOnly ? 0 : (Number(element.dataset.lumScrollRevealY) || 48);
    const delay = Number(element.dataset.lumScrollRevealDelay) || 0;
    const motion = revealMotionProps(element, travel, fadeOnly);
    const useFade = fadeOnly || motion.fadeOnly;

    gsap.fromTo(
        element,
        useFade ? { opacity: 0 } : motion.from,
        {
            opacity: 1,
            ...(useFade ? {} : motion.to),
            duration: REVEAL_DURATION,
            delay,
            ease: REVEAL_EASE,
            force3D: ! useFade,
            scrollTrigger: {
                trigger: element,
                start: parseStart(element),
                once: true,
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
