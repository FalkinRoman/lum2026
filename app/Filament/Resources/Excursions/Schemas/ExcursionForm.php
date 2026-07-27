<?php

namespace App\Filament\Resources\Excursions\Schemas;

use App\Filament\Forms\Locales;
use App\Filament\Forms\LumImage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExcursionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Экскурсия')
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
                        TextInput::make('book_url')
                            ->label('URL бронирования')
                            ->url(),
                    ]),

                Section::make('Изображения')
                    ->columns(2)
                    ->schema([
                        LumImage::single('listing_image', 'Карточка', 'discover'),
                        LumImage::single('oval_image', 'Овал', 'discover/detail'),
                        LumImage::single('wellness_hero', 'Wellness hero', 'discover/detail'),
                        LumImage::many('gallery_images', 'Галерея', 'discover/detail', 12)
                            ->columnSpanFull(),
                        LumImage::many('package_images', 'Изображения пакета', 'discover/detail', 8)
                            ->columnSpanFull(),
                    ]),

                Section::make('Заголовки')
                    ->schema([
                        Locales::text('title', 'Заголовок', required: true),
                        Locales::text('region', 'Регион'),
                        Locales::text('meta_title', 'Meta title'),
                        Locales::text('intro_title', 'Intro заголовок'),
                        Locales::text('intro_body', 'Intro текст', textarea: true),
                    ]),

                Section::make('Галерея')
                    ->schema([
                        Locales::text('gallery_eyebrow', 'Галерея: надзаголовок'),
                        Locales::text('gallery_title_normal', 'Галерея: заголовок'),
                        Locales::text('gallery_title_italic', 'Галерея: заголовок (курсив)'),
                        Locales::tags('polaroid_dates', 'Даты на полароидах'),
                    ]),

                Section::make('Пакет')
                    ->schema([
                        Locales::text('package_eyebrow', 'Пакет: надзаголовок'),
                        Locales::text('package_title_normal', 'Пакет: заголовок'),
                        Locales::text('package_title_italic', 'Пакет: заголовок (курсив)'),
                        Locales::text('package_cost', 'Стоимость пакета'),
                        Locales::json('package_items', 'Пункты пакета')->columnSpanFull(),
                    ]),
            ]);
    }
}
