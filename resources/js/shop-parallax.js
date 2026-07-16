import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function refreshScrollTriggers() {
    ScrollTrigger.refresh();
}

/**
 * Shop bg parallax.
 * Damai formula: strength * 10 = yPercent travel each way.
 * We push strength ~2 (±20%) — after lum-page scale ±10% was almost invisible.
 */
export function initShopParallax() {
    const section = document.querySelector('[data-lum-shop-parallax]');
    const bg = section?.querySelector('[data-lum-shop-parallax-bg]');

    if (! section || ! bg) {
        return;
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const strength = 2; // Damai default 1; boosted for scaled Figma layout
    const travel = strength * 10;

    const tween = gsap.fromTo(
        bg,
        { yPercent: -travel, rotate: 0.001 },
        {
            yPercent: travel,
            ease: 'none',
            scrollTrigger: {
                trigger: section,
                start: 'top bottom',
                end: 'bottom top',
                scrub: 0.65,
                invalidateOnRefresh: true,
            },
        },
    );

    return () => {
        tween.scrollTrigger?.kill();
        tween.kill();
    };
}
