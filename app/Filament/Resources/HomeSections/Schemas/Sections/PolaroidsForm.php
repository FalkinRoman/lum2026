<?php

namespace App\Filament\Resources\HomeSections\Schemas\Sections;

use App\Filament\Forms\LumImage;
use App\Support\Locales as AppLocales;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class PolaroidsForm
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
                    TextInput::make('cta_url')
                        ->label('Ссылка кнопки')
                        ->nullable()
                        ->helperText('Пусто = страница Stay. Абсолютный URL или путь: /stay, /blog'),
                ]),

            Section::make('Фото')
                ->columnSpanFull()
                ->schema([
                    LumImage::single('photos.0', 'Полароид 1', 'polaroids', helperText: null),
                    LumImage::single('photos.1', 'Полароид 2', 'polaroids', helperText: null),
                    LumImage::single('photos.2', 'Полароид 3', 'polaroids', helperText: null),
                ]),
        ];
    }

    /**
     * @return array<int, \Filament\Forms\Components\Field>
     */
    private static function localeFields(string $locale): array
    {
        return [
            TextInput::make("{$locale}.title_normal")->label('Title normal')->maxLength(255),
            TextInput::make("{$locale}.title_italic")->label('Title italic')->maxLength(255),
            Textarea::make("{$locale}.body")->label('Body')->rows(5),
            TextInput::make("{$locale}.cta")->label('Текст кнопки')->maxLength(255),
        ];
    }
}
