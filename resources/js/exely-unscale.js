/**
 * Exely search iframe ломает hit-testing под CSS transform:scale на .lum-page.
 * Booking решает это через data-lum-no-scale. Villa/Stay — артборд, no-scale нельзя.
 *
 * Вынимаем .lum-exely-search из scaled-дерева в body (position:fixed поверх placeholder).
 * Клики/ширина iframe = нативные CSS px, страница остаётся на transform:scale.
 */
import { getLenis } from './smooth-scroll';

const freed = [];

function pageScale(page) {
    if (! page) {
        return 1;
    }

    const t = getComputedStyle(page).transform;

    if (! t || t === 'none') {
        return 1;
    }

    const m = t.match(/matrix\(([^)]+)\)/);

    if (! m) {
        return 1;
    }

    const a = parseFloat(m[1].split(',')[0]);

    return Number.isFinite(a) && a > 0 ? a : 1;
}

function syncFreed(entry) {
    const { el, placeholder } = entry;

    if (! placeholder.isConnected || ! el.isConnected) {
        return;
    }

    const page = document.querySelector('.lum-page');
    const scale = pageScale(page);
    const visualH = el.getBoundingClientRect().height;

    if (visualH > 0 && scale > 0) {
        placeholder.style.height = `${Math.ceil(visualH / scale)}px`;
    }

    const r = placeholder.getBoundingClientRect();

    el.style.position = 'fixed';
    el.style.left = `${Math.round(r.left)}px`;
    el.style.top = `${Math.round(r.top)}px`;
    el.style.width = `${Math.round(r.width)}px`;
    el.style.margin = '0';
    el.style.zIndex = '25';
    el.style.pointerEvents = 'auto';
}

function freeSearch(el) {
    if (el.dataset.lumExelyFreed === '1') {
        return;
    }

    el.dataset.lumExelyFreed = '1';

    const placeholder = document.createElement('div');
    placeholder.className = 'lum-exely-placeholder';
    placeholder.dataset.lumExelyPlaceholder = '1';
    placeholder.style.width = '100%';
    placeholder.style.height = `${Math.max(el.offsetHeight, 100)}px`;
    placeholder.setAttribute('aria-hidden', 'true');

    el.parentNode?.insertBefore(placeholder, el);
    document.body.appendChild(el);
    el.classList.add('is-freed');

    const entry = { el, placeholder };
    freed.push(entry);

    if (typeof ResizeObserver !== 'undefined') {
        const ro = new ResizeObserver(() => syncFreed(entry));
        ro.observe(el);
        entry.ro = ro;
    }

    syncFreed(entry);
}

export function syncExelyUnscale() {
    freed.forEach(syncFreed);
}

export function initExelyUnscale() {
    const page = document.querySelector('.lum-page');

    if (! page || page.hasAttribute('data-lum-no-scale')) {
        return;
    }

    page.querySelectorAll('.lum-exely-search').forEach(freeSearch);

    if (! freed.length) {
        return;
    }

    document.addEventListener('lum:layout-change', syncExelyUnscale);
    window.addEventListener('scroll', syncExelyUnscale, { passive: true });
    window.addEventListener('resize', syncExelyUnscale, { passive: true });

    const lenis = getLenis();

    if (lenis) {
        lenis.on('scroll', syncExelyUnscale);
    }

    // iframe/skeleton догрузились → высота placeholder
    document.addEventListener('lum:layout-change', () => {
        requestAnimationFrame(syncExelyUnscale);
    });
}
