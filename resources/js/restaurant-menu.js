export function initRestaurantMenu() {
    document.querySelectorAll('[data-lum-restaurant-menu]').forEach((root) => {
        const tabs = [...root.querySelectorAll('[data-lum-menu-tab]')];
        const panels = [...root.querySelectorAll('[data-lum-menu-panel]')];

        if (! tabs.length || ! panels.length) {
            return;
        }

        const setCategory = (category) => {
            tabs.forEach((tab) => {
                const isActive = tab.dataset.category === category;

                tab.classList.toggle('lum-tab--active', isActive);
                tab.classList.toggle('lum-tab--inactive', ! isActive);

                const label = tab.textContent?.replace(/^✓/, '') ?? '';
                tab.textContent = isActive ? `✓${label}` : label;
            });

            panels.forEach((panel) => {
                panel.classList.toggle('hidden', panel.dataset.category !== category);
            });
        };

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => {
                if (tab.dataset.category) {
                    setCategory(tab.dataset.category);
                }
            });
        });
    });
}
