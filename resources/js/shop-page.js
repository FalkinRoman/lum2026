import gsap from 'gsap';
import { getLenis } from './smooth-scroll';

const PAGE_SCROLL_OFFSET = 96;
const REVEAL_DURATION = 0.75;
const REVEAL_STAGGER = 0.1;
const REVEAL_EASE = 'power3.out';

function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function syncThumbIndicator(card, activeThumb) {
    const indicator = card.querySelector('[data-lum-shop-thumb-indicator]');
    const wrap = card.querySelector('[data-lum-shop-thumbs]');

    if (! indicator || ! activeThumb || ! wrap) {
        return;
    }

    indicator.style.width = `${activeThumb.offsetWidth}px`;
    indicator.style.left = `${activeThumb.offsetLeft}px`;
}

function setActiveButton(buttons, activeButton) {
    buttons.forEach((button) => {
        button.toggleAttribute('data-active', button === activeButton);
    });
}

function setProductImage(card, thumb) {
    const mainImage = card.querySelector('[data-lum-shop-product-image]');
    const thumbImage = thumb.querySelector('img');

    if (! (mainImage instanceof HTMLImageElement) || ! thumbImage?.src) {
        return;
    }

    mainImage.src = thumbImage.currentSrc || thumbImage.src;
}

function initShopProduct(card) {
    if (card.dataset.shopProductReady === '1') {
        return;
    }
    card.dataset.shopProductReady = '1';

    const thumbs = [...card.querySelectorAll('[data-lum-shop-thumb]')];
    const colors = [...card.querySelectorAll('[data-lum-shop-color]')];
    const sizes = [...card.querySelectorAll('[data-lum-shop-size]')];
    const initialThumb = thumbs.find((thumb) => thumb.hasAttribute('data-active')) ?? thumbs[0];

    if (initialThumb) {
        syncThumbIndicator(card, initialThumb);
    }

    thumbs.forEach((thumb) => {
        thumb.addEventListener('click', () => {
            setActiveButton(thumbs, thumb);
            syncThumbIndicator(card, thumb);
            setProductImage(card, thumb);
        });
    });

    colors.forEach((color) => {
        color.addEventListener('click', () => setActiveButton(colors, color));
    });

    sizes.forEach((size) => {
        size.addEventListener('click', () => setActiveButton(sizes, size));
    });
}

function parsePageHeights(layout) {
    const raw = layout.dataset.pageHeights || '';

    return raw
        .split(',')
        .map((v) => Number(v.trim()))
        .filter((n) => Number.isFinite(n) && n > 0);
}

function getVisibleShopPanels(layout) {
    return [...layout.querySelectorAll('[data-lum-shop-panel]:not(.hidden)')];
}

function getShopCardTarget(panel) {
    return panel.querySelector('[data-lum-shop-product]') || panel;
}

function primeShopCards(panels) {
    if (! panels.length || prefersReducedMotion()) {
        return;
    }

    gsap.set(panels.map(getShopCardTarget), { autoAlpha: 0, y: 36 });
}

function animateShopCards(panels) {
    if (! panels.length || prefersReducedMotion()) {
        return;
    }

    const targets = panels.map(getShopCardTarget);

    gsap.killTweensOf(targets);
    gsap.fromTo(
        targets,
        { autoAlpha: 0, y: 36 },
        {
            autoAlpha: 1,
            y: 0,
            duration: REVEAL_DURATION,
            ease: REVEAL_EASE,
            stagger: REVEAL_STAGGER,
            onComplete: () => {
                gsap.set(targets, { clearProps: 'transform,opacity,visibility' });
            },
        },
    );
}

