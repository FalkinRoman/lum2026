<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Throwable;

/**
 * Resize + WebP encode CMS uploads for scroll-friendly delivery.
 * Also builds on-demand display derivatives for legacy multi‑MB uploads.
 */
final class LumImageOptimizer
{
    public const MAX_EDGE = 1600;

    public const WEBP_QUALITY = 82;

    /** Skip re-encode when already webp and within budget. */
    private const SMALL_WEBP_BYTES = 450_000;

    public static function store(TemporaryUploadedFile $file, string $directory, string $disk = 'lum'): ?string
    {
        $directory = trim($directory, '/');
        $mime = (string) ($file->getMimeType() ?: '');
        $extension = strtolower((string) $file->getClientOriginalExtension());

        if (
            str_contains($mime, 'svg')
            || $extension === 'svg'
            || str_contains($mime, 'gif')
            || $extension === 'gif'
        ) {
            return self::storeOriginal($file, $directory, $disk, $extension !== '' ? $extension : 'bin');
        }

        try {
            $binary = file_get_contents($file->getRealPath());

            if ($binary === false || $binary === '') {
                return self::storeOriginal($file, $directory, $disk, $extension !== '' ? $extension : 'jpg');
            }

            $source = @imagecreatefromstring($binary);

            if ($source === false) {
                return self::storeOriginal($file, $directory, $disk, $extension !== '' ? $extension : 'jpg');
            }

            $relative = ($directory !== '' ? $directory.'/' : '').(string) Str::ulid().'.webp';
            $absolute = Storage::disk($disk)->path($relative);

            if (! self::writeImage($source, $absolute, self::MAX_EDGE)) {
                imagedestroy($source);

                return self::storeOriginal($file, $directory, $disk, $extension !== '' ? $extension : 'jpg');
            }

            return $relative;
        } catch (Throwable) {
            return self::storeOriginal($file, $directory, $disk, $extension !== '' ? $extension : 'jpg');
        }
    }

    /**
     * Relative path under images/lum suitable for <img src>.
     * Oversized legacy JPG/PNG → .derived/{edge}/…/*.webp
     */
    public static function displayRelative(string $relative, int $maxEdge = self::MAX_EDGE): string
    {
        $relative = ltrim(str_replace('\\', '/', $relative), '/');

        if ($relative === '' || str_contains($relative, '..') || str_starts_with($relative, '.derived/')) {
            return $relative;
        }

        $extension = strtolower((string) pathinfo($relative, PATHINFO_EXTENSION));

        if ($extension === '' || in_array($extension, ['svg', 'gif'], true)) {
            return $relative;
        }

        $root = rtrim(Storage::disk('lum')->path(''), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
        $source = $root.str_replace('/', DIRECTORY_SEPARATOR, $relative);

        if (! is_file($source)) {
            return $relative;
        }

        $size = @getimagesize($source);
        $bytes = (int) @filesize($source);
        $edge = is_array($size) ? max((int) ($size[0] ?? 0), (int) ($size[1] ?? 0)) : 0;

        if (
            $extension === 'webp'
            && $edge > 0
            && $edge <= $maxEdge
            && $bytes > 0
            && $bytes <= self::SMALL_WEBP_BYTES
        ) {
            return $relative;
        }

        if ($edge > 0 && $edge <= $maxEdge && $bytes > 0 && $bytes <= self::SMALL_WEBP_BYTES && $extension === 'jpg') {
            // small jpg still fine for scroll; keep original
            return $relative;
        }

        $stem = preg_replace('/\.[^.]+$/', '', $relative) ?: $relative;
        $derivedRel = '.derived/'.$maxEdge.'/'.$stem.'.webp';
        $derivedAbs = $root.str_replace('/', DIRECTORY_SEPARATOR, $derivedRel);

        if (is_file($derivedAbs) && filemtime($derivedAbs) >= filemtime($source)) {
            return $derivedRel;
        }

        $binary = @file_get_contents($source);

        if ($binary === false) {
            return $relative;
        }

        $image = @imagecreatefromstring($binary);

        if ($image === false) {
            return $relative;
        }

        if (! self::writeImage($image, $derivedAbs, $maxEdge)) {
            return $relative;
        }

        return $derivedRel;
    }

    /**
     * Warm derivatives for every raster under the lum disk.
     *
     * @return array{scanned: int, built: int, skipped: int, failed: int}
     */
    public static function warmAll(int $maxEdge = self::MAX_EDGE): array
    {
        $root = rtrim(Storage::disk('lum')->path(''), DIRECTORY_SEPARATOR);
        $stats = ['scanned' => 0, 'built' => 0, 'skipped' => 0, 'failed' => 0];

        if (! is_dir($root)) {
            return $stats;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS),
        );

        foreach ($iterator as $file) {
            if (! $file instanceof \SplFileInfo || ! $file->isFile()) {
                continue;
            }

            $absolute = $file->getPathname();

            if (str_contains($absolute, DIRECTORY_SEPARATOR.'.derived'.DIRECTORY_SEPARATOR)) {
                continue;
            }

            $relative = ltrim(str_replace('\\', '/', substr($absolute, strlen($root))), '/');
            $extension = strtolower($file->getExtension());

            if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                continue;
            }

            $stats['scanned']++;
            $before = self::displayRelative($relative, $maxEdge);

            if ($before === $relative) {
                $stats['skipped']++;
            } elseif (str_starts_with($before, '.derived/')) {
                $stats['built']++;
            } else {
                $stats['failed']++;
            }
        }

