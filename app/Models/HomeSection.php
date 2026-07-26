<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    protected $fillable = ['key', 'payload'];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
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
