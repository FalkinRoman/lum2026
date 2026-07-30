<?php

namespace App\Filament\Resources\HomeSections\Schemas\Sections;

use App\Filament\Forms\LumImage;
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
                        ->tabs([
                            Tab::make('EN')->schema([
                                TextInput::make('en.title_normal')->label('Title normal'),
                                TextInput::make('en.title_caps')->label('Title caps'),
                            ]),
                            Tab::make('RU')->schema([
                                TextInput::make('ru.title_normal')->label('Title normal'),
                                TextInput::make('ru.title_caps')->label('Title caps'),
                            ]),
                        ]),
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
                                ->tabs([
                                    Tab::make('EN')->schema([
                                        TextInput::make('label.en')->label('Label')->required(),
                                    ]),
                                    Tab::make('RU')->schema([
                                        TextInput::make('label.ru')->label('Label')->required(),
                                    ]),
                                ]),
                            LumImage::many('images', 'Картинки галереи', 'interior', max: 12),
                        ])
                        ->itemLabel(fn (array $state): ?string => data_get($state, 'label.en')
                            ?: data_get($state, 'label.ru')
                            ?: 'Таб'),
                ]),
        ];
    }
}
