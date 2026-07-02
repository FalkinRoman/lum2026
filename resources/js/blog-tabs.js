export function initBlogTabs() {
    document.querySelectorAll('[data-lum-blog-tabs]').forEach((root) => {
        const tabs = [...root.querySelectorAll('[data-lum-blog-tab]')];
        const posts = [...document.querySelectorAll('[data-lum-blog-post]')];

        if (! tabs.length || ! posts.length) {
            return;
        }

        const setActive = (activeTab) => {
            const category = activeTab.dataset.category || 'all';

            tabs.forEach((tab) => {
                const isActive = tab === activeTab;

                tab.classList.toggle('lum-tab--active', isActive);
                tab.classList.toggle('lum-tab--inactive', ! isActive);
            });

            posts.forEach((post) => {
                const categories = (post.dataset.categories || '').split(' ').filter(Boolean);
                const visible = category === 'all' || categories.includes(category);

                post.style.display = visible ? '' : 'none';
            });
        };

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => setActive(tab));
        });
    });
}
