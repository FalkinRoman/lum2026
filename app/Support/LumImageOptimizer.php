<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Throwable;

/**
 * Resize + WebP encode CMS uploads for scroll-friendly delivery.
 * SVG/GIF pass through unchanged.
 */
final class LumImageOptimizer
{
    public const MAX_EDGE = 1600;

    public const WEBP_QUALITY = 82;

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

            $width = imagesx($source);
            $height = imagesy($source);
            $canvas = self::fitToMaxEdge($source, $width, $height, self::MAX_EDGE);

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

            $relative = ($directory !== '' ? $directory.'/' : '').(string) Str::ulid().'.webp';
            $absolute = Storage::disk($disk)->path($relative);
            $parent = dirname($absolute);

            if (! is_dir($parent)) {
                mkdir($parent, 0755, true);
            }

            $ok = imagewebp($canvas, $absolute, self::WEBP_QUALITY);
            imagedestroy($canvas);

            if (! $ok || ! is_file($absolute)) {
                return self::storeOriginal($file, $directory, $disk, $extension !== '' ? $extension : 'jpg');
            }

            return $relative;
        } catch (Throwable) {
            return self::storeOriginal($file, $directory, $disk, $extension !== '' ? $extension : 'jpg');
        }
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
