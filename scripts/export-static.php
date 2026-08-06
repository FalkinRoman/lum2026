#!/usr/bin/env php
<?php

/**
 * Export Lum as a self-contained static site (GitHub Pages / any static host).
 *
 * Usage:
 *   php scripts/export-static.php
 *   php scripts/export-static.php --out=docs --base=/lum2026
 *
 * Defaults:
 *   --out=static-site
 *   --base=          (empty = site at domain root)
 *
 * For this repo on GitHub Pages (project site):
 *   npm run export:pages
 *   → writes ./docs with asset/page URLs prefixed by /lum2026
 *
 * Laravel / Docker / server deploy are untouched. Keep /docs out of the
 * production image via .dockerignore.
 */

declare(strict_types=1);

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

$root = dirname(__DIR__);
chdir($root);

require $root.'/vendor/autoload.php';

$outArg = null;
$baseArg = '';
foreach ($argv as $arg) {
    if (str_starts_with($arg, '--out=')) {
        $outArg = substr($arg, 6);
    }
    if (str_starts_with($arg, '--base=')) {
        $baseArg = substr($arg, 7);
    }
}

$outDir = $outArg
    ? (str_starts_with($outArg, '/') ? $outArg : $root.'/'.$outArg)
    : $root.'/static-site';

// Normalize base: "" or "/lum2026" (no trailing slash)
$basePath = trim($baseArg);
if ($basePath !== '') {
    $basePath = '/'.trim($basePath, '/');
}

echo "==> Building Vite production assets\n";
$hotFile = $root.'/public/hot';
$hotBackup = $root.'/public/hot.bak.export';
$hadHot = is_file($hotFile);
if ($hadHot) {
    rename($hotFile, $hotBackup);
}
// Belt-and-suspenders: Vite hot must not exist during render.
if (is_file($hotFile)) {
    unlink($hotFile);
}

