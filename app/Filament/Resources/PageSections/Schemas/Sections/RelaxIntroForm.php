<?php

namespace App\Filament\Resources\PageSections\Schemas\Sections;

use App\Support\Locales as AppLocales;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class RelaxIntroForm
{
    /**
     * Порядок как на странице: строка → курсив → строка → подзаголовок.
     *
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make('Тексты')
                ->description('Сверху вниз: как в блоке intro на /relax.')
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
            TextInput::make("{$locale}.title_line1")->label('Заголовок, строка 1')->maxLength(255),
            TextInput::make("{$locale}.title_italic")->label('Заголовок, курсив')->maxLength(255),
            TextInput::make("{$locale}.title_line2")->label('Заголовок, строка 2')->maxLength(255),
            TextInput::make("{$locale}.eyebrow_line1")->label('Подзаголовок, строка 1')->maxLength(255),
            TextInput::make("{$locale}.eyebrow_line2")->label('Подзаголовок, строка 2')->maxLength(255),
        ];
    }
}
