#!/usr/bin/env php
<?php

/**
 * Export Lum as a self-contained static site (GitHub Pages / any static host).
 *
 * Usage:
 *   php scripts/export-static.php
 *   php scripts/export-static.php --out=/absolute/or/relative/path
 *
 * Output default: ./static-site
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
foreach ($argv as $arg) {
    if (str_starts_with($arg, '--out=')) {
        $outArg = substr($arg, 6);
    }
}

$outDir = $outArg
    ? (str_starts_with($outArg, '/') ? $outArg : $root.'/'.$outArg)
    : $root.'/static-site';

echo "==> Building Vite production assets\n";
$hotFile = $root.'/public/hot';
$hotBackup = $root.'/public/hot.bak.export';
$hadHot = is_file($hotFile);
if ($hadHot) {
    rename($hotFile, $hotBackup);
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

    $path = '/'.trim($path, '/');

    return $path;
}

function staticHrefFor(string $appPath, string $locale): string
{
    $appPath = normalizeAppPath($appPath);

    if ($locale === 'en') {
        return $appPath === '/' ? '/' : $appPath.'/';
    }

    return $appPath === '/' ? '/ru/' : '/ru'.$appPath.'/';
}

function filePathFor(string $outDir, string $appPath, string $locale): string
{
    $href = rtrim(staticHrefFor($appPath, $locale), '/');
    if ($href === '' || $href === '/ru') {
        $dir = $locale === 'en' ? $outDir : $outDir.'/ru';
    } else {
        $dir = $outDir.$href;
    }

    return $dir.'/index.html';
}

function rewriteHtml(string $html, string $appPath, string $locale, array $assetPrefixes): string
{
    $html = str_replace(['http://lum.static', 'http:\\/\\/lum.static'], ['', ''], $html);

    $html = preg_replace_callback(
        '/\b(href|action)=(["\'])([^"\']+)\2/i',
        function (array $m) use ($appPath, $locale, $assetPrefixes) {
            $attr = $m[1];
            $q = $m[2];
            $url = html_entity_decode($m[3], ENT_QUOTES | ENT_HTML5);

            if ($url === '' || str_starts_with($url, '#') || str_starts_with($url, 'mailto:') || str_starts_with($url, 'tel:') || str_starts_with($url, 'javascript:') || preg_match('#^https?://#i', $url)) {
                return $m[0];
            }

            $parts = parse_url($url);
            $path = $parts['path'] ?? '/';
            $query = isset($parts['query']) ? '?'.$parts['query'] : '';
            $fragment = isset($parts['fragment']) ? '#'.$parts['fragment'] : '';

            if (isAssetPath($path, $assetPrefixes)) {
                return $attr.'='.$q.$path.$query.$fragment.$q;
            }

            if (preg_match('#^/locale/(en|ru)/?$#', $path, $lm)) {
                $targetLocale = $lm[1];
                $href = staticHrefFor($appPath, $targetLocale);

                return $attr.'='.$q.$href.$q;
            }

            $known = preg_match('#^/(stay|dining|relax|discover|blog|contacts|shop)(/|$)#', $path) || $path === '/';
            if (! $known) {
                return $attr.'='.$q.$path.$query.$fragment.$q;
            }

            $href = staticHrefFor($path, $locale);

            return $attr.'='.$q.$href.$query.$fragment.$q;
        },
        $html
    );

    // JSON / data-* payloads (e.g. villas slider hrefs)
    $html = preg_replace_callback(
        '/"href":"((?:\\\\\/|\/)(?:stay|dining|relax|discover|blog|contacts|shop)(?:\\\\\/|\/)?[^"]*)"/',
        function (array $m) use ($locale) {
            $path = stripcslashes($m[1]);
            $href = staticHrefFor($path, $locale);

            return '"href":"'.str_replace('/', '\\/', $href).'"';
        },
        $html
    );

    return $html;
}

function renderPage(Kernel $kernel, string $path, string $locale): string
{
    $request = Request::create($path, 'GET');
    $request->headers->set('HOST', 'lum.static');

    // Start session and force locale (cookies are encrypted in Laravel).
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

echo "==> Preparing {$outDir}\n";
if (is_dir($outDir)) {
    rrmdir($outDir);
}
mkdir($outDir, 0755, true);

echo "==> Rendering pages\n";
foreach ($pages as $path) {
    foreach (['en', 'ru'] as $locale) {
        $html = renderPage($kernel, $path, $locale);
        $html = rewriteHtml($html, $path, $locale, $assetPrefixes);
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

// GitHub Pages: disable Jekyll so _* / build paths stay intact
file_put_contents($outDir.'/.nojekyll', "");

$readme = <<<'MD'
# Lum — static site

Pixel-static export of the Lum Laravel front-end (EN + RU). No PHP required.

## Structure

- `/` — English
- `/ru/` — Russian
- `/build/` — CSS/JS (Vite production)
- `/images/` — all media

Language switcher points to the twin page under `/` or `/ru/`.

## Preview locally

```bash
cd static-site
python3 -m http.server 8080
# open http://localhost:8080/
# RU: http://localhost:8080/ru/
```

Or:

```bash
npx serve .
```

## Deploy

### Any static host / VPS / nginx

Upload the **contents** of this folder to the web root.

### GitHub Pages

1. Create a new repo (or `gh-pages` branch).
2. Push this folder as the repo root (include `.nojekyll`).
3. Settings → Pages → Deploy from branch.

**Project site** (`username.github.io/repo/`): either

- set repo to deploy from `/docs` and keep paths, **or**
- use a user/org site / custom domain so root-relative `/build` and `/images` resolve, **or**
- open `index.html` rewrite with a `<base href="/repo-name/">` if you must host under a subpath.

Root-relative URLs (`/stay/`, `/images/...`) assume the site is served from domain root.

## Re-export from Laravel project

```bash
php scripts/export-static.php
# custom out:
php scripts/export-static.php --out=../lum-static
```
MD;

file_put_contents($outDir.'/README.md', $readme);

if ($hadHot && is_file($hotBackup)) {
    rename($hotBackup, $hotFile);
}

$count = iterator_count(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($outDir, FilesystemIterator::SKIP_DOTS)));
echo "==> Done: {$outDir} ({$count} files)\n";
} catch (Throwable $e) {
    if ($hadHot && is_file($hotBackup) && ! is_file($hotFile)) {
        rename($hotBackup, $hotFile);
    }
    fwrite(STDERR, $e->getMessage()."\n");
    exit(1);
}