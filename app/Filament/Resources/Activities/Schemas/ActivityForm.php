<?php

namespace App\Filament\Resources\Activities\Schemas;

use App\Filament\Forms\Locales;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Activity')
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
                    ]),

                Section::make('Images')
                    ->columns(2)
                    ->schema([
                        TextInput::make('listing_image')->label('Listing image path'),
                        TextInput::make('hero_image')->label('Hero image path'),
                        TextInput::make('oval_image')->label('Oval image path'),
                        TagsInput::make('gallery_images')
                            ->label('Gallery images (paths)')
                            ->columnSpanFull(),
                    ]),

                Section::make('Titles')
                    ->schema([
                        Locales::text('label_before', 'Label before'),
                        Locales::text('label_italic', 'Label italic'),
                        Locales::text('label_after', 'Label after'),
                        Locales::text('name', 'Name', required: true),
                        Locales::text('meta_title', 'Meta title'),
                    ]),

                Section::make('Hero')
                    ->schema([
                        Locales::text('hero_eyebrow', 'Hero eyebrow'),
                        Locales::text('hero_title_normal', 'Hero title normal'),
                        Locales::text('hero_title_italic', 'Hero title italic'),
                    ]),

                Section::make('Gallery')
                    ->schema([
                        Locales::text('gallery_eyebrow', 'Gallery eyebrow'),
                        Locales::text('gallery_title_normal', 'Gallery title normal'),
                        Locales::text('gallery_title_italic', 'Gallery title italic'),
                        Locales::text('gallery_body', 'Gallery body', textarea: true),
                    ]),

                Section::make('Quote')
                    ->schema([
                        Locales::text('quote_line1', 'Quote line 1'),
                        Locales::text('quote_line2', 'Quote line 2'),
                        Locales::text('quote_note', 'Quote note'),
                    ]),

                Section::make('Pricing')
                    ->columns(2)
                    ->schema([
                        TextInput::make('pricing_cta_url')
                            ->label('Pricing CTA URL')
                            ->url()
                            ->columnSpanFull(),
                        Locales::text('pricing_eyebrow', 'Pricing eyebrow'),
                        Locales::text('pricing_title_normal', 'Pricing title normal'),
                        Locales::text('pricing_title_italic', 'Pricing title italic'),
                        Locales::text('pricing_cta', 'Pricing CTA label'),
                        Locales::json('pricing_items', 'Pricing items')->columnSpanFull(),
                    ]),
            ]);
    }
}
