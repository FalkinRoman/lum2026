<?php

namespace App\Filament\Resources\HomeSections\Schemas\Sections;

use App\Models\BlogPost;
use App\Support\Locales as AppLocales;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Validation\ValidationException;

class BlogForm
{
    /**
     * @return array<int, \Filament\Schemas\Components\Component>
     */
    public static function schema(): array
    {
        $options = fn (): array => BlogPost::published()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->mapWithKeys(fn (BlogPost $p) => [$p->slug => $p->title.' ('.$p->slug.')'])
            ->all();

        return [
            Section::make('Заголовок секции')
                ->description('Пусто = дефолт из lang (RU: «Твое путешествие начинается здесь»).')
                ->columnSpanFull()
                ->schema([
                    Tabs::make('locale')
                        ->contained(false)
                        ->tabs(array_map(
                            fn (string $locale) => Tab::make(AppLocales::label($locale))->schema([
                                TextInput::make("title_line1.{$locale}")
                                    ->label('Строка 1 (mobile)')
                                    ->maxLength(120),
                                TextInput::make("title_line2.{$locale}")
                                    ->label('Строка 2 (mobile)')
                                    ->maxLength(120),
                                TextInput::make("title_single.{$locale}")
                                    ->label('Одна строка (tablet / desktop)')
                                    ->maxLength(160),
                            ]),
                            AppLocales::codes(),
                        )),
                ]),

            Section::make('Посты на главной')
                ->description('До 4 постов. Порядок = как на главной (перетащи ручку). Дубль в селекте — слоты меняются местами.')
                ->columnSpanFull()
                ->schema([
                    Repeater::make('posts')
                        ->label('Слоты')
                        ->simple(
                            Select::make('slug')
                                ->options($options)
                                ->searchable()
                                ->nullable()
                                ->live()
                                ->afterStateUpdated(function (mixed $state, mixed $old, Set $set, Get $get, Select $component): void {
                                    self::swapIfDuplicate($state, $old, $set, $get, $component);
                                }),
                        )
                        ->defaultItems(4)
                        ->minItems(1)
                        ->maxItems(4)
                        ->reorderable()
                        ->addable()
                        ->deletable()
                        ->addActionLabel('Добавить пост'),
                ]),
        ];
    }

    private static function swapIfDuplicate(mixed $state, mixed $old, Set $set, Get $get, Select $component): void
    {
        if (! filled($state)) {
            return;
        }

        $slug = (string) $state;
        $posts = $get('/posts');
        if (! is_array($posts)) {
            return;
        }

        $path = (string) $component->getStatePath();
        // simple repeater: data.posts.{uuid}.slug
        $currentKey = null;
        if (preg_match('/(?:^|\.)posts\.([^.]+)\.slug$/', $path, $m) === 1) {
            $currentKey = $m[1];
        }

        if ($currentKey === null) {
            return;
        }

        foreach ($posts as $key => $item) {
            if ((string) $key === (string) $currentKey) {
                continue;
            }

            // dehydrated/raw may be scalar slug; live form state is usually ['slug' => ...]
            $otherSlug = is_array($item)
                ? (string) ($item['slug'] ?? '')
                : (string) ($item ?? '');

            if ($otherSlug !== $slug) {
                continue;
            }

            $oldSlug = filled($old) ? (string) $old : null;
            $set("/posts.{$key}.slug", $oldSlug);

            return;
        }
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function assertUniquePosts(array $data): void
    {
        $posts = self::extractSlugs($data);

        if (count($posts) !== count(array_unique($posts))) {
            throw ValidationException::withMessages([
                'posts' => 'Посты на главной не должны повторяться.',
            ]);
        }
    }

    /**
     * @param  array<string, mixed>  $data
     * @return list<string>
     */
    public static function extractSlugs(array $data): array
    {
        $raw = $data['posts'] ?? null;

        if (! is_array($raw)) {
            return array_values(array_filter([
                $data['post_1'] ?? null,
                $data['post_2'] ?? null,
                $data['post_3'] ?? null,
                $data['post_4'] ?? null,
            ], fn ($v) => filled($v)));
        }

        $slugs = [];
        foreach ($raw as $item) {
            if (is_string($item) && filled($item)) {
                $slugs[] = $item;
            } elseif (is_array($item) && filled($item['slug'] ?? null)) {
                $slugs[] = (string) $item['slug'];
            }
        }

        return array_values($slugs);
    }
}
