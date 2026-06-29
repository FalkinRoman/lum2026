export function initBlogSlider() {
    document.querySelectorAll('[data-lum-blog-slider]').forEach((root) => {
        const track = root.querySelector('[data-lum-blog-track]');
        const prev = root.querySelector('[data-lum-blog-prev]');
        const next = root.querySelector('[data-lum-blog-next]');

        if (! track || ! prev || ! next) {
            return;
        }

        const cards = [...track.querySelectorAll('[data-lum-blog-card]')];

        if (! cards.length) {
            return;
        }

        const getScrollLeftForIndex = (index) => {
            if (index <= 0) {
                return 0;
            }

            if (index >= cards.length - 1) {
                return Math.max(0, track.scrollWidth - track.clientWidth);
            }

            return cards[index].offsetLeft;
        };

        const getActiveIndex = () => {
            const scrollLeft = track.scrollLeft;
            let closest = 0;
            let minDist = Infinity;

            cards.forEach((card, index) => {
                const targetLeft = getScrollLeftForIndex(index);
                const dist = Math.abs(targetLeft - scrollLeft);

                if (dist < minDist) {
                    minDist = dist;
                    closest = index;
                }
            });

            return closest;
        };

        const scrollToIndex = (index, behavior = 'smooth') => {
            const clamped = Math.max(0, Math.min(cards.length - 1, index));

            track.scrollTo({
                left: getScrollLeftForIndex(clamped),
                behavior,
            });
        };

        const syncButtons = () => {
            const index = getActiveIndex();
            const atStart = index <= 0;
            const atEnd = index >= cards.length - 1;

            prev.disabled = atStart;
            next.disabled = atEnd;
            prev.classList.toggle('opacity-40', atStart);
            next.classList.toggle('opacity-40', atEnd);
        };

        prev.addEventListener('click', () => {
            scrollToIndex(getActiveIndex() - 1);
        });

        next.addEventListener('click', () => {
            scrollToIndex(getActiveIndex() + 1);
        });

        track.addEventListener('scroll', syncButtons, { passive: true });

        if ('onscrollend' in window) {
            track.addEventListener('scrollend', syncButtons, { passive: true });
        }

        window.addEventListener('resize', () => {
            scrollToIndex(getActiveIndex(), 'auto');
            syncButtons();
        });

        syncButtons();
    });
}
