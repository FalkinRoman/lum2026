<?php

namespace App\Filament\Resources\PageSections\Schemas\Sections;

use App\Support\Locales as AppLocales;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class StayQuoteForm
{
    /**
     * Stay: цитата + записка (после блока фото/овал).
     *
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make('Тексты')
                ->description('Под фото: цитата, затем записка на скрепке.')
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
            Textarea::make("{$locale}.quote")
                ->label('Цитата (mobile / desktop)')
                ->rows(2),
            Textarea::make("{$locale}.quote_break")
                ->label('Цитата с переносами (tablet)')
                ->rows(3)
                ->helperText('Каждая строка = перенос'),
            TextInput::make("{$locale}.note_line1")->label('Записка, строка 1')->maxLength(255),
            TextInput::make("{$locale}.note_line2")->label('Записка, строка 2')->maxLength(255),
        ];
    }
}
