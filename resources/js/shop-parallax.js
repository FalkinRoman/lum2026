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

    const isTouchViewport = window.matchMedia('(max-width: 1023px), (pointer: coarse)').matches;
    const isInAppBrowser = /Telegram|Instagram|FBAN|FBAV|Twitter|Line\//i.test(navigator.userAgent);

    if (isTouchViewport || isInAppBrowser) {
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
