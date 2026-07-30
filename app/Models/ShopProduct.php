<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ShopProduct extends Model
{
    use HasTranslations;

    protected $fillable = [
        'slug', 'type', 'sort_order', 'is_published',
        'image', 'thumbs', 'colors', 'sizes', 'price', 'cta_label', 'cta_url',
        'title', 'subtitle',
    ];

    public array $translatable = ['title', 'subtitle'];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'thumbs' => 'array',
            'colors' => 'array',
            'sizes' => 'array',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort_order')->orderBy('id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
