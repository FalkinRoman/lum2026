<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Activity extends Model
{
    use HasTranslations;

    protected $fillable = [
        'slug', 'sort_order', 'is_published',
        'listing_image', 'hero_image', 'oval_image', 'gallery_images',
        'label_before', 'label_italic', 'label_after', 'name', 'meta_title',
        'hero_eyebrow', 'hero_title_normal', 'hero_title_italic',
        'gallery_eyebrow', 'gallery_title_normal', 'gallery_title_italic', 'gallery_body', 'gallery_body_bottom',
        'quote_line1', 'quote_line2', 'quote_note', 'quote_hero_image', 'quote_oval_image',
        'pricing_eyebrow', 'pricing_title_normal', 'pricing_title_italic',
        'pricing_cta', 'pricing_cta_url', 'pricing_items',
        'impression_title_normal', 'impression_title_caps', 'impression_galleries',
        'impression_cta', 'impression_cta_mode', 'impression_cta_url',
    ];

    public array $translatable = [
        'label_before', 'label_italic', 'label_after', 'name', 'meta_title',
        'hero_eyebrow', 'hero_title_normal', 'hero_title_italic',
        'gallery_eyebrow', 'gallery_title_normal', 'gallery_title_italic', 'gallery_body', 'gallery_body_bottom',
        'quote_line1', 'quote_line2', 'quote_note',
        'pricing_eyebrow', 'pricing_title_normal', 'pricing_title_italic', 'pricing_cta',
        'pricing_items',
        'impression_title_normal', 'impression_title_caps', 'impression_cta',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'gallery_images' => 'array',
            'pricing_items' => 'array',
            'impression_galleries' => 'array',
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
