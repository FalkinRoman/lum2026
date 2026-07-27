<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Filament\Forms\LumImage;
use App\Models\BlogPost;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Пост')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
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

                Section::make('Контент')
                    ->columnSpanFull()
                    ->schema([
                        Tabs::make('locale')
                            ->contained(false)
                            ->columnSpanFull()
                            ->tabs([
                                Tab::make('EN')->schema(self::localeFields('en')),
                                Tab::make('RU')->schema(self::localeFields('ru')),
                            ]),
                    ]),

                Section::make('Изображения')
                    ->columnSpanFull()
                    ->schema([
                        LumImage::single('image', 'Превью / карточка', 'blog', helperText: null, editor: true),
                        LumImage::single('hero', 'Hero (страница статьи)', 'blog', helperText: null, editor: true),
                    ]),

                Section::make('Таксономия')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('tags')
                            ->label('Теги')
                            ->multiple()
                            ->searchable()
                            ->options(fn (): array => BlogPost::taxonomyOptions('tags'))
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Новый тег')
                                    ->required()
                                    ->maxLength(80),
                            ])
                            ->createOptionUsing(fn (array $data): string => trim($data['name']))
                            ->createOptionModalHeading('Новый тег')
                            ->placeholder('Выберите или создайте тег'),
                        Select::make('categories')
                            ->label('Категории')
                            ->multiple()
                            ->searchable()
                            ->options(fn (): array => BlogPost::taxonomyOptions('categories'))
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Новая категория')
                                    ->required()
                                    ->maxLength(80)
                                    ->helperText('Ключ для фильтра на /blog, например food или sri-lanka'),
                            ])
                            ->createOptionUsing(fn (array $data): string => trim($data['name']))
                            ->createOptionModalHeading('Новая категория')
                            ->placeholder('Выберите или создайте категорию'),
                    ]),
            ]);
    }

    /**
     * @return array<\Filament\Forms\Components\Component>
     */
    private static function localeFields(string $locale): array
    {
        $required = $locale === 'en';

        $title = TextInput::make("title.{$locale}")
            ->label('Заголовок')
            ->maxLength(255);

        $excerpt = Textarea::make("excerpt.{$locale}")
            ->label('Анонс')
            ->rows(4);

        $body = Textarea::make("body.{$locale}")
            ->label('Текст')
            ->rows(12)
            ->helperText('Абзацы через пустую строку')
            ->formatStateUsing(fn ($state) => is_array($state) ? implode("\n\n", $state) : $state)
            ->dehydrateStateUsing(fn ($state) => array_values(array_filter(
                preg_split('/\n\s*\n/', (string) $state) ?: [],
                fn ($paragraph) => trim((string) $paragraph) !== '',
            )));

        $metaTitle = TextInput::make("meta_title.{$locale}")
            ->label('Meta title')
            ->maxLength(255)
            ->helperText('Пусто = заголовок + « — Lum»');

        $metaDescription = Textarea::make("meta_description.{$locale}")
            ->label('Meta description')
            ->rows(3)
            ->helperText('Пусто = анонс (до 160 символов)');

        if ($required) {
            $title->required();
        }

        return [$title, $excerpt, $body, $metaTitle, $metaDescription];
    }
}
