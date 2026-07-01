<?php

declare(strict_types=1);

$projectRoot = dirname(__DIR__);
$lumBase = $projectRoot . '/public/images/lum';

$legacyAliases = [
    'villas/slide-02.jpg' => 'villas/slide-02.webp',
    'villas/slide-03.jpg' => 'villas/slide-03.webp',
    'villas/slide-04.jpg' => 'villas/slide-04.webp',
    'villas/oval-01.jpg' => 'villas/oval-01.webp',
    'villas/oval-02.jpg' => 'villas/oval-02.webp',
    'villas/oval-03.jpg' => 'villas/oval-03.webp',
    'villas/oval-04.jpg' => 'villas/oval-04.webp',
    'interior/left.jpg' => 'interior/slide-01.webp',
    'interior/right.jpg' => 'interior/slide-02.webp',
];

function streamDownload(string $url, string $dest): bool
{
    $in = fopen($url, 'r', false, stream_context_create([
        'http' => ['follow_location' => 1, 'timeout' => 120],
        'ssl' => ['verify_peer' => true],
    ]));

    if ($in === false) {
        return false;
    }

    $out = fopen($dest, 'w');

    if ($out === false) {
        fclose($in);

        return false;
    }

    stream_copy_to_stream($in, $out);
    fclose($in);
    fclose($out);

    return filesize($dest) > 0;
}

function ensureAlias(string $lumBase, string $target, string $source): void
{
    $targetPath = $lumBase . '/' . $target;
    $sourcePath = $lumBase . '/' . $source;

    if (! file_exists($sourcePath)) {
        echo "MISSING source for alias {$target} <- {$source}\n";

        return;
    }

    if (file_exists($targetPath) && filesize($targetPath) > 0) {
        echo "OK alias {$target}\n";

        return;
    }

    if (! is_dir(dirname($targetPath))) {
        mkdir(dirname($targetPath), 0777, true);
    }

    copy($sourcePath, $targetPath);
    echo "ALIAS {$target} <- {$source}\n";
}

if (file_exists($projectRoot . '/scripts/asset-manifest-lum.php')) {
    $manifest = require $projectRoot . '/scripts/asset-manifest-lum.php';
} else {
    require $projectRoot . '/scripts/sync-asset-manifest.php';
    $manifest = require $projectRoot . '/scripts/asset-manifest-lum.php';
}

$remoteAssets = [
    // Refresh only if missing locally. Figma MCP URLs expire after ~7 days.
    'dining/restaurant-bar.webp' => 'https://www.figma.com/api/mcp/asset/a1c00005-8942-48e7-8245-6e385a73964d',
    'dining/detail/shared/divider.svg' => 'https://www.figma.com/api/mcp/asset/37ae78ba-621a-40b4-bd70-985d18f4925f',
    'dining/detail/shared/divider-tab.svg' => 'https://www.figma.com/api/mcp/asset/1681fcd8-31cb-414d-b480-b4c825c74d5c',
    'dining/detail/shared/divider-mob.svg' => 'https://www.figma.com/api/mcp/asset/6e36744e-32c3-44c0-805f-f02a556a13b1',
    'relax/yoga.webp' => 'https://www.figma.com/api/mcp/asset/ac88d841-f3f3-4069-ae2f-e162e6814ccd',
    'relax/surfing.webp' => 'https://www.figma.com/api/mcp/asset/fefb0c10-f1f9-4f50-ba67-3aba581058e2',
    'relax/padel.webp' => 'https://www.figma.com/api/mcp/asset/4d79e9a5-c13b-441c-a494-bdc95b0bbcd2',
    'relax/wellness-hero.webp' => 'https://www.figma.com/api/mcp/asset/092f7782-ba61-4255-9bbb-49cd63c8a788',
    'relax/wellness-oval.webp' => 'https://www.figma.com/api/mcp/asset/ddafa8ee-e5c6-48c2-9584-4e2cbc5578e1',
    'relax/wellness-hero-mob.webp' => 'https://www.figma.com/api/mcp/asset/1a72694f-1373-487a-ac0b-40ed524718d7',
    'relax/wellness-hero-tab.webp' => 'https://www.figma.com/api/mcp/asset/3446f656-87e9-402a-8ac9-70c07aad7e5f',
];

$ok = 0;
$missing = 0;

foreach ($manifest as $path => $status) {
    $full = $lumBase . '/' . $path;

    if (file_exists($full) && filesize($full) > 0) {
        $ok++;
        continue;
    }

    $missing++;
    echo "MISSING {$path}\n";

    if (isset($remoteAssets[$path])) {
        if (! is_dir(dirname($full))) {
            mkdir(dirname($full), 0777, true);
        }

        if (streamDownload($remoteAssets[$path], $full)) {
            echo "DOWNLOADED {$path}\n";
            $missing--;
            $ok++;
        }
    }
}

foreach ($legacyAliases as $target => $source) {
    ensureAlias($lumBase, $target, $source);
}

echo "\nLocal assets: {$ok}/" . count($manifest) . "\n";

if ($missing > 0) {
    echo "Still missing: {$missing}\n";
}

echo "\nOptimizing images...\n";
passthru('php ' . escapeshellarg($projectRoot . '/scripts/optimize-images.php'));
