/**
 * GitHub project Pages live under /lum2026 — root-absolute /images/... 404.
 * Keep Laravel/prod on domain root unchanged (prefix empty).
 */
export function sitePathPrefix() {
    const parts = window.location.pathname.split('/').filter(Boolean);

    if (parts[0] === 'lum2026') {
        return '/lum2026';
    }

    return '';
}

export function withSitePrefix(src) {
    if (! src || typeof src !== 'string') {
        return src;
    }

    if (
        src.startsWith('http://')
        || src.startsWith('https://')
        || src.startsWith('data:')
        || src.startsWith('blob:')
        || src.startsWith('//')
        || src.startsWith('#')
    ) {
        return src;
    }

    const prefix = sitePathPrefix();

    if (! prefix) {
        return src;
    }

    if (src === prefix || src.startsWith(`${prefix}/`)) {
        return src;
    }

    if (src.startsWith('/')) {
        return `${prefix}${src}`;
    }

    return src;
}
