<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use RuntimeException;
use Throwable;
use ZipArchive;

class SiteBackup
{
    public static function directory(): string
    {
        $dir = storage_path('app/backups');

        if (! is_dir($dir)) {
            File::makeDirectory($dir, 0775, true);
        }

        return $dir;
    }

    /**
     * @return list<array{name: string, path: string, size: int, modified_at: int}>
     */
    public static function list(): array
    {
        $dir = self::directory();
        $files = File::glob($dir.'/lum-backup-*.zip') ?: [];

        $items = array_map(static function (string $path): array {
            return [
                'name' => basename($path),
                'path' => $path,
                'size' => (int) filesize($path),
                'modified_at' => (int) filemtime($path),
            ];
        }, $files);

        usort($items, static fn (array $a, array $b): int => $b['modified_at'] <=> $a['modified_at']);

        return $items;
    }

    public static function path(string $name): string
    {
        $name = basename($name);

        if (! preg_match('/^lum-backup-\d{4}-\d{2}-\d{2}-\d{6}\.zip$/', $name)) {
            throw new RuntimeException('Invalid backup filename.');
        }

        $path = self::directory().DIRECTORY_SEPARATOR.$name;

        if (! is_file($path)) {
            throw new RuntimeException('Backup not found.');
        }

        return $path;
    }

    /**
     * Create a ZIP with SQLite DB + CMS uploads (not application source code).
     *
     * @return array{name: string, path: string, size: int}
     */
    public static function create(): array
    {
        $dir = self::directory();
        $stamp = now()->format('Y-m-d-His');
        $name = "lum-backup-{$stamp}.zip";
        $zipPath = $dir.DIRECTORY_SEPARATOR.$name;
        $tmpDir = $dir.DIRECTORY_SEPARATOR.'.tmp-'.$stamp;

        File::makeDirectory($tmpDir, 0775, true);

        try {
            self::exportDatabase($tmpDir.DIRECTORY_SEPARATOR.'database.sqlite');

            $uploadsSrc = storage_path('app/lum-writable');
            $uploadsDst = $tmpDir.DIRECTORY_SEPARATOR.'uploads';

            if (is_dir($uploadsSrc)) {
                File::copyDirectory($uploadsSrc, $uploadsDst);
            } else {
                File::makeDirectory($uploadsDst, 0775, true);
            }

            File::put($tmpDir.DIRECTORY_SEPARATOR.'manifest.json', json_encode([
                'created_at' => now()->toIso8601String(),
                'app_url' => (string) config('app.url'),
                'app_env' => (string) config('app.env'),
                'contains' => [
                    'database.sqlite' => 'CMS database (pages, settings, villas, users, …)',
                    'uploads/' => 'Images uploaded via admin (public/images/lum → storage/app/lum-writable)',
                ],
                'note' => 'This is a content backup, not the full Laravel codebase. Source code lives in git.',
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

            $zip = new ZipArchive;

            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new RuntimeException('Cannot create ZIP archive.');
            }

            self::addDirectoryToZip($zip, $tmpDir, '');
            $zip->close();
        } catch (Throwable $e) {
            if (is_file($zipPath)) {
                @unlink($zipPath);
            }

            throw $e;
        } finally {
            File::deleteDirectory($tmpDir);
        }

        return [
            'name' => $name,
            'path' => $zipPath,
            'size' => (int) filesize($zipPath),
        ];
    }

    public static function delete(string $name): void
    {
        $path = self::path($name);
        File::delete($path);
    }

    /**
     * Keep only the newest $keep ZIP files.
     */
    public static function prune(int $keep = 14): int
    {
        if ($keep < 1) {
            return 0;
        }

        $items = self::list();
        $removed = 0;

        foreach (array_slice($items, $keep) as $item) {
            File::delete($item['path']);
            $removed++;
        }

        return $removed;
    }

    private static function exportDatabase(string $destination): void
    {
        $source = (string) config('database.connections.sqlite.database');

        if ($source === '' || ! is_file($source)) {
            throw new RuntimeException('SQLite database file not found.');
        }

        // Consistent snapshot when sqlite3 CLI is available.
        $escapedSource = escapeshellarg($source);
        $escapedDest = escapeshellarg($destination);
        $cmd = "sqlite3 {$escapedSource} ".escapeshellarg('.backup '.$destination).' 2>/dev/null';

        exec($cmd, $output, $code);

        if ($code === 0 && is_file($destination) && filesize($destination) > 0) {
            return;
        }

        if (! @copy($source, $destination)) {
            throw new RuntimeException('Failed to copy SQLite database.');
        }
    }

    private static function addDirectoryToZip(ZipArchive $zip, string $directory, string $prefix): void
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST,
        );

        foreach ($iterator as $file) {
            /** @var \SplFileInfo $file */
            $absolute = $file->getPathname();
            $relative = ltrim($prefix.substr($absolute, strlen($directory)), '/\\');
            $relative = str_replace('\\', '/', $relative);

            if ($file->isDir()) {
                $zip->addEmptyDir($relative);

                continue;
            }

            $zip->addFile($absolute, $relative);
        }
    }
}
