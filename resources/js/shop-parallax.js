import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function refreshScrollTriggers() {
    ScrollTrigger.refresh();
}

export function initShopParallax() {
    const section = document.querySelector('[data-lum-shop-parallax]');
    const bg = section?.querySelector('[data-lum-shop-parallax-bg]');

    if (! section || ! bg) {
        return;
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    gsap.fromTo(
        bg,
        { yPercent: -10 },
        {
            yPercent: 10,
            ease: 'none',
            scrollTrigger: {
                trigger: section,
                start: 'top bottom',
                end: 'bottom top',
                scrub: 0.85,
                invalidateOnRefresh: true,
            },
        },
    );
}
