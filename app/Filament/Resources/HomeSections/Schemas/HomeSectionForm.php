<?php

namespace App\Filament\Resources\HomeSections\Schemas;

use App\Filament\Forms\LumImage;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HomeSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Секция главной')
                    ->schema([
                        TextInput::make('key')
                            ->label('Ключ')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('hero, polaroids, location, interior, shop_teaser, villas_intro'),
                    ]),

                Section::make('Изображения секции')
                    ->description('Миниатюра если файл есть, пустая зона если нет. Загрузка с прогрессом.')
                    ->columns(2)
                    ->schema([
                        LumImage::single('images.shop_bg', 'Фон блока Shop', 'shop')
                            ->visible(fn ($get) => $get('key') === 'shop_teaser')
                            ->columnSpanFull(),

                        LumImage::single('images.hero_poster', 'Постер hero-видео', 'hero')
                            ->visible(fn ($get) => $get('key') === 'hero')
                            ->columnSpanFull(),

                        LumImage::single('images.polaroid_1', 'Полароид 1', 'polaroids')
                            ->visible(fn ($get) => $get('key') === 'polaroids'),
                        LumImage::single('images.polaroid_2', 'Полароид 2', 'polaroids')
                            ->visible(fn ($get) => $get('key') === 'polaroids'),
                        LumImage::single('images.polaroid_3', 'Полароид 3', 'polaroids')
                            ->visible(fn ($get) => $get('key') === 'polaroids'),

                        LumImage::single('images.location_0_photo', 'Карточка 1 — фото', 'location')
                            ->visible(fn ($get) => $get('key') === 'location'),
                        LumImage::single('images.location_0_active', 'Карточка 1 — иконка/актив', 'location')
                            ->visible(fn ($get) => $get('key') === 'location'),
                        LumImage::single('images.location_1_photo', 'Карточка 2 — фото', 'location')
                            ->visible(fn ($get) => $get('key') === 'location'),
                        LumImage::single('images.location_1_active', 'Карточка 2 — иконка/актив', 'location')
                            ->visible(fn ($get) => $get('key') === 'location'),
                        LumImage::single('images.location_2_photo', 'Карточка 3 — фото', 'location')
                            ->visible(fn ($get) => $get('key') === 'location'),
                        LumImage::single('images.location_2_active', 'Карточка 3 — иконка/актив', 'location')
                            ->visible(fn ($get) => $get('key') === 'location'),
                    ]),

                Section::make('Данные (JSON)')
                    ->schema([
                        Textarea::make('payload')
                            ->label('Payload')
                            ->rows(18)
                            ->required()
                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $state)
                            ->dehydrateStateUsing(fn ($state) => is_array($state) ? $state : (json_decode((string) $state, true) ?? []))
                            ->helperText('Тексты EN/RU. Картинки лучше грузить блоком выше — они подставятся в payload при сохранении.'),
                    ]),
            ]);
    }
}
