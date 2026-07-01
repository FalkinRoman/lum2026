<?php

declare(strict_types=1);

$base = dirname(__DIR__) . '/public/images/lum';
$quality = 78;
$saved = 0;
$processed = 0;

function humanSize(int $bytes): string
{
    if ($bytes >= 1048576) {
        return round($bytes / 1048576, 1) . ' MB';
    }

    if ($bytes >= 1024) {
        return round($bytes / 1024) . ' KB';
    }

    return $bytes . ' B';
}

function imageDimensions(string $path): ?array
{
    $info = @getimagesize($path);

    if ($info === false) {
        return null;
    }

    return [(int) $info[0], (int) $info[1]];
}

function maxWidthFor(string $path): int
{
    if (str_contains($path, '-sm.webp') || str_contains($path, '-sm.')) {
        return 960;
    }

    if (preg_match('#/(menu|location/card-|polaroids/photo-|blog/|swap/)#', $path)) {
        return 1200;
    }

    if (preg_match('#/(hero-bg|wellness-hero|footer/bg|shop/bg|villa/hero|stay/(residence|villas|ocean|oculus))#', $path)) {
        return 1920;
    }

    if (preg_match('#/(gallery-|slide-|oval-|facilities-|dining/)#', $path)) {
        return 1400;
    }

    return 1600;
}

function runCommand(string $command): bool
{
    exec($command, $output, $code);

    return $code === 0;
}

function optimizeWebp(string $path): bool
{
    global $quality, $saved, $processed;

    $before = filesize($path);
    $dimensions = imageDimensions($path);

    if ($dimensions === null) {
        return false;
    }

    [$width] = $dimensions;
    $maxWidth = maxWidthFor($path);
    $resize = $width > $maxWidth ? "-resize {$maxWidth} 0" : '-resize 0 0';
    $tmp = $path . '.opt.webp';

    if (! runCommand(sprintf(
        'cwebp -quiet -q %d %s %s -o %s 2>/dev/null',
        $quality,
        $resize,
        escapeshellarg($path),
        escapeshellarg($tmp),
    ))) {
        @unlink($tmp);

        return false;
    }

    $after = filesize($tmp);

    if ($after <= 0 || $after >= $before) {
        @unlink($tmp);

        return false;
    }

    rename($tmp, $path);
    $processed++;
    $saved += $before - $after;
    echo "WEBP  {$path}: " . humanSize($before) . ' -> ' . humanSize($after) . "\n";

    return true;
}

function optimizeJpeg(string $path): bool
{
    global $quality, $saved, $processed;

    $before = filesize($path);
    $webpPath = preg_replace('/\.jpe?g$/i', '.webp', $path);

    if ($webpPath !== $path && file_exists($webpPath)) {
        return false;
    }

    $dimensions = imageDimensions($path);

    if ($dimensions === null) {
        return false;
    }

    [$width] = $dimensions;
    $maxWidth = maxWidthFor($path);
    $tmp = $path . '.opt.webp';

    if (! runCommand(sprintf(
        'cwebp -quiet -q %d -resize %d 0 %s -o %s 2>/dev/null',
        $quality,
        min($width, $maxWidth),
        escapeshellarg($path),
        escapeshellarg($tmp),
    ))) {
        @unlink($tmp);

        return false;
    }

    $afterWebp = filesize($tmp);

    if ($afterWebp > 0 && $afterWebp < $before * 0.9) {
        rename($tmp, $webpPath);
        $processed++;
        $saved += $before - $afterWebp;
        echo "JPG+  {$path}: " . humanSize($before) . ' -> ' . humanSize($afterWebp) . " ({$webpPath})\n";

        return true;
    }

    @unlink($tmp);

    if (runCommand(sprintf('jpegoptim --strip-all --max=%d %s 2>/dev/null', $quality, escapeshellarg($path)))) {
        $after = filesize($path);

        if ($after > 0 && $after < $before) {
            $processed++;
            $saved += $before - $after;
            echo "JPEG {$path}: " . humanSize($before) . ' -> ' . humanSize($after) . "\n";

            return true;
        }
    }

    return false;
}

function optimizePng(string $path): bool
{
    global $saved, $processed;

    if (str_contains($path, 'video-poster') || str_contains($path, 'clip.png')) {
        $before = filesize($path);
        $tmp = $path . '.opt.png';

        if (runCommand(sprintf('pngquant --force --skip-if-larger --quality=70-88 --output %s %s 2>/dev/null', escapeshellarg($tmp), escapeshellarg($path)))) {
            $after = filesize($tmp);

            if ($after > 0 && $after < $before) {
                rename($tmp, $path);
                $processed++;
                $saved += $before - $after;
                echo "PNG  {$path}: " . humanSize($before) . ' -> ' . humanSize($after) . "\n";

                return true;
            }
        }

        @unlink($tmp);
    }

    return false;
}

if (! runCommand('command -v cwebp >/dev/null')) {
    fwrite(STDERR, "cwebp is required\n");
    exit(1);
}

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS),
);

foreach ($iterator as $file) {
    if (! $file->isFile()) {
        continue;
    }

    $path = $file->getPathname();
    $ext = strtolower($file->getExtension());

    if ($ext === 'webp') {
        optimizeWebp($path);
        continue;
    }

    if (in_array($ext, ['jpg', 'jpeg'], true)) {
        optimizeJpeg($path);
        continue;
    }

    if ($ext === 'png') {
        optimizePng($path);
    }
}

echo "\nOptimized {$processed} files, saved " . humanSize($saved) . "\n";
