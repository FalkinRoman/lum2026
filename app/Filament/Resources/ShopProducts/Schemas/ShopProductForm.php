<?php

namespace App\Filament\Resources\ShopProducts\Schemas;

use App\Filament\Forms\Locales;
use App\Filament\Forms\LumImage;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ShopProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Товар')
                    ->columns(2)
                    ->schema([
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('type')
                            ->label('Тип')
                            ->default('tee')
                            ->required(),
                        TextInput::make('sort_order')
                            ->label('Порядок')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),
                        Toggle::make('is_published')
                            ->label('Опубликовано')
                            ->default(true),
                        TextInput::make('price')->label('Цена'),
                        TextInput::make('cta_label')
                            ->label('Текст CTA'),
                    ]),

                Section::make('Изображения и опции')
                    ->columns(2)
                    ->schema([
                        LumImage::single('image', 'Главное изображение', 'shop/products')
                            ->columnSpanFull(),
                        LumImage::many('thumbs', 'Превью / галерея', 'shop/products/thumbs', 8)
                            ->columnSpanFull(),
                        LumImage::many('colors', 'Цвета (иконки)', 'shop/products/colors', 8),
                        TagsInput::make('sizes')->label('Размеры'),
                    ]),

                Section::make('Заголовки')
                    ->schema([
                        Locales::text('title', 'Заголовок', required: true),
                        Locales::text('subtitle', 'Подзаголовок'),
                    ]),
            ]);
    }
}
