<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Filament\Forms\Locales;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Post')
                    ->columns(2)
                    ->schema([
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Select::make('theme')
                            ->options([
                                'cream' => 'Cream',
                                'dark' => 'Dark',
                                'muted' => 'Muted',
                            ])
                            ->default('cream')
                            ->required(),
                        TextInput::make('sort_order')
                            ->label('Sort order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        DateTimePicker::make('published_at')
                            ->label('Published at'),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                    ]),

                Section::make('Images')
                    ->columns(2)
                    ->schema([
                        TextInput::make('image')
                            ->label('Image path')
                            ->helperText('Relative path, e.g. images/lum/blog/post.jpg'),
                        TextInput::make('hero')
                            ->label('Hero image path'),
                    ]),

                Section::make('Content')
                    ->schema([
                        Locales::text('title', 'Title', required: true),
                        Locales::text('excerpt', 'Excerpt', textarea: true),
                        Locales::text('meta_title', 'Meta title'),

                        Grid::make(2)
                            ->schema([
                                Textarea::make('body.en')
                                    ->label('Body (EN)')
                                    ->rows(10)
                                    ->helperText('One paragraph per blank-line separated block')
                                    ->formatStateUsing(fn ($state) => is_array($state) ? implode("\n\n", $state) : $state)
                                    ->dehydrateStateUsing(fn ($state) => array_values(array_filter(preg_split('/\n\s*\n/', (string) $state)))),
                                Textarea::make('body.ru')
                                    ->label('Body (RU)')
                                    ->rows(10)
                                    ->helperText('One paragraph per blank-line separated block')
                                    ->formatStateUsing(fn ($state) => is_array($state) ? implode("\n\n", $state) : $state)
                                    ->dehydrateStateUsing(fn ($state) => array_values(array_filter(preg_split('/\n\s*\n/', (string) $state)))),
                            ]),
                    ]),

                Section::make('Taxonomy')
                    ->columns(2)
                    ->schema([
                        TagsInput::make('tags'),
                        TagsInput::make('categories'),
                    ]),
            ]);
    }
}
