<?php

namespace App\Filament\Resources\HomeSections\Schemas\Sections;

use App\Filament\Forms\LumImage;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class ShopForm
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

            Section::make('Фон')
                ->columnSpanFull()
                ->schema([
                    LumImage::single('background_image', 'Фоновое изображение', 'shop', helperText: null),
                ]),
        ];
    }

    /**
     * @return array<int, \Filament\Forms\Components\Field>
     */
    private static function localeFields(string $locale): array
    {
        return [
            TextInput::make("{$locale}.eyebrow")->label('Eyebrow')->maxLength(255),
            TextInput::make("{$locale}.title_normal")->label('Title normal')->maxLength(255),
            TextInput::make("{$locale}.title_italic")->label('Title italic')->maxLength(255),
            TextInput::make("{$locale}.cta")->label('CTA')->maxLength(255),
        ];
    }
}
