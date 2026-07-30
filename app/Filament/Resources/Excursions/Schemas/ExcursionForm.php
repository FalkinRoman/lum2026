<?php

namespace App\Filament\Resources\Excursions\Schemas;

use App\Filament\Forms\Locales;
use App\Filament\Forms\LumImage;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ExcursionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Экскурсия')
                    ->description('Служебные поля. Create / delete — из списка и шапки.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('URL: /discover/{slug}'),
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
                            ->url()
                            ->placeholder('https://wa.me/…'),
                        Locales::text('meta_title', 'Meta title')
                            ->columnSpanFull(),
                    ]),

                Section::make('1. Карточка на /discover')
                    ->schema([
                        LumImage::single('listing_image', 'Фото карточки', 'discover'),
                        Locales::text('title', 'Заголовок', required: true),
                        Locales::text('region', 'Регион'),
                    ]),

                Section::make('2. Intro')
                    ->schema([
                        Locales::text('intro_title', 'Заголовок'),
                        Locales::text('intro_body', 'Текст', textarea: true),
                    ]),

                Section::make('3. Hero media')
                    ->description('Desktop: овал + wellness hero. Mobile/tablet пока shared composites.')
                    ->schema([
                        LumImage::single('oval_image', 'Овал (desktop)', 'discover/detail'),
                        LumImage::single('wellness_hero', 'Wellness hero (desktop)', 'discover/detail'),
                    ]),

                Section::make('4. Галерея')
                    ->description('Тексты + до 3 полароидов (фото + дата).')
                    ->schema([
                        Locales::text('gallery_eyebrow', 'Надзаголовок'),
                        Locales::text('gallery_title_normal', 'Заголовок'),
                        Locales::text('gallery_title_italic', 'Заголовок (курсив)'),
                        Locales::text('gallery_body', 'Текст сверху', textarea: true),
                        Locales::text('gallery_body_bottom', 'Текст снизу', textarea: true),
                        Repeater::make('gallery_images')
                            ->label('Полароиды')
                            ->reorderable()
                            ->maxItems(3)
                            ->defaultItems(0)
                            ->schema([
                                LumImage::single('path', 'Фото', 'discover/detail', helperText: null),
                                TextInput::make('date')
                                    ->label('Дата на полароиде')
                                    ->placeholder('06.08.2023')
                                    ->maxLength(32),
                            ])
                            ->itemLabel(fn (array $state): ?string => filled($state['date'] ?? null)
                                ? (string) $state['date']
                                : 'Полароид')
                            ->columnSpanFull(),
                    ]),

                Section::make('5. Пакет')
                    ->schema([
                        Locales::text('package_eyebrow', 'Надзаголовок'),
                        Locales::text('package_title_normal', 'Заголовок'),
                        Locales::text('package_title_italic', 'Заголовок (курсив)'),
                        Locales::text('package_cost', 'Стоимость'),
                        Locales::stringList(
                            'package_items',
                            'Пункты пакета',
                            addActionLabel: 'Добавить пункт',
                            placeholder: 'Например: Dawn whale watching safari',
                        )->columnSpanFull(),
                        LumImage::many('package_images', 'Фото пакета', 'discover/detail', 2)
                            ->columnSpanFull(),
                    ]),

                Section::make('6. Impression')
                    ->description('Каждый таб = своя галерея. CTA mode: excursion = book_url.')
                    ->schema([
                        Locales::text('impression_title_normal', 'Заголовок (курсивная строка)'),
                        Locales::text('impression_title_caps', 'Заголовок (CAPS)'),
                        Repeater::make('impression_galleries')
                            ->label('Табы и галереи')
                            ->reorderable()
                            ->defaultItems(0)
                            ->schema([
                                Tabs::make('tab_locale')
                                    ->contained(false)
                                    ->tabs([
                                        Tab::make('EN')->schema([
                                            TextInput::make('label.en')->label('Название таба')->required(),
                                        ]),
                                        Tab::make('RU')->schema([
                                            TextInput::make('label.ru')->label('Название таба')->required(),
                                        ]),
                                    ]),
                                LumImage::many('images', 'Слайды таба', 'discover/detail/shared/impression', 12),
                            ])
                            ->itemLabel(fn (array $state): ?string => data_get($state, 'label.en')
                                ?: data_get($state, 'label.ru')
                                ?: 'Таб')
                            ->columnSpanFull(),
                        Locales::text('impression_cta', 'Текст кнопки'),
                        Select::make('impression_cta_mode')
                            ->label('Куда ведёт кнопка')
                            ->options([
                                'excursion' => 'Бронирование экскурсии (book_url)',
                                'site' => 'Как Take a break в настройках сайта',
                                'custom' => 'Своя ссылка',
                            ])
                            ->default('excursion')
                            ->live()
                            ->required(),
                        TextInput::make('impression_cta_url')
                            ->label('Своя ссылка')
                            ->url()
                            ->placeholder('https://… или /path')
                            ->visible(fn ($get): bool => $get('impression_cta_mode') === 'custom')
                            ->required(fn ($get): bool => $get('impression_cta_mode') === 'custom'),
                    ]),
            ]);
    }
}
