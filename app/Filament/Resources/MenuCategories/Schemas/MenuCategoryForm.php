<?php

namespace App\Filament\Resources\MenuCategories\Schemas;

use App\Filament\Forms\Locales;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Unique;

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
                            ->maxLength(255)
                            ->unique(
                                table: 'menu_categories',
                                column: 'key',
                                ignoreRecord: true,
                                modifyRuleUsing: function (Unique $rule, $get, $record): Unique {
                                    $restaurantId = $record?->restaurant_id ?? $get('restaurant_id');

                                    return $restaurantId
                                        ? $rule->where('restaurant_id', $restaurantId)
                                        : $rule;
                                },
                            ),
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
