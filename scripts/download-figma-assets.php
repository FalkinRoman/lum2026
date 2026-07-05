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
    'discover/detail/galle-fort/wellness-hero.webp' => 'https://www.figma.com/api/mcp/asset/1d3b9ab9-6672-4fc6-a40b-38890dc174d5',
    'discover/detail/galle-fort/oval.webp' => 'https://www.figma.com/api/mcp/asset/f1fcdcd5-fe04-46fb-853c-e8bb3284f5e9',
    'discover/detail/galle-fort/gallery-01.webp' => 'https://www.figma.com/api/mcp/asset/2cffd5a5-38c9-40c3-acf3-04f72dc4b958',
    'discover/detail/galle-fort/gallery-02.webp' => 'https://www.figma.com/api/mcp/asset/fd566f1e-6f1d-4e79-8cfd-646934d21f59',
    'discover/detail/galle-fort/gallery-03.webp' => 'https://www.figma.com/api/mcp/asset/392d0aad-42a1-479a-a0f2-ca9a6a5f3766',
    'discover/detail/galle-fort/package-01.webp' => 'https://www.figma.com/api/mcp/asset/9431a297-4e6e-4867-ad4f-dc5d506e99fe',
    'discover/detail/galle-fort/package-02.webp' => 'https://www.figma.com/api/mcp/asset/995aa515-556f-4376-8849-1a4b384c5d6a',
    'blog/posts/sri-lanka-guide.webp' => 'https://www.figma.com/api/mcp/asset/3b750f3c-2195-483a-9ebd-4150facca7aa',
    'blog/posts/nervous-system-retreat.webp' => 'https://www.figma.com/api/mcp/asset/47218a4c-2586-46ba-a51d-25d5712bad07',
    'blog/posts/lum-ocean-trip.webp' => 'https://www.figma.com/api/mcp/asset/8157b810-dcb0-4b63-a5b0-f4e14e0574a9',
    'blog/detail/nervous-system-retreat/hero.webp' => 'https://www.figma.com/api/mcp/asset/edb2b493-25a0-4774-88d5-de8dd3ed296b',
    'contact/map-mob.webp' => 'https://www.figma.com/api/mcp/asset/b5b8f797-78c5-4d83-b192-9fdb5db4ff00',
    'contact/map-desk.webp' => 'https://www.figma.com/api/mcp/asset/b5b8f797-78c5-4d83-b192-9fdb5db4ff00',
    'contact/hero.webp' => 'https://www.figma.com/api/mcp/asset/72416b02-6aef-48ba-9c64-9408d285d13a',
    'shop/products/ocean-tee.webp' => 'https://www.figma.com/api/mcp/asset/cdfd2d76-2da7-468b-af84-53c4aa16ce3e',
    'shop/products/lum-cup.webp' => 'https://www.figma.com/api/mcp/asset/3514e2d5-a3e7-4023-a7bf-d7a4fd403e0e',
    'shop/products/thumbs/tee-01.webp' => 'https://www.figma.com/api/mcp/asset/1c08b09b-f29d-4423-9d4a-d7ad1351e742',
    'shop/products/thumbs/tee-02.webp' => 'https://www.figma.com/api/mcp/asset/629e2b69-63aa-4b27-80a8-e79321dda77e',
    'shop/products/thumbs/tee-03.webp' => 'https://www.figma.com/api/mcp/asset/773f0fd2-56a7-4791-9fec-34d71851a77c',
    'shop/products/thumbs/tee-04.webp' => 'https://www.figma.com/api/mcp/asset/bdfb3d9a-d130-4b7c-87f6-1ce2f24636c3',
    'shop/products/thumbs/cup-01.webp' => 'https://www.figma.com/api/mcp/asset/871ae3a9-1e3e-42b0-ac03-5d37028271ce',
    'shop/products/thumbs/cup-02.webp' => 'https://www.figma.com/api/mcp/asset/871ae3a9-1e3e-42b0-ac03-5d37028271ce',
    'shop/products/thumbs/cup-03.webp' => 'https://www.figma.com/api/mcp/asset/871ae3a9-1e3e-42b0-ac03-5d37028271ce',
    'shop/products/thumbs/cup-04.webp' => 'https://www.figma.com/api/mcp/asset/871ae3a9-1e3e-42b0-ac03-5d37028271ce',
    'shop/products/colors/color-01.svg' => 'https://www.figma.com/api/mcp/asset/366a4426-c466-415d-8b11-a529e685a5dd',
    'shop/products/colors/color-02.svg' => 'https://www.figma.com/api/mcp/asset/b1356e1a-4448-426c-b5ea-cb510e285b6a',
    'shop/products/colors/color-03.svg' => 'https://www.figma.com/api/mcp/asset/dae81061-5569-4522-aa2f-458a9cf71f8f',
    'shop/products/colors/color-04.svg' => 'https://www.figma.com/api/mcp/asset/e2b78eca-4d51-4eca-ad77-877ecc25be4d',
];

$refreshAssets = [
    'blog/posts/sri-lanka-guide.webp',
    'blog/posts/nervous-system-retreat.webp',
    'blog/posts/lum-ocean-trip.webp',
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

foreach ($refreshAssets as $path) {
    if (! isset($remoteAssets[$path])) {
        continue;
    }

    $full = $lumBase . '/' . $path;

    if (! is_dir(dirname($full))) {
        mkdir(dirname($full), 0777, true);
    }

    if (streamDownload($remoteAssets[$path], $full)) {
        echo "REFRESHED {$path}\n";
    } else {
        echo "FAILED refresh {$path}\n";
    }
}

echo "\nLocal assets: {$ok}/" . count($manifest) . "\n";

if ($missing > 0) {
    echo "Still missing: {$missing}\n";
}

echo "\nOptimizing images...\n";
passthru('php ' . escapeshellarg($projectRoot . '/scripts/optimize-images.php'));
