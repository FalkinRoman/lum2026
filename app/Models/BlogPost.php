<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BlogPost extends Model
{
    use HasTranslations;

    protected $fillable = [
        'slug', 'sort_order', 'is_published', 'published_at', 'theme',
        'image', 'hero', 'title', 'excerpt', 'meta_title', 'tags', 'categories', 'body',
    ];

    public array $translatable = ['title', 'excerpt', 'meta_title', 'body'];

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
}
