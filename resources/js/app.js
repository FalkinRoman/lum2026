import { initLocationCards } from './location-cards';
import { initBurgerMenu } from './burger-menu';

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
        menuScaled.style.transform = `scale(${scale})`;
    }
}

function initLanguageSwitcher() {
    const panel = document.getElementById('lum-lang-panel');
    const toggle = document.querySelector('[data-lum-lang-toggle]');

    if (! panel || ! toggle) {
        return;
    }

    const openPanel = () => {
        panel.classList.remove('hidden');
        panel.classList.remove('opacity-0');
        panel.classList.add('pointer-events-auto');
        panel.setAttribute('aria-hidden', 'false');
        toggle.setAttribute('aria-expanded', 'true');
    };

    const closePanel = () => {
        panel.classList.add('hidden');
        panel.classList.add('opacity-0');
        panel.classList.remove('pointer-events-auto');
        panel.setAttribute('aria-hidden', 'true');
        toggle.setAttribute('aria-expanded', 'false');
    };

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
            closePanel();
        });
    });

    document.addEventListener('click', (event) => {
        if (panel.classList.contains('hidden')) {
            return;
        }

        if (panel.contains(event.target) || toggle.contains(event.target)) {
            return;
        }

        closePanel();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closePanel();
        }
    });
}

scaleLumPage();
initLanguageSwitcher();
initLocationCards();
initBurgerMenu();
window.addEventListener('resize', scaleLumPage);
