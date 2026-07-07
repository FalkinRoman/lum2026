export function initBlogSlider() {
    document.querySelectorAll('[data-lum-blog-slider]').forEach((root) => {
        const track = root.querySelector('[data-lum-blog-track]');
        const prev = root.querySelector('[data-lum-blog-prev]');
        const next = root.querySelector('[data-lum-blog-next]');

        if (! track || ! prev || ! next) {
            return;
        }

        const cards = [...track.querySelectorAll('[data-lum-blog-card]')];

        if (cards.length < 2) {
            prev.disabled = true;
            next.disabled = true;

            return;
        }

        const getStep = () => cards[1].offsetLeft - cards[0].offsetLeft;

        const getMaxScroll = () => Math.max(0, track.scrollWidth - track.clientWidth);

        const syncButtons = () => {
            const atStart = track.scrollLeft <= 1;
            const atEnd = track.scrollLeft >= getMaxScroll() - 1;

            prev.disabled = atStart;
            next.disabled = atEnd;
            prev.classList.toggle('opacity-40', atStart);
            next.classList.toggle('opacity-40', atEnd);
        };

        const scrollByStep = (direction) => {
            const step = getStep();
            const maxScroll = getMaxScroll();
            const target = Math.max(0, Math.min(maxScroll, track.scrollLeft + direction * step));

            track.scrollTo({ left: target, behavior: 'smooth' });
        };

        prev.addEventListener('click', () => {
            scrollByStep(-1);
        });

        next.addEventListener('click', () => {
            scrollByStep(1);
        });

        track.addEventListener('scroll', syncButtons, { passive: true });

        if ('onscrollend' in window) {
            track.addEventListener('scrollend', syncButtons, { passive: true });
        }

        window.addEventListener('resize', () => {
            track.scrollLeft = Math.min(track.scrollLeft, getMaxScroll());
            syncButtons();
        });

        track.scrollLeft = 0;
        syncButtons();
    });
}
