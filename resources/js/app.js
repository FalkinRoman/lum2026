import { initLocationCards } from './location-cards';
import { initBurgerMenu, syncBurgerMenuDrawer } from './burger-menu';
import { initStickyHeader, syncStickyHeader } from './sticky-header';
import { initBlogSlider } from './blog-slider';
import { initHeroTitle } from './hero-title';
import { initHeroVideo } from './hero-video';
import { initShopParallax, refreshScrollTriggers } from './shop-parallax';
import { initFooter3dText } from './footer-3d-text';
import { initInteriorCarousel } from './interior-carousel';
import { initVillasCarousel } from './villas-carousel';

const LUM_VIEWPORT = {
    mobileMax: 430,   // телефоны в портрете, до iPhone Pro Max
    tabletMax: 1023,  // планшеты и landscape-телефоны
};

const LUM_BREAKPOINTS = {
    mobile: { width: 375 },
    tablet: { width: 960 },
    desktop: { width: 1920 },
};

function getLumBreakpoint() {
    const viewportWidth = window.innerWidth;

    if (viewportWidth <= LUM_VIEWPORT.mobileMax) {
        return 'mobile';
    }

    if (viewportWidth <= LUM_VIEWPORT.tabletMax) {
        return 'tablet';
    }

    return 'desktop';
}

function syncLumBreakpointAttribute(breakpoint) {
    document.documentElement.dataset.lumBp = breakpoint;
}

function supportsPageZoom() {
    return typeof CSS !== 'undefined' && CSS.supports('zoom', '1');
}

function scaleLumPage() {
    const viewport = document.querySelector('.lum-viewport');
    const page = document.querySelector('.lum-page');

    if (! viewport || ! page) {
        return;
    }

    const breakpoint = getLumBreakpoint();
    const { width } = LUM_BREAKPOINTS[breakpoint];
    const scale = window.innerWidth / width;

    syncLumBreakpointAttribute(breakpoint);
    page.dataset.lumBreakpoint = breakpoint;
    page.style.width = `${width}px`;
    viewport.style.removeProperty('height');
    viewport.style.removeProperty('min-height');

    if (supportsPageZoom()) {
        page.style.transform = 'none';
        page.style.transformOrigin = '';
        page.style.marginBottom = '0';
        page.style.zoom = String(scale);
    } else {
        page.style.zoom = 'normal';
        page.style.transform = `scale(${scale})`;
        page.style.transformOrigin = 'top left';

        const pageHeight = page.offsetHeight;
        page.style.marginBottom = `${pageHeight * (scale - 1)}px`;
    }

    const menuScaled = document.querySelector('.lum-burger-menu__scaled');

    if (menuScaled) {
        menuScaled.style.width = `${width}px`;
        menuScaled.style.transformOrigin = 'top left';
        menuScaled.style.transform = `scale(${scale})`;
        syncBurgerMenuDrawer();
    }

    const stickyScaled = document.querySelector('.lum-sticky-header__scaled');

    if (stickyScaled) {
        stickyScaled.style.width = `${width}px`;
        stickyScaled.style.transformOrigin = 'top left';
        stickyScaled.style.transform = `scale(${scale})`;
        syncStickyHeader();
    }
}

function debounce(fn, wait) {
    let timeoutId = null;

    return (...args) => {
        if (timeoutId !== null) {
            window.clearTimeout(timeoutId);
        }

        timeoutId = window.setTimeout(() => fn(...args), wait);
    };
}

let lastLayoutWidth = window.innerWidth;
let lastLayoutBreakpoint = getLumBreakpoint();

function applyLumLayout({ forceRefresh = false } = {}) {
    const width = window.innerWidth;
    const breakpoint = getLumBreakpoint();
    const layoutChanged = width !== lastLayoutWidth || breakpoint !== lastLayoutBreakpoint;

    scaleLumPage();

    if (layoutChanged || forceRefresh) {
        lastLayoutWidth = width;
        lastLayoutBreakpoint = breakpoint;
        refreshScrollTriggers();
    }
}

function initLumViewport() {
    const onViewportChange = debounce(() => {
        if (window.innerWidth === lastLayoutWidth) {
            return;
        }

        applyLumLayout();
    }, 120);

    window.addEventListener('resize', onViewportChange, { passive: true });

    if (window.visualViewport) {
        window.visualViewport.addEventListener('resize', onViewportChange, { passive: true });
    }

    const page = document.querySelector('.lum-page');

    if (page && typeof ResizeObserver !== 'undefined') {
        const syncPageHeight = debounce(() => {
            applyLumLayout();
        }, 60);

        const observer = new ResizeObserver(syncPageHeight);
        observer.observe(page);
    }

    window.addEventListener('load', () => {
        applyLumLayout({ forceRefresh: true });
    }, { once: true });
}

function revealLumApp() {
    document.documentElement.classList.remove('lum-is-loading');
}

