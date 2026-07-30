<?php

namespace App\Filament\Resources\Villas\Schemas;

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

class VillaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Вилла')
                    ->description('Служебные поля. Create / delete — из списка и шапки.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('URL: /stay/{slug}'),
                        TextInput::make('sort_order')
                            ->label('Порядок')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),
                        Toggle::make('is_published')
                            ->label('Опубликовано')
                            ->default(true),
                        Locales::text('meta_title', 'Meta title')
                            ->columnSpanFull(),
                    ]),

                Section::make('1. Карточка на /stay')
                    ->description('Как карточка на листинге Stay.')
                    ->schema([
                        LumImage::single('listing_image', 'Фото карточки', 'stay'),
                        Locales::text('title_normal', 'Заголовок', required: true),
                        Locales::text('title_italic', 'Заголовок (курсив)'),
                        Locales::text('subtitle', 'Подзаголовок', textarea: true),
                    ]),

                Section::make('2. Hero страницы')
                    ->description('Верх detail /stay/{slug}.')
                    ->schema([
                        LumImage::single('hero_image', 'Большое фото', 'villa'),
                        Locales::text('hero_eyebrow', 'Надзаголовок'),
                        Locales::text('hero_title_normal', 'Заголовок'),
                        Locales::text('hero_title_italic', 'Заголовок (курсив)'),
                    ]),

                Section::make('3. Бронирование Exely')
                    ->description('Привязка страницы виллы к отелю в Exely. Виджет «Book online» откроется сразу с этой виллой.')
                    ->schema([
                        Select::make('exely_hotel_id')
                            ->label('Вилла в Exely')
                            ->options(fn (): array => \App\Support\Exely::hotelOptions())
                            ->searchable()
                            ->nullable()
                            ->placeholder('— Общий поиск (все) —')
                            ->helperText('Модификатор hotel_id для виджета. Пусто = мульти-поиск как на /stay.'),
                    ]),

                Section::make('4. Галерея')
                    ->description('Тексты + до 3 полароидов (фото + дата). Desktop — 3, mobile/tablet — первые 2.')
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
                                LumImage::single('path', 'Фото', 'villa', helperText: null),
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

                Section::make('5. Удобства')
                    ->description('Как блок Facilities на detail.')
                    ->schema([
                        Locales::text('facilities_eyebrow', 'Надзаголовок'),
                        Locales::text('facilities_title_normal', 'Заголовок'),
                        Locales::text('facilities_title_italic', 'Заголовок (курсив)'),
                        LumImage::single('facilities_image_left', 'Фото слева', 'villa'),
                        LumImage::single('facilities_image_right', 'Фото справа', 'villa'),
                        Locales::tags('facilities_left', 'Список слева'),
                        Locales::tags('facilities_right', 'Список справа'),
                    ]),

                Section::make('6. Impression')
                    ->description('Каждый таб = своя галерея. Клик по табу переключает слайды. Таб без картинок не показывается.')
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
                                LumImage::many('images', 'Слайды таба', 'villa/impression', 12),
                            ])
                            ->itemLabel(fn (array $state): ?string => data_get($state, 'label.en')
                                ?: data_get($state, 'label.ru')
                                ?: 'Таб')
                            ->columnSpanFull(),
                        Locales::text('impression_cta', 'Текст кнопки'),
                        Select::make('impression_cta_mode')
                            ->label('Куда ведёт кнопка')
                            ->options([
                                'villa' => 'Бронирование этой виллы (/booking + Exely hotel)',
                                'site' => 'Как Take a break в настройках сайта',
                                'custom' => 'Своя ссылка',
                            ])
                            ->default('villa')
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
