<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\FileUpload;

/**
 * Professional image fields for Lum CMS.
 * Stores relative paths under public/images/lum (disk: lum).
 */
class LumImage
{
    public static function single(string $name, string $label, string $directory = 'uploads'): FileUpload
    {
        return FileUpload::make($name)
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
                'image/svg+xml',
            ])
            ->maxSize(12288)
            ->imagePreviewHeight('180')
            ->panelLayout('integrated')
            ->uploadProgressIndicatorPosition('center')
            ->loadingIndicatorPosition('center')
            ->removeUploadedFileButtonPosition('right')
            ->uploadButtonPosition('center')
            ->openable()
            ->downloadable()
            ->nullable()
            ->helperText('Пусто = изображение не задано. Загрузите файл — появится миниатюра.');
    }

    public static function many(
        string $name,
        string $label,
        string $directory = 'uploads',
        int $max = 16,
    ): FileUpload {
        return FileUpload::make($name)
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
                'image/svg+xml',
            ])
            ->maxSize(12288)
            ->multiple()
            ->reorderable()
            ->maxFiles($max)
            ->imagePreviewHeight('120')
            ->panelLayout('grid')
            ->uploadProgressIndicatorPosition('center')
            ->loadingIndicatorPosition('center')
            ->openable()
            ->downloadable()
            ->nullable()
            ->helperText('Можно несколько. Пустой список = нет изображений. Перетаскивайте для порядка.');
    }
}
