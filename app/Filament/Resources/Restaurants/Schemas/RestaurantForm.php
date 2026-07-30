<?php

namespace App\Filament\Resources\Restaurants\Schemas;

use App\Filament\Forms\Locales;
use App\Support\Locales as AppLocales;
use App\Filament\Forms\LumImage;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class RestaurantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Ресторан')
                    ->description('Служебные поля. Create / delete — из списка и шапки. Меню — вкладка Relation Manager ниже.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('URL: /dining/{slug}'),
                        TextInput::make('sort_order')
                            ->label('Порядок')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),
                        Toggle::make('is_published')
                            ->label('Опубликовано')
                            ->default(true),
                        Toggle::make('opening_soon')
                            ->label('Скоро открытие'),
                        Locales::text('meta_title', 'Meta title')
                            ->columnSpanFull(),
                    ]),

                Section::make('1. Карточка на /dining')
                    ->description('Как карточка на листинге Dining.')
                    ->schema([
                        LumImage::single('listing_image', 'Фото карточки', 'dining'),
                        Locales::text('eyebrow', 'Надзаголовок'),
                        Locales::text('subtitle', 'Подзаголовок', textarea: true),
                        Locales::text('title_normal', 'Заголовок', required: true),
                        Locales::text('title_italic', 'Заголовок (курсив)'),
                    ]),

                Section::make('2. Hero страницы')
                    ->description('Верх detail /dining/{slug}.')
                    ->schema([
                        LumImage::single('hero_image', 'Большое фото', 'dining/detail'),
                        LumImage::single('oval_image', 'Овал', 'dining/detail'),
                        Locales::text('hero_eyebrow', 'Надзаголовок'),
                        Locales::text('hero_title_normal', 'Заголовок'),
                        Locales::text('hero_title_italic', 'Заголовок (курсив)'),
                    ]),

                Section::make('3. Галерея')
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
                                LumImage::single('path', 'Фото', 'dining/detail', helperText: null),
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

                Section::make('4. Меню (тексты секции)')
                    ->description('Категории и позиции — во вкладке «Меню — категории» на Edit.')
                    ->schema([
                        Locales::text('menu_eyebrow', 'Надзаголовок'),
                        Locales::text('menu_title_normal', 'Заголовок'),
                        Locales::text('menu_title_italic', 'Заголовок (курсив)'),
                    ]),

                Section::make('5. Impression')
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
                                    ->tabs(array_map(
                                        fn (string $locale) => Tab::make(AppLocales::label($locale))->schema([
                                            TextInput::make("label.{$locale}")
                                                ->label('Название таба')
                                                ->required($locale === 'en'),
                                        ]),
                                        AppLocales::codes(),
                                    )),
                                LumImage::many('images', 'Слайды таба', 'dining/detail/shared/impression', 12),
                            ])
                            ->itemLabel(function (array $state): ?string {
                                foreach (AppLocales::codes() as $locale) {
                                    $label = data_get($state, "label.{$locale}");
                                    if (filled($label)) {
                                        return $label;
                                    }
                                }

                                return 'Таб';
                            })
                            ->columnSpanFull(),
                        Locales::text('impression_cta', 'Текст кнопки'),
                        Select::make('impression_cta_mode')
                            ->label('Куда ведёт кнопка')
                            ->options([
                                'restaurant' => 'Бронирование ресторана (book_url)',
                                'site' => 'Как Take a break в настройках сайта',
                                'custom' => 'Своя ссылка',
                            ])
                            ->default('restaurant')
                            ->live()
                            ->required(),
                        TextInput::make('book_url')
                            ->label('URL бронирования ресторана')
                            ->url()
                            ->placeholder('https://wa.me/…')
                            ->helperText('Режим «Бронирование ресторана» и fallback.'),
                        TextInput::make('impression_cta_url')
                            ->label('Своя ссылка')
                            ->url()
                            ->placeholder('https://… или /path')
                            ->visible(fn ($get): bool => $get('impression_cta_mode') === 'custom')
                            ->required(fn ($get): bool => $get('impression_cta_mode') === 'custom'),
                    ]),

                Section::make('6. Цитата')
                    ->description('Блок quote + media внизу страницы.')
                    ->schema([
                        LumImage::single('quote_hero_image', 'Hero фото', 'dining/detail'),
                        LumImage::single('quote_oval_image', 'Овал', 'dining/detail'),
                        Locales::text('quote_line1', 'Цитата: строка 1'),
                        Locales::text('quote_line2', 'Цитата: строка 2'),
                        Locales::text('quote_note_line1', 'Цитата: примечание 1'),
                        Locales::text('quote_note_line2', 'Цитата: примечание 2'),
                    ]),
            ]);
    }
}
