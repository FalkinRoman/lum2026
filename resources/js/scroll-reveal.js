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

function revealElement(element) {
    if (element.closest('[data-lum-scroll-stagger]') && element.hasAttribute('data-lum-scroll-item')) {
        return;
    }

    const fadeOnly = element.hasAttribute('data-lum-scroll-fade');
    const travel = fadeOnly ? 0 : (Number(element.dataset.lumScrollRevealY) || 48);
    const delay = Number(element.dataset.lumScrollRevealDelay) || 0;

    gsap.fromTo(
        element,
        fadeOnly ? { opacity: 0 } : { y: travel, opacity: 0 },
        {
            y: fadeOnly ? undefined : 0,
            opacity: 1,
            duration: REVEAL_DURATION,
            delay,
            ease: REVEAL_EASE,
            force3D: ! fadeOnly,
            scrollTrigger: {
                trigger: element,
                start: parseStart(element),
                once: true,
                invalidateOnRefresh: true,
            },
            onComplete: () => {
                if (! fadeOnly) {
                    gsap.set(element, { clearProps: 'transform' });
                }
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

        gsap.fromTo(
            items,
            { y: 56, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: REVEAL_DURATION,
                ease: REVEAL_EASE,
                stagger: 0.14,
                scrollTrigger: {
                    trigger: group,
                    start: 'top 85%',
                    once: true,
                    invalidateOnRefresh: true,
                },
                onComplete: () => {
                    gsap.set(items, { clearProps: 'transform' });
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