function initLanguageSwitcher() {
    const toggles = document.querySelectorAll('[data-lum-lang-toggle]');

    if (! toggles.length) {
        return;
    }

    const pairs = [];

    toggles.forEach((toggle) => {
        const panelId = toggle.getAttribute('aria-controls');
        const panel = panelId ? document.getElementById(panelId) : null;

        if (! panel) {
            return;
        }

        const closePanel = () => {
            panel.classList.add('hidden');
            panel.classList.add('opacity-0');
            panel.classList.remove('pointer-events-auto');
            panel.setAttribute('hidden', '');
            panel.setAttribute('aria-hidden', 'true');
            toggle.setAttribute('aria-expanded', 'false');
        };

        const openPanel = () => {
            pairs.forEach(({ panel: otherPanel, toggle: otherToggle, close }) => {
                if (otherPanel !== panel) {
                    close();
                }
            });

            panel.classList.remove('hidden');
            panel.classList.remove('opacity-0');
            panel.classList.add('pointer-events-auto');
            panel.removeAttribute('hidden');
            panel.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
        };

        pairs.push({ panel, toggle, close: closePanel });

        toggle.addEventListener('click', (event) => {
            event.stopPropagation();

            if (panel.classList.contains('hidden')) {
                openPanel();
                return;
            }

            closePanel();
        });

        panel.querySelectorAll('[data-lum-lang-close]').forEach((button) => {
            button.addEventListener('click', (event) => {
                event.stopPropagation();
                closePanel();
            });
        });

        panel.querySelectorAll('[data-lum-lang-option]').forEach((button) => {
            button.addEventListener('click', (event) => {
                event.stopPropagation();

                const lang = button.getAttribute('data-lum-lang-option');
                const check = panel.querySelector('.lum-lang-panel__check');

                panel.querySelectorAll('[data-lum-lang-option]').forEach((option) => {
                    option.classList.remove('is-active');
                    option.removeAttribute('aria-current');
                });

                button.classList.add('is-active');
                button.setAttribute('aria-current', 'true');

                if (check && lang) {
                    const isDesktop = window.innerWidth >= 1024;
                    check.style.top = lang === 'ru'
                        ? (isDesktop ? '72px' : '71px')
                        : '110px';
                }

                closePanel();
            });
        });
    });

    document.addEventListener('click', (event) => {
        pairs.forEach(({ panel, toggle, close }) => {
            if (panel.classList.contains('hidden')) {
                return;
            }

            if (panel.contains(event.target) || toggle.contains(event.target)) {
                return;
            }

            close();
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') {
            return;
        }

        pairs.forEach(({ panel, close }) => {
            if (! panel.classList.contains('hidden')) {
                close();
            }
        });
    });
}

let backToTopAnimation = null;

function applyScrollTop(top) {
    window.scrollTo(0, top);
    document.documentElement.scrollTop = top;
    document.body.scrollTop = top;
}

function easeOutCubic(progress) {
    return 1 - (1 - progress) ** 3;
}

function scrollToPageTop() {
    const page = document.querySelector('.lum-page');
    const hero = page?.querySelector('section');
    const anchor = hero ?? page;

    const getTarget = () => {
        if (! anchor) {
            return 0;
        }

        return Math.max(0, window.scrollY + anchor.getBoundingClientRect().top);
    };

    const target = getTarget();
    const start = window.scrollY;

    if (backToTopAnimation) {
        cancelAnimationFrame(backToTopAnimation);
        backToTopAnimation = null;
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || Math.abs(target - start) < 1) {
        applyScrollTop(target);

        return;
    }

    const duration = Math.min(900, Math.max(450, Math.abs(target - start) * 0.5));
    const startTime = performance.now();

    const step = (now) => {
        const progress = Math.min((now - startTime) / duration, 1);

        applyScrollTop(start + (target - start) * easeOutCubic(progress));

        if (progress < 1) {
            backToTopAnimation = requestAnimationFrame(step);

            return;
        }

        backToTopAnimation = null;
        applyScrollTop(getTarget());
    };

    backToTopAnimation = requestAnimationFrame(step);
}

function initBackToTop() {
    const buttons = document.querySelectorAll('[data-lum-back-to-top]');

    if (! buttons.length) {
        return;
    }

    buttons.forEach((button) => {
        button.addEventListener('click', scrollToPageTop);
    });
}

applyLumLayout({ forceRefresh: true });
initLanguageSwitcher();
initBackToTop();
initLocationCards();
initBlogSlider();
initBurgerMenu();
initStickyHeader();
initHeroTitle();
initHeroVideo();
initShopParallax();
initFooter3dText();
initInteriorCarousel();
initVillasCarousel();
initLumViewport();

requestAnimationFrame(() => {
    applyLumLayout();

    requestAnimationFrame(revealLumApp);
});
