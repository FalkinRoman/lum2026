<?php

namespace App\Filament\Resources\Villas\Schemas;

use App\Filament\Forms\Locales;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VillaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Villa')
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

                Section::make('Exely booking')
                    ->description('Map this villa to Exely hotel / room type from the client cabinet. Leave empty → general /booking.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('exely_hotel_id')
                            ->label('Exely hotel ID')
                            ->helperText('Known: 502887, 514444')
                            ->maxLength(32),
                        TextInput::make('exely_room_type_id')
                            ->label('Exely room type ID')
                            ->helperText('Deep-link Book now to this room')
                            ->maxLength(32),
                    ]),

                Section::make('Images')
                    ->columns(2)
                    ->schema([
                        TextInput::make('listing_image')->label('Listing image path'),
                        TextInput::make('slide_photo')->label('Slide photo path'),
                        TextInput::make('slide_oval')->label('Slide oval path'),
                        TextInput::make('hero_image')->label('Hero image path'),
                        TagsInput::make('gallery_images')
                            ->label('Gallery images (paths)')
                            ->columnSpanFull(),
                    ]),

                Section::make('Titles')
                    ->schema([
                        Locales::text('title_normal', 'Title normal', required: true),
                        Locales::text('title_italic', 'Title italic'),
                        Locales::text('title_mobile_normal', 'Title mobile normal'),
                        Locales::text('title_mobile_italic', 'Title mobile italic'),
                        Locales::text('subtitle', 'Subtitle'),
                        Locales::text('subtitle_line1', 'Subtitle line 1'),
                        Locales::text('subtitle_line2', 'Subtitle line 2'),
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
                        Locales::text('gallery_body_bottom', 'Gallery body (bottom)', textarea: true),
                    ]),

                Section::make('Facilities')
                    ->schema([
                        Locales::tags('facilities_left', 'Facilities (left column)'),
                        Locales::tags('facilities_right', 'Facilities (right column)'),
                    ]),
            ]);
    }
}
