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
