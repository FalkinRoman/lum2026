<?php

namespace App\Filament\Resources\ShopProducts\Schemas;

use App\Filament\Forms\Locales;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ShopProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Product')
                    ->columns(2)
                    ->schema([
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('type')
                            ->default('tee')
                            ->required(),
                        TextInput::make('sort_order')
                            ->label('Sort order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                        TextInput::make('price'),
                        TextInput::make('cta_label')
                            ->label('CTA label'),
                    ]),

                Section::make('Images & options')
                    ->columns(2)
                    ->schema([
                        TextInput::make('image')
                            ->label('Image path')
                            ->columnSpanFull(),
                        TagsInput::make('thumbs')->label('Thumbnails (paths)'),
                        TagsInput::make('colors'),
                        TagsInput::make('sizes'),
                    ]),

                Section::make('Titles')
                    ->schema([
                        Locales::text('title', 'Title', required: true),
                        Locales::text('subtitle', 'Subtitle'),
                    ]),
            ]);
    }
}
