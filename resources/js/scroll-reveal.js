import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const REVEAL_EASE = 'power2.out';
const REVEAL_DURATION = 0.95;

export function initScrollReveal() {
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion) {
        return;
    }

    document.querySelectorAll('[data-lum-scroll-stagger]').forEach((group) => {
        const items = group.querySelectorAll('[data-lum-scroll-item]');

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
            },
        );
    });

    document.querySelectorAll('[data-lum-scroll-reveal]').forEach((element) => {
        if (element.closest('[data-lum-scroll-stagger]') && element.hasAttribute('data-lum-scroll-item')) {
            return;
        }

        const travel = Number(element.dataset.lumScrollRevealY) || 48;
        const delay = Number(element.dataset.lumScrollRevealDelay) || 0;

        gsap.fromTo(
            element,
            { y: travel, opacity: 0 },
            {
                y: 0,
                opacity: 1,
                duration: REVEAL_DURATION,
                delay,
                ease: REVEAL_EASE,
                scrollTrigger: {
                    trigger: element,
                    start: 'top 88%',
                    once: true,
                    invalidateOnRefresh: true,
                },
            },
        );
    });
}
