<?php

namespace App\Filament\Resources\PageSections\Schemas\Sections;

use App\Support\Locales as AppLocales;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class QuoteForm
{
    /**
     * Dining / Relax: цитата + записка (медиа — отдельная секция).
     *
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make('Тексты')
                ->description('Под фото: цитата (курсив + обычная), затем записка.')
                ->columnSpanFull()
                ->schema([
                    Tabs::make('locale')
                        ->contained(false)
                        ->tabs(array_map(
                            fn (string $locale) => Tab::make(AppLocales::label($locale))->schema(self::fields($locale)),
                            AppLocales::codes(),
                        )),
                ]),
        ];
    }

    /**
     * @return array<int, \Filament\Forms\Components\Field>
     */
    private static function fields(string $locale): array
    {
        return [
            TextInput::make("{$locale}.quote_line1")->label('Цитата, часть 1 (курсив)')->maxLength(255),
            TextInput::make("{$locale}.quote_line2")->label('Цитата, часть 2')->maxLength(255),
            TextInput::make("{$locale}.note_line1")->label('Записка, строка 1')->maxLength(255),
            TextInput::make("{$locale}.note_line2")->label('Записка, строка 2')->maxLength(255),
        ];
    }
}
