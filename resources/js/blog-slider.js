export function initBlogSlider() {
    document.querySelectorAll('[data-lum-blog-slider]').forEach((root) => {
        const track = root.querySelector('[data-lum-blog-track]');
        const prev = root.querySelector('[data-lum-blog-prev]');
        const next = root.querySelector('[data-lum-blog-next]');

        if (! track || ! prev || ! next) {
            return;
        }

        const gap = Number.parseInt(root.dataset.gap || '10', 10);

        const step = () => {
            const card = track.querySelector('[data-lum-blog-card]');

            if (! card) {
                return 0;
            }

            return card.offsetWidth + gap;
        };

        const syncButtons = () => {
            const maxScroll = track.scrollWidth - track.clientWidth;
            const atStart = track.scrollLeft <= 1;
            const atEnd = track.scrollLeft >= maxScroll - 1;

            prev.disabled = atStart;
            next.disabled = atEnd;
            prev.classList.toggle('opacity-40', atStart);
            next.classList.toggle('opacity-40', atEnd);
        };

        prev.addEventListener('click', () => {
            track.scrollBy({ left: -step(), behavior: 'smooth' });
        });

        next.addEventListener('click', () => {
            track.scrollBy({ left: step(), behavior: 'smooth' });
        });

        track.addEventListener('scroll', syncButtons, { passive: true });
        window.addEventListener('resize', syncButtons);
        syncButtons();
    });
}
