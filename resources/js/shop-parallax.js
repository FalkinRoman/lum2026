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
 * Scrub starts only after bg decode so heavy CMS photos don't hitch Lenis.
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

    const strength = 2;
    const travel = strength * 10;

    const arm = () => {
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
                },
            },
        );

        return () => {
            tween.scrollTrigger?.kill();
            tween.kill();
        };
    };

    if (bg instanceof HTMLImageElement) {
        const ready = () => {
            if (typeof bg.decode === 'function') {
                return bg.decode().catch(() => undefined);
            }

            return Promise.resolve();
        };

        if (bg.complete && bg.naturalWidth > 0) {
            ready().then(arm);

            return;
        }

        bg.addEventListener('load', () => {
            ready().then(arm);
        }, { once: true });

        return;
    }

    arm();
}
