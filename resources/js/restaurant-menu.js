import { getLenis } from './smooth-scroll';

export function initRestaurantMenu() {
    document.querySelectorAll('[data-lum-restaurant-menu]').forEach((root) => {
        const tabs = [...root.querySelectorAll('[data-lum-menu-tab]')];
        const layouts = [...root.querySelectorAll('[data-lum-menu-layout]')];

        if (! tabs.length || ! layouts.length) {
            return;
        }

        const arrowLeft = root.dataset.arrowLeft || '';
        const arrowRight = root.dataset.arrowRight || '';
        const paginationPrev = root.dataset.paginationPrev || 'Previous';
        const paginationNext = root.dataset.paginationNext || 'Next';

        const firstCategory = tabs[0]?.dataset.category || '';
        let activeCategory = firstCategory;

        /** @type {WeakMap<Element, Record<string, number>>} */
        const pagesByLayout = new WeakMap();

        layouts.forEach((layout) => {
            pagesByLayout.set(layout, {});
        });

        const countForCategory = (layout, category) => layout.querySelectorAll(
            `[data-lum-menu-panel][data-category="${CSS.escape(category)}"]`,
        ).length;

        const pageCount = (layout, category) => {
            const perPage = Math.max(Number(layout.dataset.perPage || 4), 1);
            const total = countForCategory(layout, category);

            return Math.max(1, Math.ceil(total / perPage));
        };

        const getPage = (layout, category) => {
            const state = pagesByLayout.get(layout) || {};
            const max = pageCount(layout, category);
            const page = state[category] ?? 1;

            return Math.min(Math.max(page, 1), max);
        };

        const setLayoutPage = (layout, category, page) => {
            const state = pagesByLayout.get(layout) || {};
            const max = pageCount(layout, category);
            state[category] = Math.min(Math.max(page, 1), max);
            pagesByLayout.set(layout, state);
        };

        const renderPagination = (layout, category) => {
            const nav = layout.querySelector('[data-lum-menu-pagination]');
            if (! nav) {
                return;
            }

            const totalPages = pageCount(layout, category);
            const page = getPage(layout, category);

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

                return `<button type="button" class="lum-blog-pagination__page" data-lum-menu-page="${n}">${n}</button>`;
            }).join('');

            nav.innerHTML = `
                <button type="button" class="lum-blog-pagination__arrow${prevDisabled ? ' is-disabled' : ''}" data-lum-menu-page-prev ${prevDisabled ? 'aria-disabled="true" disabled' : ''} aria-label="${paginationPrev}">
                    <img src="${arrowLeft}" alt="" width="24" height="24">
                </button>
                <div class="lum-blog-pagination__pages">${pagesHtml}</div>
                <button type="button" class="lum-blog-pagination__arrow${nextDisabled ? ' is-disabled' : ''}" data-lum-menu-page-next ${nextDisabled ? 'aria-disabled="true" disabled' : ''} aria-label="${paginationNext}">
                    <img src="${arrowRight}" alt="" width="24" height="24">
                </button>
            `;
        };

        const applyPanels = (layout, category) => {
            const perPage = Math.max(Number(layout.dataset.perPage || 4), 1);
            const page = getPage(layout, category);
            const start = (page - 1) * perPage;
            const end = start + perPage;

            layout.querySelectorAll('[data-lum-menu-panel]').forEach((panel) => {
                const sameCategory = panel.dataset.category === category;
                const index = Number(panel.dataset.index ?? -1);
                const onPage = sameCategory && index >= start && index < end;

                panel.classList.toggle('hidden', ! onPage);
            });
        };

        const renderLayout = (layout) => {
            applyPanels(layout, activeCategory);
            renderPagination(layout, activeCategory);
        };

        /** Keep pagination at the same viewport Y after height changes (1 vs 2 cards). */
        const stabilizePaginationScroll = (layout, anchorTop) => {
            if (anchorTop == null) {
                return;
            }

            const nav = layout.querySelector('[data-lum-menu-pagination]');
            if (! nav || nav.hidden) {
                return;
            }

            const afterTop = nav.getBoundingClientRect().top;
            const delta = afterTop - anchorTop;

            if (Math.abs(delta) < 1) {
                return;
            }

            const nextY = Math.max(0, window.scrollY + delta);
            const lenis = getLenis();

            if (lenis) {
                lenis.scrollTo(nextY, { immediate: true });
            } else {
                window.scrollTo(0, nextY);
            }
        };

        const changePage = (layout, page) => {
            const nav = layout.querySelector('[data-lum-menu-pagination]');
            const anchorTop = nav && ! nav.hidden
                ? nav.getBoundingClientRect().top
                : null;

            setLayoutPage(layout, activeCategory, page);
            renderLayout(layout);

            // Double rAF: layout paint after hidden toggles
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    stabilizePaginationScroll(layout, anchorTop);
                });
            });
        };

        const render = () => {
            layouts.forEach(renderLayout);
        };

        const setCategory = (category) => {
            if (category === activeCategory) {
                return;
            }

            activeCategory = category;

            tabs.forEach((tab) => {
                const isActive = tab.dataset.category === category;

                tab.classList.toggle('lum-tab--active', isActive);
                tab.classList.toggle('lum-tab--inactive', ! isActive);

                const label = tab.textContent?.replace(/^✓/, '') ?? '';
                tab.textContent = isActive ? `✓${label}` : label;
            });

            layouts.forEach((layout) => {
                setLayoutPage(layout, category, 1);
            });

            render();
        };

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => {
                if (tab.dataset.category) {
                    setCategory(tab.dataset.category);
                }
            });
        });

        layouts.forEach((layout) => {
            const nav = layout.querySelector('[data-lum-menu-pagination]');
            if (! nav) {
                return;
            }

            nav.addEventListener('click', (event) => {
                const target = event.target instanceof Element
                    ? event.target.closest('[data-lum-menu-page], [data-lum-menu-page-prev], [data-lum-menu-page-next]')
                    : null;

                if (! target || ! nav.contains(target)) {
                    return;
                }

                const page = getPage(layout, activeCategory);

                if (target.hasAttribute('data-lum-menu-page-prev')) {
                    changePage(layout, page - 1);

                    return;
                }

                if (target.hasAttribute('data-lum-menu-page-next')) {
                    changePage(layout, page + 1);

                    return;
                }

                const next = Number(target.getAttribute('data-lum-menu-page'));
                if (Number.isFinite(next) && next > 0) {
                    changePage(layout, next);
                }
            });
        });

        render();
    });
}
