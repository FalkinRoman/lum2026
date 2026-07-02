function setActiveButton(buttons, activeButton, activeClass = 'ring-1 ring-lum-espresso') {
    buttons.forEach((button) => {
        button.classList.toggle(activeClass, button === activeButton);
        button.toggleAttribute('data-active', button === activeButton);
    });
}

export function initShopPage() {
    document.querySelectorAll('[data-lum-shop-product]').forEach((card) => {
        const image = card.querySelector('[data-lum-shop-product-image]');
        const thumbs = [...card.querySelectorAll('[data-lum-shop-thumb]')];
        const colors = [...card.querySelectorAll('[data-lum-shop-color]')];
        const sizes = [...card.querySelectorAll('[data-lum-shop-size]')];

        thumbs.forEach((thumb) => {
            thumb.addEventListener('click', () => {
                const thumbImage = thumb.querySelector('img');

                if (image && thumbImage) {
                    image.src = thumbImage.src;
                }

                setActiveButton(thumbs, thumb);
            });
        });

        colors.forEach((color) => {
            color.addEventListener('click', () => setActiveButton(colors, color));
        });

        sizes.forEach((size) => {
            size.addEventListener('click', () => setActiveButton(sizes, size));
        });
    });
}
