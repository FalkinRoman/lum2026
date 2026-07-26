<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Excursion extends Model
{
    use HasTranslations;

    protected $fillable = [
        'slug', 'sort_order', 'is_published',
        'listing_image', 'oval_image', 'wellness_hero', 'gallery_images', 'package_images',
        'title', 'region', 'meta_title', 'intro_title', 'intro_body',
        'gallery_eyebrow', 'gallery_title_normal', 'gallery_title_italic', 'polaroid_dates',
        'package_eyebrow', 'package_title_normal', 'package_title_italic',
        'package_items', 'package_cost', 'book_url',
    ];

    public array $translatable = [
        'title', 'region', 'meta_title', 'intro_title', 'intro_body',
        'gallery_eyebrow', 'gallery_title_normal', 'gallery_title_italic',
        'package_eyebrow', 'package_title_normal', 'package_title_italic',
        'package_items', 'package_cost', 'polaroid_dates',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'gallery_images' => 'array',
            'package_images' => 'array',
            'package_items' => 'array',
            'polaroid_dates' => 'array',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
