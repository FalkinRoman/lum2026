import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

gsap.registerPlugin(ScrollTrigger);

let lenis = null;

/**
 * Damai scroll feel: Lenis + ScrollTrigger
 * https://thedamai.com/assets/js/index.js — initLenis()
 */
export function initSmoothScroll() {
    if (lenis || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    lenis = new Lenis();

    lenis.on('scroll', ScrollTrigger.update);

    gsap.ticker.add((time) => {
        lenis?.raf(time * 1000);
    });

    gsap.ticker.lagSmoothing(0);
}

export function getLenis() {
    return lenis;
}

export function smoothScrollTo(target, options = {}) {
    if (lenis) {
        lenis.scrollTo(target, {
            duration: options.duration ?? 1.2,
            ...options,
        });

        return;
    }

    const top = typeof target === 'number' ? target : 0;

    window.scrollTo({ top, behavior: options.immediate ? 'auto' : 'smooth' });
}