try {
$build = 0;
passthru('npm run build', $build);
if ($build !== 0) {
    throw new RuntimeException('Vite build failed');
}

$app = require $root.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

/** @var Kernel $kernel */
$kernel = $app->make(Kernel::class);

// Neutralize local .env APP_URL / ForcePublicRootUrl so asset() stays root-relative-friendly.
config([
    'app.url' => 'http://lum.static',
    'app.host' => 'lum.static',
    'app.port' => '',
    'app.scheme' => 'http',
]);
URL::forceRootUrl('http://lum.static');
URL::forceScheme('http');

$pages = [
    '/',
    '/stay',
    '/stay/residence',
    '/stay/oculus',
    '/stay/ocean',
    '/stay/villas',
    '/dining',
    '/dining/restaurant-bar',
    '/dining/sandwich-spot',
    '/dining/rosenkoester',
    '/dining/brute-wine-bar',
    '/relax',
    '/relax/yoga',
    '/relax/surfing',
    '/relax/padel',
    '/discover',
    '/discover/galle-fort',
    '/discover/koggala-lake',
    '/discover/mirissa',
    '/discover/dondra',
    '/blog',
    '/blog/sri-lanka-guide',
    '/blog/nervous-system-retreat',
    '/blog/lum-ocean-trip',
    '/blog/restaurant-bar',
    '/contacts',
    '/privacy',
    '/terms',
    '/shop',
];

$assetPrefixes = [
    '/build/',
    '/images/',
    '/favicon',
    '/robots.txt',
    '/fonts',
];

function isAssetPath(string $path, array $assetPrefixes): bool
{
    foreach ($assetPrefixes as $prefix) {
        if (str_starts_with($path, $prefix)) {
            return true;
        }
    }

    return false;
}

function normalizeAppPath(string $path): string
{
    if ($path === '' || $path === '/') {
        return '/';
    }

    return '/'.trim($path, '/');
}

function withBase(string $href, string $basePath): string
{
    if ($basePath === '') {
        return $href;
    }

    if ($href === '/') {
        return $basePath.'/';
    }

    return $basePath.$href;
}

function staticHrefFor(string $appPath, string $locale, string $basePath = ''): string
{
    $appPath = normalizeAppPath($appPath);

    if ($locale === 'en') {
        $href = $appPath === '/' ? '/' : $appPath.'/';
    } else {
        $prefix = '/'.$locale;
        $href = $appPath === '/' ? $prefix.'/' : $prefix.$appPath.'/';
    }

    return withBase($href, $basePath);
}

function filePathFor(string $outDir, string $appPath, string $locale): string
{
    // Filesystem layout ignores --base (GH Pages serves /docs as site root of /lum2026/)
    $href = rtrim(staticHrefFor($appPath, $locale, ''), '/');
    if ($href === '' || $href === '/'.$locale) {
        $dir = $locale === 'en' ? $outDir : $outDir.'/'.$locale;
    } else {
        $dir = $outDir.$href;
    }

    return $dir.'/index.html';
}

function isAppPagePath(string $path): bool
{
    return $path === '/'
        || (bool) preg_match('#^/(stay|dining|relax|discover|blog|contacts|shop|privacy|terms)(/|$)#', $path);
}

function rewriteHtml(string $html, string $appPath, string $locale, array $assetPrefixes, string $basePath): string
{
    // Collapse absolute local/dev origins to root-relative paths, then apply --base.
    $html = preg_replace(
        '#https?:\\\\?/\\\\?/(?:lum\.static|localhost|127\.0\.0\.1)(?::\d+)?#i',
        '',
        $html
    ) ?? $html;
    $html = preg_replace(
        '#https?://(?:lum\.static|localhost|127\.0\.0\.1)(?::\d+)?#i',
        '',
        $html
    ) ?? $html;

    $html = preg_replace_callback(
        '/\b(href|action|src|srcset)=(["\'])([^"\']+)\2/i',
        function (array $m) use ($appPath, $locale, $assetPrefixes, $basePath) {
            $attr = strtolower($m[1]);
            $q = $m[2];
            $url = html_entity_decode($m[3], ENT_QUOTES | ENT_HTML5);

            if ($attr === 'srcset') {
                $parts = array_map('trim', explode(',', $url));
                $rewritten = [];
                foreach ($parts as $part) {
                    if ($part === '') {
                        continue;
                    }
                    if (! preg_match('/^(\S+)(\s+.*)?$/', $part, $pm)) {
                        $rewritten[] = $part;
                        continue;
                    }
                    $u = $pm[1];
                    $rest = $pm[2] ?? '';
                    if ($u === '' || str_starts_with($u, 'data:') || preg_match('#^https?://#i', $u) || str_starts_with($u, '//')) {
                        $rewritten[] = $part;
                        continue;
                    }
                    $path = parse_url($u, PHP_URL_PATH) ?: $u;
                    if (is_string($path) && str_starts_with($path, '/')) {
                        $rewritten[] = withBase($path, $basePath).$rest;
                    } else {
                        $rewritten[] = $part;
                    }
                }

                return $attr.'='.$q.implode(', ', $rewritten).$q;
            }

            if ($url === '' || str_starts_with($url, '#') || str_starts_with($url, 'mailto:') || str_starts_with($url, 'tel:') || str_starts_with($url, 'javascript:') || str_starts_with($url, 'data:') || preg_match('#^https?://#i', $url) || str_starts_with($url, '//')) {
                return $m[0];
            }

            $parts = parse_url($url);
            $path = $parts['path'] ?? '/';
            $query = isset($parts['query']) ? '?'.$parts['query'] : '';
            $fragment = isset($parts['fragment']) ? '#'.$parts['fragment'] : '';

            if (! is_string($path) || ! str_starts_with($path, '/')) {
                return $m[0];
            }

            if (isAssetPath($path, $assetPrefixes)) {
                return $attr.'='.$q.withBase($path, $basePath).$query.$fragment.$q;
            }

            if ($attr === 'src') {
                return $attr.'='.$q.withBase($path, $basePath).$query.$fragment.$q;
            }

            if (preg_match('#^/locale/(en|ru|zh)/?$#', $path, $lm)) {
                $targetLocale = $lm[1];
                $href = staticHrefFor($appPath, $targetLocale, $basePath);

                return $attr.'='.$q.$href.$q;
            }

            if (! isAppPagePath($path)) {
                return $attr.'='.$q.withBase($path, $basePath).$query.$fragment.$q;
            }

            $href = staticHrefFor($path, $locale, $basePath);

            return $attr.'='.$q.$href.$query.$fragment.$q;
        },
        $html
    );

    // url(...) in inline style / CSS fragments inside HTML
    $html = preg_replace_callback(
        '/url\((["\']?)(\/[^)"\']+)\1\)/i',
        function (array $m) use ($basePath) {
            return 'url('.$m[1].withBase($m[2], $basePath).$m[1].')';
        },
        $html
    );

    // JSON / data-* payloads (e.g. villas slider hrefs)
    $html = preg_replace_callback(
        '/"href":"((?:\\\\\/|\/)(?:stay|dining|relax|discover|blog|contacts|shop|privacy|terms)(?:\\\\\/|\/)?[^"]*)"/',
        function (array $m) use ($locale, $basePath) {
            $path = stripcslashes($m[1]);
            $href = staticHrefFor($path, $locale, $basePath);

            return '"href":"'.str_replace('/', '\\/', $href).'"';
        },
        $html
    );

    return $html;
}

function renderPage(Kernel $kernel, string $path, string $locale): string
{
    // Keep ForcePublicRootUrl on lum.static (no port → no APP_PORT injection).
    $request = Request::create('http://lum.static'.$path, 'GET');
    $request->headers->set('HOST', 'lum.static');
    $request->server->set('HTTP_HOST', 'lum.static');
    $request->server->set('SERVER_NAME', 'lum.static');
    $request->server->set('SERVER_PORT', '80');

    /** @var \Illuminate\Session\SessionManager $sessionManager */
    $sessionManager = app('session');
    $session = $sessionManager->driver();
    $session->start();
    $session->put('locale', $locale);
    $request->setLaravelSession($session);
    App::setLocale($locale);

    $response = $kernel->handle($request);
    $html = $response->getContent();
    $kernel->terminate($request, $response);

    if ($response->getStatusCode() >= 400) {
        throw new RuntimeException("Failed {$path} [{$locale}] HTTP ".$response->getStatusCode());
    }

    return $html;
}

function rrmdir(string $dir): void
{
    if (! is_dir($dir)) {
        return;
    }
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($it as $file) {
        $file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname());
    }
    rmdir($dir);
}

