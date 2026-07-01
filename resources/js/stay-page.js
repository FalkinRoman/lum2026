import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const EASE = 'power3.out';
const EASE_SOFT = 'power2.out';

function isVisibleElement(element) {
    return element.offsetParent !== null || element.getClientRects().length > 0;
}

function isCenteredElement(element) {
    return element.classList.contains('-translate-x-1/2');
}

function imageMotionFrom(image) {
    return isCenteredElement(image)
        ? { marginTop: 36, opacity: 0 }
        : { y: 36, opacity: 0 };
}

function imageMotionTo(image) {
    return isCenteredElement(image)
        ? { marginTop: 0, opacity: 1 }
        : { y: 0, opacity: 1 };
}

function clearImageMotion(image) {
    gsap.set(image, {
        clearProps: isCenteredElement(image) ? 'marginTop,opacity' : 'transform,opacity',
    });
}

function getFirstRowCount(root) {
    if (root.classList.contains('desk:block')) {
        return 2;
    }

    if (root.classList.contains('tab:block')) {
        return 2;
    }

    return 1;
}

function findStayPropertyCopy(image) {
    const index = image.dataset.lumStayProperty;
    const breakpointRoot = image.closest('[data-lum-stay-intro]');

    if (breakpointRoot) {
        return breakpointRoot.querySelector(`[data-lum-stay-property-copy="${index}"]`);
    }

    return document.querySelector(`[data-lum-stay-property-copy="${index}"]`);
}

function initStayHeroIntro(root) {
    const hero = root.querySelector('[data-lum-stay-hero]');

    if (! hero) {
        return;
    }

    const dot = hero.querySelector('[data-lum-stay-intro-item="dot"]');
    const title = hero.querySelector('[data-lum-stay-intro-item="title"]');
    const eyebrow = hero.querySelector('[data-lum-stay-intro-item="eyebrow"]');
    const arrow = hero.querySelector('[data-lum-stay-intro-item="arrow"]');
    const heroItems = [dot, title, eyebrow, arrow].filter(Boolean);
    const firstRowCount = getFirstRowCount(root);
    const images = [...root.querySelectorAll('[data-lum-stay-property-image]')].slice(0, firstRowCount);
    const copies = images.map((image) => findStayPropertyCopy(image)).filter(Boolean);

    gsap.set(heroItems, { y: 28, opacity: 0 });

    images.forEach((image) => {
        gsap.set(image, imageMotionFrom(image));
    });

    copies.forEach((copy) => {
        gsap.set(copy.children, { y: 22, opacity: 0 });
    });

    const timeline = gsap.timeline({
        delay: 0.1,
        defaults: { ease: EASE },
        onComplete: () => {
            gsap.set(heroItems, { clearProps: 'transform,opacity' });

            images.forEach((image) => {
                clearImageMotion(image);
            });

            copies.forEach((copy) => {
                gsap.set(copy.children, { clearProps: 'transform,opacity' });
            });
        },
    });

    if (dot) {
        timeline.to(dot, { y: 0, opacity: 1, duration: 0.6 });
    }

    if (title) {
        timeline.to(title, { y: 0, opacity: 1, duration: 0.95 }, dot ? '-=0.38' : 0);
    }

    if (eyebrow) {
        timeline.to(eyebrow, { y: 0, opacity: 1, duration: 0.75 }, '-=0.58');
    }

    if (arrow) {
        timeline.to(arrow, {
            y: 0,
            opacity: 1,
            duration: 0.55,
            ease: EASE_SOFT,
            onComplete: () => {
                arrow.classList.add('is-visible');
            },
        }, '-=0.45');
    }

    images.forEach((image, index) => {
        timeline.to(image, {
            ...imageMotionTo(image),
            duration: 0.88,
            ease: EASE_SOFT,
        }, index === 0 ? '-=0.12' : `-=${0.72 - index * 0.06}`);
    });

    copies.forEach((copy, index) => {
        timeline.to(copy.children, {
            y: 0,
            opacity: 1,
            duration: 0.78,
            ease: EASE_SOFT,
            stagger: 0.07,
        }, `-=${0.55 - index * 0.04}`);
    });
}

function revealPropertyPair(image, copy, index) {
    const direction = index % 2 === 0 ? -18 : 18;
    const centered = isCenteredElement(image);

    gsap.fromTo(
        image,
        centered ? { marginTop: 32, opacity: 0 } : { y: 32, opacity: 0 },
        {
            ...(centered ? { marginTop: 0 } : { y: 0 }),
            opacity: 1,
            duration: 0.9,
            ease: EASE_SOFT,
            scrollTrigger: {
                trigger: image,
                start: 'top 90%',
                once: true,
                invalidateOnRefresh: true,
            },
            onComplete: () => {
                clearImageMotion(image);
            },
        },
    );

    if (! copy) {
        return;
    }

    const copyItems = [...copy.children];
    const copyCentered = isCenteredElement(copy);

    gsap.fromTo(
        copyItems,
        { y: 24, opacity: 0, x: copyCentered ? 0 : direction },
        {
            y: 0,
            x: 0,
            opacity: 1,
            duration: 0.8,
            ease: EASE_SOFT,
            stagger: 0.08,
            delay: 0.08,
            scrollTrigger: {
                trigger: copy,
                start: 'top 90%',
                once: true,
                invalidateOnRefresh: true,
            },
            onComplete: () => {
                gsap.set(copyItems, { clearProps: 'transform,opacity' });
            },
        },
    );
}

function initStayWellness(section) {
    const hero = section.querySelector('[data-lum-stay-wellness-hero]');
    const oval = section.querySelector('[data-lum-stay-wellness-oval]');

    if (hero) {
        const heroImg = hero.querySelector('img');

        if (heroImg) {
            gsap.fromTo(
                heroImg,
                { scale: 1.04 },
                {
                    scale: 1.08,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: hero,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: 1.35,
                        invalidateOnRefresh: true,
                    },
                },
            );
        }
    }

    if (oval) {
        gsap.fromTo(
            oval,
            { scale: 0.9, opacity: 0 },
            {
                scale: 1,
                opacity: 1,
                duration: 1,
                ease: EASE,
                scrollTrigger: {
                    trigger: oval,
                    start: 'top 92%',
                    once: true,
                    invalidateOnRefresh: true,
                },
            },
        );
    }
}

export function initStayPage() {
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (! document.querySelector('[data-lum-stay-page]')) {
        return;
    }

    if (reducedMotion) {
        document.querySelectorAll('.lum-stay-arrow').forEach((arrow) => {
            arrow.classList.add('is-visible');
            arrow.style.opacity = '1';
        });

        return;
    }

    document.querySelectorAll('[data-lum-stay-intro]').forEach((root) => {
        if (isVisibleElement(root)) {
            initStayHeroIntro(root);
        }
    });

    document.querySelectorAll('[data-lum-stay-property-image]').forEach((image) => {
        if (! isVisibleElement(image)) {
            return;
        }

        const root = image.closest('[data-lum-stay-intro]');
        const index = Number(image.dataset.lumStayProperty || 0);

        if (! root || index < getFirstRowCount(root)) {
            return;
        }

        revealPropertyPair(image, findStayPropertyCopy(image), index);
    });

    document.querySelectorAll('[data-lum-stay-wellness]').forEach((section) => {
        if (isVisibleElement(section)) {
            initStayWellness(section);
        }
    });

    ScrollTrigger.refresh();
}
