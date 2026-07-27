import gsap from 'gsap';

const INTRO_EASE = 'power3.out';
const INTRO_DURATION = 1.15;
const INTRO_STAGGER = 0.18;
const INTRO_DELAY = 0.22;
const CARDS_AFTER_INTRO_PAUSE = 0.03;

const REVEAL_DURATION = 0.9;
const REVEAL_STAGGER = 0.12;
const EASE = 'power3.out';

function isSectionVisible(section) {
    return window.getComputedStyle(section).display !== 'none';
}

function getCardTarget(post) {
    return post.querySelector('[data-lum-blog-card]') || post;
}

function getIntroItems(section) {
    const root = section.querySelector('[data-lum-blog-intro]');

    if (! root) {
        return [];
    }

    return [...root.querySelectorAll('[data-lum-stay-intro-item]')]
        .filter((item) => ! item.closest('[data-lum-hero-title]'))
        .sort((left, right) => (
            Number(left.dataset.lumStayIntroOrder || 0) - Number(right.dataset.lumStayIntroOrder || 0)
        ));
}

function primeIntroItems(items) {
    gsap.set(items, { y: 56, opacity: 0 });
}

function primePosts(posts) {
    posts.forEach((post) => {
        gsap.set(getCardTarget(post), { autoAlpha: 0, y: 44, scale: 0.985 });
    });
}

function revealPosts(posts) {
    if (! posts.length) {
        return;
    }

    const targets = posts.map(getCardTarget);

    gsap.killTweensOf(targets);
    gsap.fromTo(
        targets,
        { autoAlpha: 0, y: 44, scale: 0.985 },
        {
            autoAlpha: 1,
            y: 0,
            scale: 1,
            duration: REVEAL_DURATION,
            ease: EASE,
            stagger: REVEAL_STAGGER,
            onComplete: () => {
                gsap.set(targets, { clearProps: 'transform,opacity,visibility' });
            },
        },
    );
}

function animateIntro(section, onComplete) {
    const items = getIntroItems(section);

    if (! items.length) {
        onComplete?.();

        return;
    }

    gsap.killTweensOf(items);
    gsap.fromTo(
        items,
        { y: 56, opacity: 0 },
        {
            y: 0,
            opacity: 1,
            duration: INTRO_DURATION,
            ease: INTRO_EASE,
            stagger: INTRO_STAGGER,
            delay: INTRO_DELAY,
            onComplete: () => {
                gsap.set(items, { clearProps: 'y,opacity' });
                onComplete?.();
            },
        },
    );
}

function runIntroThenCards(section, posts) {
    primeIntroItems(getIntroItems(section));
    primePosts(posts);

    animateIntro(section, () => {
        gsap.delayedCall(CARDS_AFTER_INTRO_PAUSE, () => {
            revealPosts(posts);
        });
    });
}

function playSectionSequence(section, posts, reducedMotion) {
    if (section.dataset.lumBlogSequenceDone === 'true') {
        return;
    }

    if (! isSectionVisible(section)) {
        return;
    }

    section.dataset.lumBlogSequenceDone = 'true';

    if (reducedMotion) {
        getIntroItems(section).forEach((item) => {
            gsap.set(item, { clearProps: 'y,opacity' });
        });
        posts.forEach((post) => {
            gsap.set(getCardTarget(post), { clearProps: 'transform,opacity,visibility' });
        });

        return;
    }

    runIntroThenCards(section, posts);
}

export function initBlogTabs() {
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const sections = [...document.querySelectorAll('[data-lum-blog-section]')];
    const sectionData = [];

    sections.forEach((section) => {
        const posts = [...section.querySelectorAll('[data-lum-blog-post]')];
        sectionData.push({ section, posts });
    });

    const playVisibleSequences = () => {
        sectionData.forEach(({ section, posts }) => {
            playSectionSequence(section, posts, reducedMotion);
        });
    };

    playVisibleSequences();

    document.addEventListener('lum:layout-change', () => {
        playVisibleSequences();
    });
}
