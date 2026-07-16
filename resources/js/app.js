import { initLocationCards } from './location-cards';
import { initBurgerMenu, syncBurgerMenuDrawer } from './burger-menu';
import { initStickyHeader, syncStickyHeader } from './sticky-header';
import { initBlogSlider } from './blog-slider';
import { initBlogTabs } from './blog-tabs';
import { initHeroTitle } from './hero-title';
import { initHeroVideo } from './hero-video';
import { initShopParallax, refreshScrollTriggers } from './shop-parallax';
import { initSmoothScroll, getLenis } from './smooth-scroll';
import { initShopPage } from './shop-page';
import { initScrollReveal } from './scroll-reveal';
import { initStayPage } from './stay-page';
import { initVillaPage } from './villa-page';
import { initFooter3dText } from './footer-3d-text';
import { initNavLinks } from './nav-links';
import { initRestaurantMenu } from './restaurant-menu';
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

function initMobileZoomGuard() {
    if (! window.matchMedia('(pointer: coarse)').matches) {
        return;
    }

    ['gesturestart', 'gesturechange', 'gestureend'].forEach((eventName) => {
        document.addEventListener(eventName, (event) => {
            event.preventDefault();
        }, { passive: false });
    });
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
    const canHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    const closeDelayMs = 140;
    const animMs = 320;

    toggles.forEach((toggle) => {
        const panelId = toggle.getAttribute('aria-controls');
        const panel = panelId ? document.getElementById(panelId) : null;

        if (! panel) {
            return;
        }

        const host = toggle.parentElement ?? toggle;
        const anchor = {
            parent: panel.parentElement,
            next: panel.nextSibling,
        };
        const isBurgerPanel = Boolean(toggle.closest('.lum-burger-menu'));
        const isStickyPanel = Boolean(toggle.closest('.lum-sticky-header'));
        const useFixedPanel = isBurgerPanel || isStickyPanel;
        const designWidth = 320;
        let closeTimer = null;
        let closeAnimTimer = null;
        let isOpen = false;

        const positionFixedPanel = () => {
            if (! useFixedPanel || ! panel.classList.contains('lum-lang-panel--fixed')) {
                return;
            }

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
            if (! useFixedPanel) {
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

        const finishClose = () => {
            panel.classList.remove('is-open');
            panel.classList.add('pointer-events-none');
            panel.setAttribute('hidden', '');
            panel.setAttribute('aria-hidden', 'true');
            toggle.setAttribute('aria-expanded', 'false');
            restorePanelMount();
            isOpen = false;
        };

        const closePanel = ({ immediate = false } = {}) => {
            clearTimeout(closeTimer);
            clearTimeout(closeAnimTimer);

            if (! isOpen && panel.hasAttribute('hidden')) {
                return;
            }

            panel.classList.remove('is-open');
            panel.classList.add('pointer-events-none');
            toggle.setAttribute('aria-expanded', 'false');

            if (immediate) {
                finishClose();
                return;
            }

            closeAnimTimer = window.setTimeout(finishClose, animMs);
        };

        const openPanel = () => {
            clearTimeout(closeTimer);
            clearTimeout(closeAnimTimer);

            pairs.forEach(({ panel: otherPanel, close }) => {
                if (otherPanel !== panel) {
                    close({ immediate: true });
                }
            });

            mountFixedPanel();
            panel.removeAttribute('hidden');
            panel.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            positionFixedPanel();

            requestAnimationFrame(() => {
                panel.classList.add('is-open');
                panel.classList.remove('pointer-events-none');
            });

            isOpen = true;
        };

        const scheduleClose = () => {
            clearTimeout(closeTimer);
            closeTimer = window.setTimeout(() => closePanel(), closeDelayMs);
        };

        const cancelClose = () => {
            clearTimeout(closeTimer);
        };

        pairs.push({ panel, toggle, host, close: closePanel, position: positionFixedPanel, isOpen: () => isOpen });

        if (canHover) {
            host.addEventListener('mouseenter', () => {
                cancelClose();
                openPanel();
            });
            host.addEventListener('mouseleave', scheduleClose);
            panel.addEventListener('mouseenter', cancelClose);
            panel.addEventListener('mouseleave', scheduleClose);
        }

        toggle.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();

            if (canHover) {
                return;
            }

            if (isOpen) {
                closePanel();
                return;
            }

            openPanel();
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
            if (panel.classList.contains('is-open') && typeof position === 'function') {
                position();
            }
        });
    };

    window.addEventListener('resize', repositionOpenPanels);
    window.addEventListener('scroll', repositionOpenPanels, { passive: true });
    document.addEventListener('lum:layout-change', repositionOpenPanels);

    document.addEventListener('click', (event) => {
        pairs.forEach(({ panel, toggle, host, close }) => {
            if (! panel.classList.contains('is-open')) {
                return;
            }

            if (panel.contains(event.target) || toggle.contains(event.target) || host.contains(event.target)) {
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
            if (panel.classList.contains('is-open')) {
                close();
            }
        });
    });

    document.addEventListener('lum:close-lang-panels', () => {
        pairs.forEach(({ close }) => close({ immediate: true }));
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
    const lenis = getLenis();

    if (backToTopAnimation) {
        cancelAnimationFrame(backToTopAnimation);
        backToTopAnimation = null;
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || Math.abs(target - start) < 1) {
        if (lenis) {
            lenis.scrollTo(target, { immediate: true });
        } else {
            applyScrollTop(target);
        }

        return;
    }

    if (lenis) {
        lenis.scrollTo(target, { duration: 1.2 });

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
initSmoothScroll();
initMobileZoomGuard();
initLanguageSwitcher();
initBackToTop();
initLocationCards();
initBlogSlider();
initBurgerMenu();
initStickyHeader();
initHeroTitle();
initHeroVideo();
initShopParallax();
initShopPage();
initFooter3dText();
initNavLinks();
initInteriorCarousel();
initVillasCarousel();
initLumViewport();

requestAnimationFrame(() => {
    applyLumLayout();
    initScrollReveal();
    initStayPage();
    initVillaPage();
    initRestaurantMenu();

    requestAnimationFrame(() => {
        applyLumLayout({ forceRefresh: true });
        refreshScrollTriggers();
        revealLumApp();
        initBlogTabs();
    });
});
