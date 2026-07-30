<?php

namespace App\Filament\Resources\PageSections\Schemas\Sections;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class DiscoverIntroForm
{
    /**
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make('Тексты')
                ->description('Сверху вниз: как в intro на /discover.')
                ->columnSpanFull()
                ->schema([
                    Tabs::make('locale')
                        ->contained(false)
                        ->tabs([
                            Tab::make('EN')->schema(self::fields('en')),
                            Tab::make('RU')->schema(self::fields('ru')),
                        ]),
                ]),
        ];
    }

    /**
     * @return array<int, \Filament\Forms\Components\Field>
     */
    private static function fields(string $locale): array
    {
        return [
            TextInput::make("{$locale}.title_normal")->label('Заголовок, обычная часть')->maxLength(255),
            TextInput::make("{$locale}.title_italic")->label('Заголовок, курсив')->maxLength(255),
            TextInput::make("{$locale}.eyebrow")->label('Подзаголовок')->maxLength(255),
        ];
    }
}
