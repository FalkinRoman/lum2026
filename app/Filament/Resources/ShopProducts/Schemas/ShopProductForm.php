<?php

namespace App\Filament\Resources\ShopProducts\Schemas;

use App\Filament\Forms\Locales;
use App\Filament\Forms\LumImage;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
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
            ->columns(1)
            ->components([
                Section::make('1. Товар')
                    ->description('Тип задаёт layout карточки: tee = цвета/размеры, cup = проще.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Служебный ключ в каталоге /shop'),
                        Select::make('type')
                            ->label('Тип карточки')
                            ->options([
                                'tee' => 'Tee — с цветами и размерами',
                                'cup' => 'Cup — без цветов/размеров',
                            ])
                            ->default('tee')
                            ->live()
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
                    ]),

                Section::make('2. Медиа')
                    ->description('Главное фото + превью под ним (клик меняет главное).')
                    ->schema([
                        LumImage::single('image', 'Главное изображение', 'shop/products'),
                        LumImage::many('thumbs', 'Превью / галерея', 'shop/products/thumbs', 8)
                            ->columnSpanFull(),
                    ]),

                Section::make('3. Тексты')
                    ->schema([
                        Locales::text('title', 'Заголовок', required: true),
                        Locales::text('subtitle', 'Подзаголовок'),
                    ]),

                Section::make('4. Опции tee')
                    ->description('Только для типа Tee. Cup эти поля игнорирует. Цвет: hex-пикер или SVG/PNG свотч.')
                    ->visible(fn ($get): bool => $get('type') === 'tee')
                    ->schema([
                        Repeater::make('colors')
                            ->label('Цвета')
                            ->reorderable()
                            ->defaultItems(0)
                            ->addActionLabel('Добавить цвет')
                            ->schema([
                                Select::make('kind')
                                    ->label('Тип')
                                    ->options([
                                        'hex' => 'Цвет (hex / пикер)',
                                        'image' => 'Изображение (свотч)',
                                    ])
                                    ->default('hex')
                                    ->live()
                                    ->required(),
                                ColorPicker::make('hex')
                                    ->label('Цвет')
                                    ->hex()
                                    ->visible(fn ($get): bool => $get('kind') === 'hex')
                                    ->required(fn ($get): bool => $get('kind') === 'hex'),
                                LumImage::single('image', 'Свотч', 'shop/products/colors', helperText: null)
                                    ->visible(fn ($get): bool => $get('kind') === 'image')
                                    ->required(fn ($get): bool => $get('kind') === 'image'),
                            ])
                            ->itemLabel(function (array $state): ?string {
                                if (($state['kind'] ?? '') === 'hex' && filled($state['hex'] ?? null)) {
                                    return (string) $state['hex'];
                                }
                                if (filled($state['image'] ?? null)) {
                                    return basename((string) $state['image']);
                                }

                                return 'Цвет';
                            })
                            ->columnSpanFull(),
                        TagsInput::make('sizes')
                            ->label('Размеры')
                            ->placeholder('S, M, L…')
                            ->helperText('Enter — добавить размер'),
                    ]),

                Section::make('5. CTA')
                    ->description('Кнопка на карточке. Пустой текст → цена. Пустой URL → WhatsApp из настроек сайта.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('price')
                            ->label('Цена')
                            ->placeholder('44$'),
                        TextInput::make('cta_label')
                            ->label('Текст кнопки')
                            ->placeholder('Пусто = цена'),
                        TextInput::make('cta_url')
                            ->label('Ссылка кнопки')
                            ->url()
                            ->placeholder('https://wa.me/… или /path')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
