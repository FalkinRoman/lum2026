import { initLocationCards } from './location-cards';
import { initBurgerMenu, syncBurgerMenuDrawer } from './burger-menu';
import { initStickyHeader, syncStickyHeader } from './sticky-header';
import { initBlogSlider } from './blog-slider';
import { initHeroTitle } from './hero-title';
import { initHeroVideo } from './hero-video';
import { initShopParallax, refreshScrollTriggers } from './shop-parallax';
import { initScrollReveal } from './scroll-reveal';
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

function getLumScale() {
    const { width } = LUM_BREAKPOINTS[getLumBreakpoint()];

    return window.innerWidth / width;
}

function syncLumBreakpointAttribute(breakpoint) {
    document.documentElement.dataset.lumBp = breakpoint;
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
    page.style.zoom = 'normal';
    page.style.transform = `scale(${scale})`;
    page.style.transformOrigin = 'top left';
    page.style.marginBottom = '0';

    const syncViewportHeight = () => {
        const visualHeight = Math.ceil(page.getBoundingClientRect().height);

        if (visualHeight > 0) {
            viewport.style.height = `${visualHeight}px`;
        }
    };

    syncViewportHeight();
    requestAnimationFrame(syncViewportHeight);

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

    document.dispatchEvent(new CustomEvent('lum:layout-change'));
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
        refreshScrollTriggers();
    }, { once: true });

    document.addEventListener('lum:layout-change', () => {
        refreshScrollTriggers();
    });
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

        const anchor = {
            parent: panel.parentElement,
            next: panel.nextSibling,
        };
        const isBurgerPanel = Boolean(toggle.closest('.lum-burger-menu'));
        const designWidth = 320;

        const positionFixedPanel = () => {
            if (! isBurgerPanel || ! panel.classList.contains('lum-lang-panel--fixed')) {
                return;
            }

            const host = toggle.parentElement ?? toggle;
            const rect = host.getBoundingClientRect();
            const scale = getLumScale();
            const visualWidth = designWidth * scale;

            panel.style.width = `${designWidth}px`;
            panel.style.transformOrigin = 'top left';
            panel.style.transform = `scale(${scale})`;
            panel.style.top = `${rect.bottom + 8}px`;
            panel.style.left = `${Math.max(8, rect.right - visualWidth)}px`;
        };

        const mountFixedPanel = () => {
            if (! isBurgerPanel) {
                return;
            }

            panel.classList.add('lum-lang-panel--fixed');
            document.body.appendChild(panel);
            positionFixedPanel();
        };

        const restorePanelMount = () => {
            panel.classList.remove('lum-lang-panel--fixed');
            panel.style.removeProperty('top');
            panel.style.removeProperty('left');
            panel.style.removeProperty('width');
            panel.style.removeProperty('transform');
            panel.style.removeProperty('transform-origin');

            if (! anchor.parent || panel.parentElement === anchor.parent) {
                return;
            }

            if (anchor.next && anchor.next.parentElement === anchor.parent) {
                anchor.parent.insertBefore(panel, anchor.next);
                return;
            }

            anchor.parent.appendChild(panel);
        };

        const closePanel = () => {
            panel.classList.add('hidden');
            panel.classList.add('opacity-0');
            panel.classList.remove('pointer-events-auto');
            panel.setAttribute('hidden', '');
            panel.setAttribute('aria-hidden', 'true');
            toggle.setAttribute('aria-expanded', 'false');
            restorePanelMount();
        };

        const openPanel = () => {
            pairs.forEach(({ panel: otherPanel, toggle: otherToggle, close }) => {
                if (otherPanel !== panel) {
                    close();
                }
            });

            mountFixedPanel();
            panel.classList.remove('hidden');
            panel.classList.remove('opacity-0');
            panel.classList.add('pointer-events-auto');
            panel.removeAttribute('hidden');
            panel.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            positionFixedPanel();
        };

        pairs.push({ panel, toggle, close: closePanel, position: positionFixedPanel });

        toggle.addEventListener('click', (event) => {
            event.preventDefault();
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
    });

    const repositionOpenPanels = () => {
        pairs.forEach(({ panel, position }) => {
            if (! panel.classList.contains('hidden') && typeof position === 'function') {
                position();
            }
        });
    };

    window.addEventListener('resize', repositionOpenPanels);
    window.addEventListener('scroll', repositionOpenPanels, { passive: true });
    document.addEventListener('lum:layout-change', repositionOpenPanels);

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

    document.addEventListener('lum:close-lang-panels', () => {
        pairs.forEach(({ close }) => close());
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
    initScrollReveal();

    requestAnimationFrame(() => {
        refreshScrollTriggers();
        revealLumApp();
    });
});