function copyTree(string $src, string $dst): void
{
    if (! is_dir($src)) {
        throw new RuntimeException("Missing source: {$src}");
    }
    if (! is_dir($dst)) {
        mkdir($dst, 0755, true);
    }
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($src, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($it as $item) {
        $target = $dst.substr($item->getPathname(), strlen($src));
        if ($item->isDir()) {
            if (! is_dir($target)) {
                mkdir($target, 0755, true);
            }
        } else {
            $dir = dirname($target);
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            copy($item->getPathname(), $target);
        }
    }
}

echo '==> Preparing '.$outDir.($basePath !== '' ? " (base {$basePath})" : '')."\n";
if (is_dir($outDir)) {
    rrmdir($outDir);
}
mkdir($outDir, 0755, true);

echo "==> Rendering pages\n";
foreach ($pages as $path) {
    foreach (['en', 'ru', 'zh'] as $locale) {
        $html = renderPage($kernel, $path, $locale);
        $html = rewriteHtml($html, $path, $locale, $assetPrefixes, $basePath);
        $file = filePathFor($outDir, $path, $locale);
        $dir = dirname($file);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($file, $html);
        echo '  '.$locale.' '.$path.' -> '.substr($file, strlen($outDir))."\n";
    }
}

echo "==> Copying assets\n";
copyTree($root.'/public/build', $outDir.'/build');
copyTree($root.'/public/images', $outDir.'/images');
foreach (['favicon.ico', 'favicon.png', 'favicon.svg', 'robots.txt'] as $file) {
    $src = $root.'/public/'.$file;
    if (is_file($src)) {
        copy($src, $outDir.'/'.$file);
    }
}

// Rewrite root-absolute urls inside built CSS (e.g. url(/images/...grain.svg))
if ($basePath !== '' && is_dir($outDir.'/build')) {
    $cssIt = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($outDir.'/build', FilesystemIterator::SKIP_DOTS)
    );
    foreach ($cssIt as $cssFile) {
        if (! $cssFile->isFile() || ! str_ends_with(strtolower($cssFile->getFilename()), '.css')) {
            continue;
        }
        $css = file_get_contents($cssFile->getPathname());
        if ($css === false || ! str_contains($css, 'url(/')) {
            continue;
        }
        $css = preg_replace_callback(
            '/url\((["\']?)(\/[^)"\']+)\1\)/i',
            fn (array $m): string => 'url('.$m[1].withBase($m[2], $basePath).$m[1].')',
            $css
        ) ?? $css;
        file_put_contents($cssFile->getPathname(), $css);
    }
}

// GitHub Pages: disable Jekyll so _* / build paths stay intact
file_put_contents($outDir.'/.nojekyll', '');

$pagesUrl = $basePath !== ''
    ? 'https://falkinroman.github.io'.$basePath.'/'
    : '(set --base=/lum2026 for GitHub Pages project URL)';

$readme = <<<MD
# Lum — static site

Pixel-static export of the Lum Laravel front-end (EN + RU + ZH). No PHP required.

## Live (GitHub Pages)

{$pagesUrl}

## Structure

- `/` — English
- `/ru/` — Russian
- `/zh/` — Chinese
- `/build/` — CSS/JS (Vite production)
- `/images/` — all media

## Preview locally

```bash
cd docs   # or static-site
python3 -m http.server 8080
```

For a project-base export (`--base=/lum2026`), preview with a path prefix or just open via Pages.

## Re-export from Laravel project

```bash
# local folder (root-relative URLs)
php scripts/export-static.php

# GitHub Pages for this repo
npm run export:pages
```

Laravel app, Docker, and server deploy are separate — this folder is display-only.
MD;

file_put_contents($outDir.'/README.md', $readme);

if ($hadHot && is_file($hotBackup)) {
    rename($hotBackup, $hotFile);
}

$count = iterator_count(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($outDir, FilesystemIterator::SKIP_DOTS)));
echo "==> Done: {$outDir} ({$count} files)\n";
if ($basePath !== '') {
    echo "==> GitHub Pages URL: https://falkinroman.github.io{$basePath}/\n";
}
} catch (Throwable $e) {
    if ($hadHot && is_file($hotBackup) && ! is_file($hotFile)) {
        rename($hotBackup, $hotFile);
    }
    fwrite(STDERR, $e->getMessage()."\n");
    exit(1);
}
