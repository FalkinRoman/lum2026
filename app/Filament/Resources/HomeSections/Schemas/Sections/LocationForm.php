<?php

namespace App\Filament\Resources\HomeSections\Schemas\Sections;

use App\Filament\Forms\LumImage;
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
                        ->tabs([
                            Tab::make('EN')->schema(self::localeFields('en')),
                            Tab::make('RU')->schema(self::localeFields('ru')),
                        ]),
                ]),

            Section::make('Карточки')
                ->columnSpanFull()
                ->schema([
                    Repeater::make('cards')
                        ->label('Карточки')
                        ->defaultItems(3)
                        ->reorderable()
                        ->schema([
                            Hidden::make('_meta'),
                            Tabs::make('card_locale')
                                ->contained(false)
                                ->tabs([
                                    Tab::make('EN')->schema([
                                        TextInput::make('title.en')->label('Title'),
                                        Textarea::make('list_lines.en')->label('Список (по строке)')->rows(3),
                                    ]),
                                    Tab::make('RU')->schema([
                                        TextInput::make('title.ru')->label('Title'),
                                        Textarea::make('list_lines.ru')->label('Список (по строке)')->rows(3),
                                    ]),
                                ]),
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
                        ->itemLabel(fn (array $state): ?string => data_get($state, 'title.en')
                            ?: data_get($state, 'title.ru')
                            ?: 'Карточка'),
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
