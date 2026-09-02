<?php

namespace App\Filament\Forms;

use App\Support\LumImageOptimizer;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Components\FileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

/**
 * Professional image fields for Lum CMS.
 * Stores relative paths under public/images/lum (disk: lum).
 * Raster uploads are resized ≤1600px and encoded as WebP.
 */
class LumImage
{
    public static function single(
        string $name,
        string $label,
        string $directory = 'uploads',
        ?string $helperText = 'Пусто = изображение не задано. Загрузите файл — появится миниатюра. Сохранится WebP ≤1600px.',
        bool $editor = false,
    ): FileUpload {
        $field = FileUpload::make($name)
            ->label($label)
            ->disk('lum')
            ->directory($directory)
            ->visibility('public')
            ->image()
            ->acceptedFileTypes([
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
            ])
            ->imageResizeMode('max')
            ->imageResizeTargetWidth(LumImageOptimizer::MAX_EDGE)
            ->imageResizeTargetHeight(LumImageOptimizer::MAX_EDGE)
            ->imageResizeUpscale(false)
            ->maxSize(2048)
            ->imagePreviewHeight('180')
            ->panelLayout('integrated')
            ->uploadProgressIndicatorPosition('center')
            ->loadingIndicatorPosition('center')
            ->removeUploadedFileButtonPosition('right')
            ->uploadButtonPosition('center')
            ->openable()
            ->downloadable()
            ->nullable();

        self::applyOptimizer($field);

        if ($helperText !== null) {
            $field->helperText($helperText);
        }

        if ($editor) {
            $field->imageEditor();
        }

        return $field;
    }

    public static function many(
        string $name,
        string $label,
        string $directory = 'uploads',
        int $max = 16,
    ): FileUpload {
        $field = FileUpload::make($name)
            ->label($label)
            ->disk('lum')
            ->directory($directory)
            ->visibility('public')
            ->image()
            ->acceptedFileTypes([
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
            ])
            ->imageResizeMode('max')
            ->imageResizeTargetWidth(LumImageOptimizer::MAX_EDGE)
            ->imageResizeTargetHeight(LumImageOptimizer::MAX_EDGE)
            ->imageResizeUpscale(false)
            ->maxSize(2048)
            ->multiple()
            ->reorderable()
            ->maxFiles($max)
            ->imagePreviewHeight('120')
            ->panelLayout('grid')
            ->uploadProgressIndicatorPosition('center')
            ->loadingIndicatorPosition('center')
            ->helperText('Каждый файл → WebP ≤1600px (удобно для скролла).');

        self::applyOptimizer($field);

        return $field;
    }

    private static function applyOptimizer(FileUpload $field): void
    {
        $field->saveUploadedFileUsing(static function (BaseFileUpload $component, TemporaryUploadedFile $file): ?string {
            $directory = trim((string) $component->getDirectory(), '/');
            $disk = $component->getDiskName();

            $path = LumImageOptimizer::store($file, $directory, $disk);

            if ($path && $component->getVisibility() === 'public') {
                rescue(fn () => $component->getDisk()->setVisibility($path, 'public'), report: false);
            }

            return $path;
        });
    }
}