        return $stats;
    }

    private static function storeOriginal(
        TemporaryUploadedFile $file,
        string $directory,
        string $disk,
        string $extension,
    ): ?string {
        $name = (string) Str::ulid().'.'.$extension;

        return $file->storeAs($directory, $name, $disk) ?: null;
    }

    /**
     * @param  \GdImage  $source
     */
    private static function writeImage($source, string $absolute, int $maxEdge): bool
    {
        try {
            $width = imagesx($source);
            $height = imagesy($source);
            $canvas = self::fitToMaxEdge($source, $width, $height, $maxEdge);

            if ($canvas !== $source) {
                imagedestroy($source);
            }

            if (! imageistruecolor($canvas)) {
                $true = imagecreatetruecolor(imagesx($canvas), imagesy($canvas));
                imagealphablending($true, false);
                imagesavealpha($true, true);
                $transparent = imagecolorallocatealpha($true, 0, 0, 0, 127);
                imagefilledrectangle($true, 0, 0, imagesx($canvas), imagesy($canvas), $transparent);
                imagecopy($true, $canvas, 0, 0, 0, 0, imagesx($canvas), imagesy($canvas));
                imagedestroy($canvas);
                $canvas = $true;
            }

            imagealphablending($canvas, true);
            imagesavealpha($canvas, true);

            $parent = dirname($absolute);

            if (! is_dir($parent)) {
                mkdir($parent, 0755, true);
            }

            $ok = imagewebp($canvas, $absolute, self::WEBP_QUALITY);
            imagedestroy($canvas);

            return $ok && is_file($absolute);
        } catch (Throwable) {
            return false;
        }
    }

    /**
     * @param  \GdImage  $source
     * @return \GdImage
     */
    private static function fitToMaxEdge($source, int $width, int $height, int $maxEdge)
    {
        if ($width <= $maxEdge && $height <= $maxEdge) {
            return $source;
        }

        $scale = min($maxEdge / max($width, 1), $maxEdge / max($height, 1));
        $targetW = max(1, (int) round($width * $scale));
        $targetH = max(1, (int) round($height * $scale));

        $canvas = imagecreatetruecolor($targetW, $targetH);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefilledrectangle($canvas, 0, 0, $targetW, $targetH, $transparent);
        imagealphablending($canvas, true);
        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $targetW, $targetH, $width, $height);

        return $canvas;
    }
}
