<?php

declare(strict_types=1);

$projectRoot = dirname(__DIR__);
$villaBase = $projectRoot . '/public/images/lum/villa';

$legacyAliases = [
    'hero.jpg' => 'hero.webp',
    'gallery-01.jpg' => 'gallery-01.webp',
    'gallery-02.jpg' => 'gallery-02.webp',
    'gallery-03.jpg' => 'gallery-03.webp',
    'facilities-left.jpg' => 'facilities-left.webp',
    'facilities-right.jpg' => 'facilities-right.webp',
    'impression/slide-01.jpg' => 'impression/slide-01.webp',
    'impression/slide-02.jpg' => 'impression/slide-02.webp',
    'impression/slide-03.jpg' => 'impression/slide-03.webp',
    'impression/slide-04.jpg' => 'impression/slide-04.webp',
];

function ensureAlias(string $villaBase, string $target, string $source): void
{
    $targetPath = $villaBase . '/' . $target;
    $sourcePath = $villaBase . '/' . $source;

    if (! file_exists($sourcePath)) {
        echo "MISSING source for alias {$target} <- {$source}\n";

        return;
    }

    if (file_exists($targetPath) && filesize($targetPath) > 0) {
        echo "OK {$target}\n";

        return;
    }

    if (! is_dir(dirname($targetPath))) {
        mkdir(dirname($targetPath), 0777, true);
    }

    copy($sourcePath, $targetPath);
    echo "ALIAS {$target} <- {$source}\n";
}

if (file_exists($projectRoot . '/scripts/sync-asset-manifest.php')) {
    require $projectRoot . '/scripts/sync-asset-manifest.php';
}

$manifest = file_exists($projectRoot . '/scripts/asset-manifest-villa.php')
    ? require $projectRoot . '/scripts/asset-manifest-villa.php'
    : [];

$ok = 0;
$missing = 0;

foreach ($manifest as $path => $status) {
    $full = $villaBase . '/' . $path;

    if (file_exists($full) && filesize($full) > 0) {
        $ok++;
        continue;
    }

    $missing++;
    echo "MISSING villa/{$path}\n";
}

foreach ($legacyAliases as $target => $source) {
    ensureAlias($villaBase, $target, $source);
}

echo "\nVilla local assets: {$ok}/" . count($manifest) . "\n";

if ($missing > 0) {
    echo "Still missing: {$missing}\n";
}
