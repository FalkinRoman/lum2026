<?php

namespace App\Filament\Resources\PageSections\Schemas\Sections;

use App\Filament\Forms\LumImage;
use Filament\Schemas\Components\Section;

class MediaForm
{
    /**
     * Hero + oval (и опционально breakpoint-hero для Relax).
     * Порядок как на странице: сначала большое фото, потом овал.
     *
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    public static function schema(string $mediaDir = 'dining', bool $breakpointHeroes = false): array
    {
        $images = [];

        if ($breakpointHeroes) {
            $images[] = LumImage::single(
                'hero_image_mob',
                'Фото (mobile)',
                $mediaDir,
                helperText: 'Пусто = берётся desktop / stub.',
            );
            $images[] = LumImage::single(
                'hero_image_tab',
                'Фото (tablet)',
                $mediaDir,
                helperText: 'Пусто = берётся desktop / stub.',
            );
            $images[] = LumImage::single(
                'hero_image',
                'Фото (desktop)',
                $mediaDir,
                helperText: 'Пусто = тёмный stub.',
            );
        } else {
            $images[] = LumImage::single(
                'hero_image',
                'Большое фото',
                $mediaDir,
                helperText: 'Пусто = тёмный stub.',
            );
        }

        $images[] = LumImage::single(
            'oval_image',
            'Овал',
            $mediaDir,
            helperText: 'Пусто = тёмный stub.',
        );

        return [
            Section::make('Изображения')
                ->description('Как на странице: сначала фото, поверх — овал.')
                ->columnSpanFull()
                ->schema($images),
        ];
    }
}
