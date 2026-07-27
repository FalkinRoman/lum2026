<?php

namespace App\Filament\Resources\Activities\Schemas;

use App\Filament\Forms\Locales;
use App\Filament\Forms\LumImage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Активность')
                    ->columns(2)
                    ->schema([
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('sort_order')
                            ->label('Порядок')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),
                        Toggle::make('is_published')
                            ->label('Опубликовано')
                            ->default(true),
                    ]),

                Section::make('Изображения')
                    ->columns(2)
                    ->schema([
                        LumImage::single('listing_image', 'Карточка', 'relax'),
                        LumImage::single('hero_image', 'Hero', 'relax/detail'),
                        LumImage::single('oval_image', 'Овал', 'relax/detail'),
                        LumImage::many('gallery_images', 'Галерея', 'relax/detail', 12)
                            ->columnSpanFull(),
                    ]),

                Section::make('Заголовки')
                    ->schema([
                        Locales::text('label_before', 'Лейбл: до'),
                        Locales::text('label_italic', 'Лейбл: курсив'),
                        Locales::text('label_after', 'Лейбл: после'),
                        Locales::text('name', 'Название', required: true),
                        Locales::text('meta_title', 'Meta title'),
                    ]),

                Section::make('Hero')
                    ->schema([
                        Locales::text('hero_eyebrow', 'Hero надзаголовок'),
                        Locales::text('hero_title_normal', 'Hero заголовок'),
                        Locales::text('hero_title_italic', 'Hero заголовок (курсив)'),
                    ]),

                Section::make('Галерея')
                    ->schema([
                        Locales::text('gallery_eyebrow', 'Галерея: надзаголовок'),
                        Locales::text('gallery_title_normal', 'Галерея: заголовок'),
                        Locales::text('gallery_title_italic', 'Галерея: заголовок (курсив)'),
                        Locales::text('gallery_body', 'Галерея: текст', textarea: true),
                    ]),

                Section::make('Цитата')
                    ->schema([
                        Locales::text('quote_line1', 'Цитата: строка 1'),
                        Locales::text('quote_line2', 'Цитата: строка 2'),
                        Locales::text('quote_note', 'Цитата: примечание'),
                    ]),

                Section::make('Цены')
                    ->columns(2)
                    ->schema([
                        TextInput::make('pricing_cta_url')
                            ->label('URL кнопки прайсинга')
                            ->url()
                            ->columnSpanFull(),
                        Locales::text('pricing_eyebrow', 'Цены: надзаголовок'),
                        Locales::text('pricing_title_normal', 'Цены: заголовок'),
                        Locales::text('pricing_title_italic', 'Цены: заголовок (курсив)'),
                        Locales::text('pricing_cta', 'Цены: CTA'),
                        Locales::json('pricing_items', 'Позиции прайса')->columnSpanFull(),
                    ]),
            ]);
    }
}
