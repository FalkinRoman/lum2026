<?php

namespace App\Filament\Resources\Excursions\Schemas;

use App\Filament\Forms\Locales;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExcursionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Excursion')
                    ->columns(2)
                    ->schema([
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('sort_order')
                            ->label('Sort order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                        TextInput::make('book_url')
                            ->label('Book URL')
                            ->url(),
                    ]),

                Section::make('Images')
                    ->columns(2)
                    ->schema([
                        TextInput::make('listing_image')->label('Listing image path'),
                        TextInput::make('oval_image')->label('Oval image path'),
                        TextInput::make('wellness_hero')->label('Wellness hero path'),
                        TagsInput::make('gallery_images')->label('Gallery images (paths)'),
                        TagsInput::make('package_images')->label('Package images (paths)'),
                    ]),

                Section::make('Titles')
                    ->schema([
                        Locales::text('title', 'Title', required: true),
                        Locales::text('region', 'Region'),
                        Locales::text('meta_title', 'Meta title'),
                        Locales::text('intro_title', 'Intro title'),
                        Locales::text('intro_body', 'Intro body', textarea: true),
                    ]),

                Section::make('Gallery')
                    ->schema([
                        Locales::text('gallery_eyebrow', 'Gallery eyebrow'),
                        Locales::text('gallery_title_normal', 'Gallery title normal'),
                        Locales::text('gallery_title_italic', 'Gallery title italic'),
                        Locales::tags('polaroid_dates', 'Polaroid dates'),
                    ]),

                Section::make('Package')
                    ->schema([
                        Locales::text('package_eyebrow', 'Package eyebrow'),
                        Locales::text('package_title_normal', 'Package title normal'),
                        Locales::text('package_title_italic', 'Package title italic'),
                        Locales::text('package_cost', 'Package cost'),
                        Locales::json('package_items', 'Package items')->columnSpanFull(),
                    ]),
            ]);
    }
}
