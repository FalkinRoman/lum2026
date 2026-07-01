<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$base = $root . '/public/images/lum';

function collectFiles(string $dir, string $prefix = ''): array
{
    $files = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
    );

    foreach ($iterator as $file) {
        if (! $file->isFile()) {
            continue;
        }

        $relative = $prefix . substr($file->getPathname(), strlen($dir) + 1);
        $files[] = str_replace('\\', '/', $relative);
    }

    sort($files);

    return $files;
}

function writeManifest(string $path, array $files, string $title): void
{
    $lines = [
        '<?php',
        '',
        "// {$title} — auto-generated inventory of local assets.",
        '// Run: php scripts/sync-asset-manifest.php',
        '',
        '$assets = [',
    ];

    foreach ($files as $file) {
        $lines[] = "    '{$file}' => 'local',";
    }

    $lines[] = '];';
    $lines[] = '';
    $lines[] = 'return $assets;';
    $lines[] = '';

    file_put_contents($path, implode(PHP_EOL, $lines));
}

$lumFiles = collectFiles($base);
writeManifest($root . '/scripts/asset-manifest-lum.php', $lumFiles, 'Lum image inventory');

$villaFiles = collectFiles($base . '/villa');
writeManifest($root . '/scripts/asset-manifest-villa.php', $villaFiles, 'Villa image inventory');

echo 'Manifests updated: ' . count($lumFiles) . " lum files, " . count($villaFiles) . " villa files\n";
