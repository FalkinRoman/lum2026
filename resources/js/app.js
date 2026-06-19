const LUM_DESIGN_WIDTH = 1920;
const LUM_DESIGN_HEIGHT = 10262;

function scaleLumPage() {
    const viewport = document.querySelector('.lum-viewport');
    const page = document.querySelector('.lum-page');

    if (! viewport || ! page) {
        return;
    }

    const scale = window.innerWidth / LUM_DESIGN_WIDTH;

    page.style.transform = `scale(${scale})`;
    page.style.transformOrigin = 'top left';
    viewport.style.height = `${LUM_DESIGN_HEIGHT * scale}px`;
}

scaleLumPage();
window.addEventListener('resize', scaleLumPage);
