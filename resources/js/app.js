import { initLocationCards } from './location-cards';
import { initBurgerMenu, syncBurgerMenuDrawer } from './burger-menu';
import { initStickyHeader, syncStickyHeader } from './sticky-header';
import { initBlogSlider } from './blog-slider';
import { initHeroTitle } from './hero-title';
import { initShopParallax, refreshScrollTriggers } from './shop-parallax';

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
    page.style.transform = `scale(${scale})`;
    page.style.transformOrigin = 'top left';

    const pageHeight = page.offsetHeight;
    page.style.marginBottom = `${pageHeight * (scale - 1)}px`;
    viewport.style.height = `${pageHeight * scale}px`;

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

    refreshScrollTriggers();
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

scaleLumPage();
initLanguageSwitcher();
initLocationCards();
initBlogSlider();
initBurgerMenu();
initStickyHeader();
initHeroTitle();
initShopParallax();
window.addEventListener('resize', scaleLumPage);
