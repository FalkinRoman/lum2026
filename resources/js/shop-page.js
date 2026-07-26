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

    if (! mainImage || ! thumbImage?.src) {
        return;
    }

    mainImage.src = thumbImage.currentSrc || thumbImage.src;
}

function initShopProduct(card) {
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

export function initShopPage() {
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
