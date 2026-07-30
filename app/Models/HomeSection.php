<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    protected $fillable = ['key', 'payload'];

    public const LABELS = [
        'hero' => '1. Hero (видео)',
        'polaroids' => '2. Полароиды',
        'villas_intro' => '3. Карусель вилл',
        'location' => '4. Локация',
        'interior' => '5. Интерьер',
        'blog' => '6. Блог на главной',
        'shop_teaser' => '7. Shop',
    ];

    public const ORDER = [
        'hero',
        'polaroids',
        'villas_intro',
        'location',
        'interior',
        'blog',
        'shop_teaser',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }

    public function getLabelAttribute(): string
    {
        return self::LABELS[$this->key] ?? $this->key;
    }

    public function scopeOrdered(Builder $query): Builder
    {
        $cases = collect(self::ORDER)
            ->values()
            ->map(fn (string $key, int $i) => "WHEN '{$key}' THEN {$i}")
            ->implode(' ');

        return $query->orderByRaw("CASE `key` {$cases} ELSE 99 END");
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $row = static::query()->where('key', $key)->first();

        return $row?->payload ?? $default;
    }

    public static function put(string $key, array $payload): self
    {
        return static::query()->updateOrCreate(['key' => $key], ['payload' => $payload]);
    }
}
