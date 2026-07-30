<?php

namespace App\Filament\Resources\Activities\Schemas;

use App\Filament\Forms\Locales;
use App\Support\Locales as AppLocales;
use App\Filament\Forms\LumImage;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Активность')
                    ->description('Служебные поля. Create / delete — из списка и шапки.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('URL: /relax/{slug}'),
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

                Section::make('1. Карточка на /relax')
                    ->schema([
                        LumImage::single('listing_image', 'Фото карточки', 'relax'),
                        Locales::text('label_before', 'Лейбл: до'),
                        Locales::text('label_italic', 'Лейбл: курсив'),
                        Locales::text('label_after', 'Лейбл: после'),
                        Locales::text('name', 'Название', required: true),
                    ]),

                Section::make('2. Hero страницы')
                    ->schema([
                        LumImage::single('hero_image', 'Большое фото', 'relax/detail'),
                        LumImage::single('oval_image', 'Овал', 'relax/detail'),
                        Locales::text('hero_eyebrow', 'Надзаголовок'),
                        Locales::text('hero_title_normal', 'Заголовок'),
                        Locales::text('hero_title_italic', 'Заголовок (курсив)'),
                    ]),

                Section::make('3. Галерея')
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
                                LumImage::single('path', 'Фото', 'relax/detail', helperText: null),
                                TextInput::make('date')
                                    ->label('Дата на полароиде')
                                    ->placeholder('06.05.2026')
                                    ->maxLength(32),
                            ])
                            ->itemLabel(fn (array $state): ?string => filled($state['date'] ?? null)
                                ? (string) $state['date']
                                : 'Полароид')
                            ->columnSpanFull(),
                    ]),

                Section::make('4. Цены')
                    ->schema([
                        Locales::text('pricing_eyebrow', 'Надзаголовок'),
                        Locales::text('pricing_title_normal', 'Заголовок'),
                        Locales::text('pricing_title_italic', 'Заголовок (курсив)'),
                        Locales::text('pricing_cta', 'Текст кнопки'),
                        TextInput::make('pricing_cta_url')
                            ->label('URL кнопки прайсинга')
                            ->url()
                            ->placeholder('https://wa.me/…'),
                        Locales::objectList(
                            'pricing_items',
                            'Позиции прайса',
                            [
                                TextInput::make('title')
                                    ->label('Название')
                                    ->required()
                                    ->columnSpanFull(),
                                Textarea::make('description')
                                    ->label('Описание')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                TextInput::make('price')
                                    ->label('Цена')
                                    ->placeholder('100$'),
                                TextInput::make('duration')
                                    ->label('Длительность')
                                    ->placeholder('60 min'),
                            ],
                            itemLabel: fn (array $state): ?string => filled($state['title'] ?? null)
                                ? (string) $state['title']
                                : 'Позиция',
                            addActionLabel: 'Добавить позицию',
                            columns: ['default' => 1, 'md' => 2],
                        )->columnSpanFull(),
                    ]),

                Section::make('5. Impression')
                    ->description('Каждый таб = своя галерея. CTA mode: activity = pricing_cta_url.')
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
                                'activity' => 'Как кнопка прайсинга (pricing_cta_url)',
                                'site' => 'Как Take a break в настройках сайта',
                                'custom' => 'Своя ссылка',
                            ])
                            ->default('activity')
                            ->live()
                            ->required(),
                        TextInput::make('impression_cta_url')
                            ->label('Своя ссылка')
                            ->url()
                            ->placeholder('https://… или /path')
                            ->visible(fn ($get): bool => $get('impression_cta_mode') === 'custom')
                            ->required(fn ($get): bool => $get('impression_cta_mode') === 'custom'),
                    ]),

                Section::make('6. Цитата')
                    ->schema([
                        LumImage::single('quote_hero_image', 'Hero фото', 'dining/detail'),
                        LumImage::single('quote_oval_image', 'Овал', 'dining/detail'),
                        Locales::text('quote_line1', 'Цитата: строка 1'),
                        Locales::text('quote_line2', 'Цитата: строка 2'),
                        Locales::text('quote_note', 'Цитата: примечание (две строки через Enter)'),
                    ]),
            ]);
    }
}
