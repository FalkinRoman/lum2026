<?php

namespace App\Filament\Resources\HomeSections\Schemas\Sections;

use App\Filament\Forms\LumImage;
use App\Support\Locales as AppLocales;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class LocationForm
{
    /**
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make('Тексты')
                ->columnSpanFull()
                ->schema([
                    Tabs::make('locale')
                        ->contained(false)
                        ->tabs(array_map(
                            fn (string $locale) => Tab::make(AppLocales::label($locale))->schema(self::localeFields($locale)),
                            AppLocales::codes(),
                        )),
                ]),

            Section::make('Карточки')
                ->description('Ровно 3 карточки под вёрстку главной. Добавлять/удалять нельзя — только править и менять порядок.')
                ->columnSpanFull()
                ->schema([
                    Repeater::make('cards')
                        ->label('Карточки')
                        ->defaultItems(3)
                        ->minItems(3)
                        ->maxItems(3)
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable()
                        ->schema([
                            Hidden::make('_meta'),
                            Tabs::make('card_locale')
                                ->contained(false)
                                ->tabs(array_map(
                                    fn (string $locale) => Tab::make(AppLocales::label($locale))->schema([
                                        TextInput::make("title.{$locale}")->label('Title'),
                                        Textarea::make("list_lines.{$locale}")->label('Список (по строке)')->rows(3),
                                    ]),
                                    AppLocales::codes(),
                                )),
                            Select::make('route')
                                ->label('Route')
                                ->options([
                                    'dining' => 'dining',
                                    'relax' => 'relax',
                                    'discover' => 'discover',
                                    'stay' => 'stay',
                                    'shop' => 'shop',
                                    'blog' => 'blog',
                                ])
                                ->searchable()
                                ->nullable(),
                            LumImage::single('photo', 'Фото карточки', 'location', helperText: null),
                            LumImage::single('activeImg', 'Активная картинка', 'location', helperText: null),
                        ])
                        ->itemLabel(function (array $state): ?string {
                            foreach (AppLocales::codes() as $locale) {
                                $title = data_get($state, "title.{$locale}");
                                if (filled($title)) {
                                    return $title;
                                }
                            }

                            return 'Карточка';
                        }),
                ]),
        ];
    }

    /**
     * @return array<int, \Filament\Forms\Components\Field>
     */
    private static function localeFields(string $locale): array
    {
        return [
            Textarea::make("{$locale}.heading")
                ->label('Heading (можно HTML)')
                ->rows(3)
                ->helperText('Можно span с italic'),
            TextInput::make("{$locale}.see_on_map")->label('See on map'),
            TextInput::make("{$locale}.see_on_map_upper")->label('SEE on map'),
            TextInput::make("{$locale}.more_info")->label('More info'),
        ];
    }
}