function initShopCatalog() {
    document.querySelectorAll('[data-lum-shop-catalog]').forEach((root) => {
        const layouts = [...root.querySelectorAll('[data-lum-shop-layout]')];
        if (! layouts.length) {
            return;
        }

        const arrowLeft = root.dataset.arrowLeft || '';
        const arrowRight = root.dataset.arrowRight || '';
        const paginationPrev = root.dataset.paginationPrev || 'Previous';
        const paginationNext = root.dataset.paginationNext || 'Next';

        /** @type {WeakMap<Element, number>} */
        const pageByLayout = new WeakMap();

        layouts.forEach((layout) => {
            pageByLayout.set(layout, 1);
        });

        const pageCount = (layout) => {
            const heights = parsePageHeights(layout);
            if (heights.length > 0) {
                return heights.length;
            }

            const perPage = Math.max(Number(layout.dataset.perPage || 4), 1);
            const total = layout.querySelectorAll('[data-lum-shop-panel]').length;

            return Math.max(1, Math.ceil(total / perPage));
        };

        const getPage = (layout) => {
            const max = pageCount(layout);
            const page = pageByLayout.get(layout) ?? 1;

            return Math.min(Math.max(page, 1), max);
        };

        const setPage = (layout, page) => {
            pageByLayout.set(layout, Math.min(Math.max(page, 1), pageCount(layout)));
        };

        const applyHeight = (layout) => {
            const heights = parsePageHeights(layout);
            const page = getPage(layout);
            const height = heights[page - 1];

            if (height) {
                layout.style.height = `${height}px`;
            }
        };

        const renderPagination = (layout) => {
            const nav = layout.querySelector('[data-lum-shop-pagination]');
            if (! nav) {
                return;
            }

            const totalPages = pageCount(layout);
            const page = getPage(layout);

            if (totalPages <= 1) {
                nav.hidden = true;
                nav.innerHTML = '';
                nav.setAttribute('aria-hidden', 'true');

                return;
            }

            nav.hidden = false;
            nav.removeAttribute('aria-hidden');

            const prevDisabled = page <= 1;
            const nextDisabled = page >= totalPages;

            const pagesHtml = Array.from({ length: totalPages }, (_, i) => {
                const n = i + 1;
                if (n === page) {
                    return `<span class="lum-blog-pagination__page is-active" aria-current="page">${n}</span>`;
                }

                return `<button type="button" class="lum-blog-pagination__page" data-lum-shop-page="${n}">${n}</button>`;
            }).join('');

            nav.innerHTML = `
                <button type="button" class="lum-blog-pagination__arrow${prevDisabled ? ' is-disabled' : ''}" data-lum-shop-page-prev ${prevDisabled ? 'aria-disabled="true" disabled' : ''} aria-label="${paginationPrev}">
                    <img src="${arrowLeft}" alt="" width="24" height="24">
                </button>
                <div class="lum-blog-pagination__pages">${pagesHtml}</div>
                <button type="button" class="lum-blog-pagination__arrow${nextDisabled ? ' is-disabled' : ''}" data-lum-shop-page-next ${nextDisabled ? 'aria-disabled="true" disabled' : ''} aria-label="${paginationNext}">
                    <img src="${arrowRight}" alt="" width="24" height="24">
                </button>
            `;
        };

        const applyPanels = (layout) => {
            const page = getPage(layout);
            const pageIndex = page - 1;

            layout.querySelectorAll('[data-lum-shop-panel]').forEach((panel) => {
                const panelPage = Number(panel.dataset.page ?? -1);
                panel.classList.toggle('hidden', panelPage !== pageIndex);
            });
        };

        const renderLayout = (layout) => {
            applyPanels(layout);
            applyHeight(layout);
            renderPagination(layout);
        };

        const scrollToFirstCard = (layout) => {
            const firstCard = layout.querySelector('[data-lum-shop-panel]:not(.hidden)');
            const target = firstCard
                ?? layout.querySelector('[data-lum-villa-intro]')
                ?? layout;

            const top = target.getBoundingClientRect().top + window.scrollY;
            const nextY = Math.max(0, top - PAGE_SCROLL_OFFSET);
            const lenis = getLenis();

            if (lenis) {
                lenis.scrollTo(nextY, { immediate: false, duration: 0.7 });
            } else {
                window.scrollTo({ top: nextY, behavior: 'smooth' });
            }
        };

        const changePage = (layout, page) => {
            setPage(layout, page);
            renderLayout(layout);

            const panels = getVisibleShopPanels(layout);
            primeShopCards(panels);

            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    scrollToFirstCard(layout);
                    animateShopCards(panels);
                });
            });
        };

        layouts.forEach((layout) => {
            const nav = layout.querySelector('[data-lum-shop-pagination]');
            if (! nav) {
                return;
            }

            nav.addEventListener('click', (event) => {
                const target = event.target instanceof Element
                    ? event.target.closest('[data-lum-shop-page], [data-lum-shop-page-prev], [data-lum-shop-page-next]')
                    : null;

                if (! target || ! nav.contains(target)) {
                    return;
                }

                const page = getPage(layout);

                if (target.hasAttribute('data-lum-shop-page-prev')) {
                    changePage(layout, page - 1);

                    return;
                }

                if (target.hasAttribute('data-lum-shop-page-next')) {
                    changePage(layout, page + 1);

                    return;
                }

                const next = Number(target.getAttribute('data-lum-shop-page'));
                if (Number.isFinite(next) && next > 0) {
                    changePage(layout, next);
                }
            });
        });

        layouts.forEach(renderLayout);
    });
}

export function initShopPage() {
    initShopCatalog();
    document.querySelectorAll('[data-lum-shop-product]').forEach(initShopProduct);

    document.addEventListener('lum:layout-change', () => {
        document.querySelectorAll('[data-lum-shop-product]').forEach((card) => {
            const activeThumb = card.querySelector('[data-lum-shop-thumb][data-active]')
                ?? card.querySelector('[data-lum-shop-thumb]');

            if (activeThumb) {
                syncThumbIndicator(card, activeThumb);
            }
        });
    });
}
