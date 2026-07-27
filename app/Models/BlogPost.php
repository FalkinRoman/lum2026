<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class BlogPost extends Model
{
    use HasTranslations;

    public const THEME_CYCLE = ['cream', 'dark', 'muted'];

    protected $fillable = [
        'slug', 'sort_order', 'is_published', 'published_at', 'theme',
        'image', 'hero', 'title', 'excerpt', 'meta_title', 'meta_description',
        'tags', 'categories', 'body',
    ];

    public array $translatable = ['title', 'excerpt', 'meta_title', 'meta_description', 'body'];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'tags' => 'array',
            'categories' => 'array',
            'body' => 'array',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Distinct taxonomy values across all posts (for Filament Select options).
     *
     * @return array<string, string>
     */
    public static function taxonomyOptions(string $column): array
    {
        return static::query()
            ->pluck($column)
            ->filter()
            ->flatten()
            ->map(fn ($value) => trim((string) $value))
            ->filter()
            ->unique()
            ->sort()
            ->mapWithKeys(fn (string $value) => [$value => $value])
            ->all();
    }

    /**
     * Category keys used by published posts, sorted for blog filter tabs.
     *
     * @return Collection<int, string>
     */
    public static function usedCategories(): Collection
    {
        return static::published()
            ->pluck('categories')
            ->filter()
            ->flatten()
            ->map(fn ($value) => trim((string) $value))
            ->filter()
            ->unique()
            ->sort()
            ->values();
    }

    public function fillSeoFallbacks(): void
    {
        foreach (['en', 'ru'] as $locale) {
            $title = trim((string) $this->getTranslation('title', $locale, false));
            $excerpt = trim((string) $this->getTranslation('excerpt', $locale, false));
            $metaTitle = trim((string) $this->getTranslation('meta_title', $locale, false));
            $metaDescription = trim((string) $this->getTranslation('meta_description', $locale, false));

            if ($metaTitle === '' && $title !== '') {
                $this->setTranslation('meta_title', $locale, $title.' — Lum');
            }

            if ($metaDescription === '' && $excerpt !== '') {
                $this->setTranslation('meta_description', $locale, Str::limit($excerpt, 160, ''));
            }
        }
    }

    /**
     * Place post at 1-based position; shift others and renumber densely 1..n.
     */
    public static function moveToPosition(BlogPost $post, int $position): void
    {
        $ids = static::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();

        $ids = array_values(array_filter($ids, fn (int $id) => $id !== (int) $post->getKey()));
        $position = max(1, min($position, count($ids) + 1));
        array_splice($ids, $position - 1, 0, [(int) $post->getKey()]);

        foreach ($ids as $index => $id) {
            static::query()->whereKey($id)->update(['sort_order' => $index + 1]);
        }

        $post->refresh();
    }

    /**
     * Heal duplicate / gapped sort_order values into a dense 1..n sequence.
     */
    public static function compactSortOrders(): void
    {
        static::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->pluck('id')
            ->values()
            ->each(function ($id, int $index): void {
                static::query()->whereKey($id)->update(['sort_order' => $index + 1]);
            });
    }

    protected static function booted(): void
    {
        static::saving(function (BlogPost $post): void {
            $post->fillSeoFallbacks();
            $post->sort_order = max(1, (int) ($post->sort_order ?: 1));
        });

        static::deleted(function (): void {
            static::compactSortOrders();
        });
    }
}
