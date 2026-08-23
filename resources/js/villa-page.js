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
    // Skip media-heavy villa panels that opt out of hide-until-reveal.
    if (node.closest('[data-lum-gallery], [data-lum-facilities]')) {
        return;
    }

    gsap.fromTo(
        node,
        { y: 20, opacity: 0 },
        {
            y: 0,
            opacity: 1,
            duration: 0.9,
            ease: INTRO_EASE,
            force3D: true,
            scrollTrigger: {
                trigger: node,
                start: 'top 92%',
                once: true,
            },
            onComplete: () => {
                gsap.set(node, { clearProps: 'transform,opacity' });
            },
        },
    );
}

function initVillaIntro(root) {
    const items = [...root.querySelectorAll('[data-lum-stay-intro-item]')]
        .filter((item) => ! item.closest('[data-lum-hero-title]'))
        .filter(isVisibleElement)
        .sort((left, right) => (
            Number(left.dataset.lumStayIntroOrder || 0) - Number(right.dataset.lumStayIntroOrder || 0)
        ));

    if (! items.length) {
        return;
    }

    const staggerAttr = Number(root.dataset.lumIntroStagger);
    const stagger = Number.isFinite(staggerAttr) && staggerAttr >= 0 ? staggerAttr : INTRO_STAGGER;

    // Avoid GSAP `y` on nodes with Tailwind translate-* (overwrites CSS transform → layout jump).
    const hasCssTranslate = (el) => /(?:^|\s)-?translate-/.test(el.className);
    const marginItems = items.filter(hasCssTranslate);
    const transformItems = items.filter((el) => ! hasCssTranslate(el));

    const play = (targets, useMargin) => {
        if (! targets.length) {
            return;
        }

        gsap.fromTo(
            targets,
            useMargin ? { marginTop: 56, opacity: 0 } : { y: 56, opacity: 0 },
            {
                ...(useMargin ? { marginTop: 0 } : { y: 0 }),
                opacity: 1,
                duration: INTRO_DURATION,
                ease: INTRO_EASE,
                stagger,
                delay: 0.22,
                onComplete: () => {
                    gsap.set(targets, { clearProps: useMargin ? 'marginTop,opacity' : 'y,opacity' });
                },
            },
        );
    };

    play(transformItems, false);
    play(marginItems, true);
}

function whenImageReady(img) {
    if (! (img instanceof HTMLImageElement)) {
        return Promise.resolve();
    }

    const loaded = () => {
        if (typeof img.decode === 'function') {
            return img.decode().catch(() => undefined);
        }

        return Promise.resolve();
    };

    if (img.complete && img.naturalWidth > 0) {
        return loaded();
    }

    return new Promise((resolve) => {
        img.addEventListener('load', () => resolve(loaded()), { once: true });
        img.addEventListener('error', () => resolve(), { once: true });
    }).then((result) => result);
}

function initVillaCard(card, index) {
    const play = () => {
        gsap.fromTo(
            card,
            { opacity: 0 },
            {
                opacity: 1,
                duration: 0.7,
                delay: index * 0.05,
                ease: INTRO_EASE,
                scrollTrigger: {
                    trigger: card,
                    start: 'top 90%',
                    once: true,
                },
                onComplete: () => {
                    gsap.set(card, { clearProps: 'opacity' });
                },
            },
        );
    };

    // Never fade an undecoded bitmap — pause→pop.
    if (card instanceof HTMLImageElement) {
        whenImageReady(card).then(play);

        return;
    }

    const img = card.querySelector('img');

    if (img instanceof HTMLImageElement) {
        whenImageReady(img).then(play);

        return;
    }

    play();
}

/** Prefetch warm targets into HTTP cache before lazy imgs hit the viewport. */
function warmMediaPanels() {
    if (typeof IntersectionObserver !== 'function') {
        return;
    }

    const warmed = new Set();

    const warmPanel = (panel) => {
        panel.querySelectorAll('[data-lum-warm-img], [data-lum-facilities-img]').forEach((img) => {
            if (! (img instanceof HTMLImageElement)) {
                return;
            }

            const url = img.currentSrc || img.src;

            if (! url || warmed.has(url)) {
                return;
            }

            warmed.add(url);
            const probe = new Image();
            probe.decoding = 'async';
            probe.src = url;
        });
    };

    document.querySelectorAll('[data-lum-gallery], [data-lum-facilities]').forEach((panel) => {
        const io = new IntersectionObserver(
            (entries) => {
                if (! entries.some((entry) => entry.isIntersecting)) {
                    return;
                }

                io.disconnect();
                warmPanel(panel);
            },
            { rootMargin: '140% 0px' },
        );

        io.observe(panel);
    });
}

export function initVillaPage() {
    warmMediaPanels();

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    document.querySelectorAll('[data-lum-villa-intro]').forEach((root) => {
        if (root.closest('[data-lum-blog-section]')) {
            return;
        }

        if (isVisibleElement(root)) {
            initVillaIntro(root);
        }
    });

    // Polaroids: no opacity:0 / transform thrash — media stays visible; warm handles decode.

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
