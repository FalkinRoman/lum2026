<?php

namespace App\Filament\Resources\Villas\Schemas;

use App\Filament\Forms\Locales;
use App\Filament\Forms\LumImage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VillaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Вилла')
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

                Section::make('Бронирование Exely')
                    ->description('Привязка виллы к отелю/типу номера Exely. Пусто → общий /booking.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('exely_hotel_id')
                            ->label('Exely hotel ID')
                            ->helperText('Известные: 502887, 514444')
                            ->maxLength(32),
                        TextInput::make('exely_room_type_id')
                            ->label('Exely room type ID')
                            ->helperText('Deep-link кнопки Book now на этот номер')
                            ->maxLength(32),
                    ]),

                Section::make('Изображения')
                    ->columns(2)
                    ->schema([
                        LumImage::single('listing_image', 'Карточка', 'stay'),
                        LumImage::single('slide_photo', 'Фото слайда', 'villas'),
                        LumImage::single('slide_oval', 'Овал слайда', 'villas'),
                        LumImage::single('hero_image', 'Hero', 'villa'),
                        LumImage::many('gallery_images', 'Галерея', 'villa', 12)
                            ->columnSpanFull(),
                    ]),

                Section::make('Заголовки')
                    ->schema([
                        Locales::text('title_normal', 'Заголовок', required: true),
                        Locales::text('title_italic', 'Заголовок (курсив)'),
                        Locales::text('title_mobile_normal', 'Заголовок mobile'),
                        Locales::text('title_mobile_italic', 'Заголовок mobile (курсив)'),
                        Locales::text('subtitle', 'Подзаголовок'),
                        Locales::text('subtitle_line1', 'Подзаголовок: строка 1'),
                        Locales::text('subtitle_line2', 'Подзаголовок: строка 2'),
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
                        Locales::text('gallery_body_bottom', 'Галерея: текст снизу', textarea: true),
                    ]),

                Section::make('Удобства')
                    ->schema([
                        Locales::tags('facilities_left', 'Удобства (левая колонка)'),
                        Locales::tags('facilities_right', 'Удобства (правая колонка)'),
                    ]),
            ]);
    }
}
