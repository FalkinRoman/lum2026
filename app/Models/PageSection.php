<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = ['page', 'key', 'payload'];

    public const PAGES = ['stay', 'dining', 'relax', 'discover'];

    public const LABELS = [
        'stay' => [
            'intro' => '1. Заголовок',
            'media' => '2. Фото и овал',
            'quote' => '3. Цитата',
        ],
        'dining' => [
            'intro' => '1. Заголовок',
            'media' => '2. Фото и овал',
            'quote' => '3. Цитата',
        ],
        'relax' => [
            'intro' => '1. Заголовок',
            'media' => '2. Фото и овал',
            'quote' => '3. Цитата',
        ],
        'discover' => [
            'intro' => '1. Заголовок',
        ],
    ];

    public const ORDER = [
        'stay' => ['intro', 'media', 'quote'],
        'dining' => ['intro', 'media', 'quote'],
        'relax' => ['intro', 'media', 'quote'],
        'discover' => ['intro'],
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }

    public function getLabelAttribute(): string
    {
        return self::LABELS[$this->page][$this->key] ?? $this->key;
    }

    /** Not named forPage — that conflicts with Eloquent Builder::forPage() pagination. */
    public function scopeOnPage(Builder $query, string $page): Builder
    {
        return $query->where('page', $page);
    }

    public function scopeOrdered(Builder $query, string $page): Builder
    {
        $order = self::ORDER[$page] ?? [];

        if ($order === []) {
            return $query->orderBy('key');
        }

        $cases = collect($order)
            ->values()
            ->map(fn (string $key, int $i) => "WHEN '{$key}' THEN {$i}")
            ->implode(' ');

        return $query->orderByRaw("CASE `key` {$cases} ELSE 99 END");
    }

    /**
     * @return array<string, string>
     */
    public static function labelsFor(string $page): array
    {
        return self::LABELS[$page] ?? [];
    }

    /**
     * @return list<string>
     */
    public static function orderFor(string $page): array
    {
        return self::ORDER[$page] ?? [];
    }

    public static function get(string $page, string $key, mixed $default = null): mixed
    {
        $row = static::query()->where('page', $page)->where('key', $key)->first();

        return $row?->payload ?? $default;
    }

    public static function put(string $page, string $key, array $payload): self
    {
        return static::query()->updateOrCreate(
            ['page' => $page, 'key' => $key],
            ['payload' => $payload],
        );
    }
}
