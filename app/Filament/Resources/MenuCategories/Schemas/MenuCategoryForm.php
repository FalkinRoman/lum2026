<?php

namespace App\Filament\Resources\MenuCategories\Schemas;

use App\Filament\Forms\Locales;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MenuCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Категория меню')
                    ->columns(2)
                    ->schema([
                        TextInput::make('key')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('sort_order')
                            ->label('Порядок')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),
                    ]),

                Locales::text('label', 'Название', required: true),
            ]);
    }
}
