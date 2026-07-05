import gsap from 'gsap';

const EASE = 'power3.out';
const INTRO_EASE = 'power3.out';
const INTRO_DURATION = 1.15;
const INTRO_STAGGER = 0.18;
const INTRO_DELAY = 0.22;
const CARDS_AFTER_INTRO_PAUSE = 0.03;

const REVEAL_DURATION = 0.9;
const REVEAL_STAGGER = 0.12;
const HIDE_DURATION = 0.3;

function syncBlogLayout() {
    document.dispatchEvent(new CustomEvent('lum:layout-change'));
}

function isSectionVisible(section) {
    return window.getComputedStyle(section).display !== 'none';
}

function shouldShowPost(post, category) {
    const categories = (post.dataset.categories || '').split(' ').filter(Boolean);

    return category === 'all' || categories.includes(category);
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

function revealPosts(posts, { stagger = true } = {}) {
    if (! posts.length) {
        return;
    }

    const targets = posts.map(getCardTarget);

    posts.forEach((post) => {
        post.hidden = false;
    });

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
            stagger: stagger ? REVEAL_STAGGER : 0,
            onComplete: () => {
                gsap.set(targets, { clearProps: 'transform,opacity,visibility' });
            },
        },
    );
}

function hidePosts(posts, onComplete) {
    if (! posts.length) {
        onComplete?.();

        return;
    }

    const targets = posts.map(getCardTarget);

    gsap.killTweensOf(targets);
    gsap.to(targets, {
        autoAlpha: 0,
        y: 28,
        scale: 0.985,
        duration: HIDE_DURATION,
        ease: 'power2.in',
        stagger: 0.06,
        onComplete: () => {
            posts.forEach((post) => {
                post.hidden = true;
            });
            gsap.set(targets, { clearProps: 'transform,opacity,visibility' });
            onComplete?.();
        },
    });
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
    const visiblePosts = posts.filter((post) => ! post.hidden);

    primeIntroItems(getIntroItems(section));
    primePosts(visiblePosts);

    animateIntro(section, () => {
        gsap.delayedCall(CARDS_AFTER_INTRO_PAUSE, () => {
            revealPosts(visiblePosts);
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
            post.hidden = ! shouldShowPost(post, 'all');
            gsap.set(getCardTarget(post), { clearProps: 'transform,opacity,visibility' });
        });

        return;
    }

    runIntroThenCards(section, posts);
}

function setupBlogSection(section, reducedMotion) {
    const tabsRoot = section.querySelector('[data-lum-blog-tabs]');

    if (! tabsRoot) {
        return;
    }

    const tabs = [...tabsRoot.querySelectorAll('[data-lum-blog-tab]')];
    const posts = [...section.querySelectorAll('[data-lum-blog-post]')];

    if (! tabs.length || ! posts.length) {
        return;
    }

    const setActive = (activeTab) => {
        const category = activeTab.dataset.category || 'all';

        tabs.forEach((tab) => {
            const isActive = tab === activeTab;

            tab.classList.toggle('lum-tab--active', isActive);
            tab.classList.toggle('lum-tab--inactive', ! isActive);

            const label = tab.textContent?.replace(/^✓/, '') ?? '';
            tab.textContent = isActive ? `✓${label}` : label;
        });

        if (reducedMotion) {
            posts.forEach((post) => {
                post.hidden = ! shouldShowPost(post, category);
            });
            syncBlogLayout();

            return;
        }

        const toHide = posts.filter((post) => ! post.hidden && ! shouldShowPost(post, category));
        const toShow = posts.filter((post) => post.hidden && shouldShowPost(post, category));

        const finishReveal = () => {
            revealPosts(toShow, { stagger: true });
            syncBlogLayout();
        };

        if (toHide.length) {
            hidePosts(toHide, finishReveal);
        } else {
            finishReveal();
        }
    };

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => setActive(tab));
    });

    return { posts };
}

export function initBlogTabs() {
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const sections = [...document.querySelectorAll('[data-lum-blog-section]')];
    const sectionData = [];

    sections.forEach((section) => {
        const data = setupBlogSection(section, reducedMotion);

        if (data) {
            sectionData.push({ section, posts: data.posts });
        }
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
