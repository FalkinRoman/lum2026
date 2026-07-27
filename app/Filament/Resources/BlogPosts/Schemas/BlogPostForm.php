<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Filament\Forms\Locales;
use App\Filament\Forms\LumImage;
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
                Section::make('Пост')
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
                            ->label('Порядок')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),
                        DateTimePicker::make('published_at')
                            ->label('Дата публикации'),
                        Toggle::make('is_published')
                            ->label('Опубликовано')
                            ->default(true),
                    ]),

                Section::make('Изображения')
                    ->columns(2)
                    ->schema([
                        LumImage::single('image', 'Превью / карточка', 'blog'),
                        LumImage::single('hero', 'Hero', 'blog'),
                    ]),

                Section::make('Контент')
                    ->schema([
                        Locales::text('title', 'Заголовок', required: true),
                        Locales::text('excerpt', 'Анонс', textarea: true),
                        Locales::text('meta_title', 'Meta title'),

                        Grid::make(2)
                            ->schema([
                                Textarea::make('body.en')
                                    ->label('Текст (EN)')
                                    ->rows(10)
                                    ->helperText('Абзацы через пустую строку')
                                    ->formatStateUsing(fn ($state) => is_array($state) ? implode("\n\n", $state) : $state)
                                    ->dehydrateStateUsing(fn ($state) => array_values(array_filter(preg_split('/\n\s*\n/', (string) $state)))),
                                Textarea::make('body.ru')
                                    ->label('Текст (RU)')
                                    ->rows(10)
                                    ->helperText('Абзацы через пустую строку')
                                    ->formatStateUsing(fn ($state) => is_array($state) ? implode("\n\n", $state) : $state)
                                    ->dehydrateStateUsing(fn ($state) => array_values(array_filter(preg_split('/\n\s*\n/', (string) $state)))),
                            ]),
                    ]),

                Section::make('Таксономия')
                    ->columns(2)
                    ->schema([
                        TagsInput::make('tags')->label('Теги'),
                        TagsInput::make('categories')->label('Категории'),
                    ]),
            ]);
    }
}
