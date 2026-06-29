import gsap from 'gsap';

function splitWord(wordEl) {
    const text = wordEl.textContent ?? '';
    wordEl.textContent = '';

    [...text].forEach((char) => {
        const span = document.createElement('span');
        span.className = 'lum-3d-text__char';
        span.textContent = char === ' ' ? '\u00A0' : char;
        wordEl.appendChild(span);
    });
}

function init3dTextItem(link) {
    const inner = link.querySelector('.lum-3d-text__inner');
    const word = link.querySelector('.lum-3d-text__word');

    if (! inner || ! word) {
        return;
    }

    splitWord(word);

    const clone = word.cloneNode(true);
    clone.classList.add('lum-3d-text__word--clone');
    clone.setAttribute('aria-hidden', 'true');
    inner.appendChild(clone);

    const chars = [...word.querySelectorAll('.lum-3d-text__char')];
    const cloneChars = [...clone.querySelectorAll('.lum-3d-text__char')];

    let timeline = null;
    let hoverTimeout = null;
    let isHovered = false;

    const animateIn = () => {
        if (timeline) {
            timeline.kill();
        }

        timeline = gsap.timeline({
            defaults: { duration: 0.5, ease: 'power2', stagger: 0.02 },
        })
            .to(chars, {
                y: '100%',
                rotationX: -90,
                opacity: 0,
            })
            .to(cloneChars, {
                startAt: { y: '-100%', rotationX: 90, opacity: 0 },
                y: '0%',
                rotationX: 0,
                opacity: 1,
            }, 0);
    };

    const animateOut = () => {
        if (timeline) {
            timeline.kill();
        }

        timeline = gsap.timeline({
            defaults: { duration: 0.5, ease: 'power2', stagger: 0.02 },
        })
            .to(cloneChars, {
                y: '-100%',
                rotationX: 90,
                opacity: 0,
            })
            .to(chars, {
                startAt: { y: '100%', rotationX: -90, opacity: 0 },
                y: '0%',
                rotationX: 0,
                opacity: 1,
            }, 0);
    };

    link.addEventListener('mouseenter', () => {
        hoverTimeout = window.setTimeout(() => {
            isHovered = true;
            animateIn();
        }, 80);
    });

    link.addEventListener('mouseleave', () => {
        if (hoverTimeout) {
            window.clearTimeout(hoverTimeout);
            hoverTimeout = null;
        }

        if (! isHovered) {
            return;
        }

        isHovered = false;
        animateOut();
    });
}

export function initFooter3dText() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    if (! window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
        return;
    }

    document.querySelectorAll('[data-lum-3d-text]').forEach(init3dTextItem);
}
