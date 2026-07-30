<?php

namespace App\Filament\Resources\HomeSections\Schemas\Sections;

use App\Filament\Forms\LumImage;
use App\Support\Locales as AppLocales;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class InteriorForm
{
    /**
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    public static function schema(): array
    {
        return [
            Section::make('Заголовок')
                ->columnSpanFull()
                ->schema([
                    Tabs::make('locale')
                        ->contained(false)
                        ->tabs(array_map(
                            fn (string $locale) => Tab::make(AppLocales::label($locale))->schema([
                                TextInput::make("{$locale}.title_normal")->label('Title normal'),
                                TextInput::make("{$locale}.title_caps")->label('Title caps'),
                            ]),
                            AppLocales::codes(),
                        )),
                ]),

            Section::make('Табы и галереи')
                ->description('Каждый таб = свой набор картинок. Таб без картинок не показывается.')
                ->columnSpanFull()
                ->schema([
                    Repeater::make('tabs')
                        ->label('Табы')
                        ->reorderable()
                        ->schema([
                            Tabs::make('tab_locale')
                                ->contained(false)
                                ->tabs(array_map(
                                    fn (string $locale) => Tab::make(AppLocales::label($locale))->schema([
                                        TextInput::make("label.{$locale}")->label('Label')->required($locale === 'en'),
                                    ]),
                                    AppLocales::codes(),
                                )),
                            LumImage::many('images', 'Картинки галереи', 'interior', max: 12),
                        ])
                        ->itemLabel(function (array $state): ?string {
                            foreach (AppLocales::codes() as $locale) {
                                $label = data_get($state, "label.{$locale}");
                                if (filled($label)) {
                                    return $label;
                                }
                            }

                            return 'Таб';
                        }),
                ]),
        ];
    }
}
