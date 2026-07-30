<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Restaurant extends Model
{
    use HasTranslations;

    protected $fillable = [
        'slug', 'sort_order', 'is_published', 'opening_soon',
        'listing_image', 'hero_image', 'oval_image', 'gallery_images',
        'eyebrow', 'subtitle', 'title_normal', 'title_italic', 'meta_title',
        'hero_eyebrow', 'hero_title_normal', 'hero_title_italic',
        'gallery_eyebrow', 'gallery_title_normal', 'gallery_title_italic', 'gallery_body', 'gallery_body_bottom',
        'menu_eyebrow', 'menu_title_normal', 'menu_title_italic',
        'impression_title_normal', 'impression_title_caps', 'impression_galleries',
        'impression_cta', 'impression_cta_mode', 'impression_cta_url',
        'quote_line1', 'quote_line2', 'quote_note_line1', 'quote_note_line2',
        'quote_hero_image', 'quote_oval_image', 'book_url',
    ];

    public array $translatable = [
        'eyebrow', 'subtitle', 'title_normal', 'title_italic', 'meta_title',
        'hero_eyebrow', 'hero_title_normal', 'hero_title_italic',
        'gallery_eyebrow', 'gallery_title_normal', 'gallery_title_italic', 'gallery_body', 'gallery_body_bottom',
        'menu_eyebrow', 'menu_title_normal', 'menu_title_italic',
        'impression_title_normal', 'impression_title_caps', 'impression_cta',
        'quote_line1', 'quote_line2', 'quote_note_line1', 'quote_note_line2',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'opening_soon' => 'boolean',
            'gallery_images' => 'array',
            'impression_galleries' => 'array',
        ];
    }

    public function menuCategories(): HasMany
    {
        return $this->hasMany(MenuCategory::class)->orderBy('sort_order');
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
