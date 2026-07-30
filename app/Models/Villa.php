<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Villa extends Model
{
    use HasTranslations;

    protected $fillable = [
        'slug', 'sort_order', 'is_published',
        'exely_hotel_id', 'exely_room_type_id',
        'listing_image', 'slide_photo', 'slide_oval', 'hero_image', 'gallery_images',
        'title_normal', 'title_italic', 'title_mobile_normal', 'title_mobile_italic',
        'subtitle', 'subtitle_line1', 'subtitle_line2', 'meta_title',
        'hero_eyebrow', 'hero_title_normal', 'hero_title_italic',
        'gallery_eyebrow', 'gallery_title_normal', 'gallery_title_italic',
        'gallery_body', 'gallery_body_bottom',
        'facilities_eyebrow', 'facilities_title_normal', 'facilities_title_italic',
        'facilities_left', 'facilities_right',
        'facilities_image_left', 'facilities_image_right',
        'impression_title_normal', 'impression_title_caps', 'impression_tabs',
        'impression_slides', 'impression_galleries', 'impression_cta',
        'impression_cta_mode', 'impression_cta_url',
        'shop_eyebrow', 'shop_title_normal', 'shop_title_italic', 'shop_cta',
        'shop_background_image',
    ];

    public array $translatable = [
        'title_normal', 'title_italic', 'title_mobile_normal', 'title_mobile_italic',
        'subtitle', 'subtitle_line1', 'subtitle_line2', 'meta_title',
        'hero_eyebrow', 'hero_title_normal', 'hero_title_italic',
        'gallery_eyebrow', 'gallery_title_normal', 'gallery_title_italic',
        'gallery_body', 'gallery_body_bottom',
        'facilities_eyebrow', 'facilities_title_normal', 'facilities_title_italic',
        'facilities_left', 'facilities_right',
        'impression_title_normal', 'impression_title_caps', 'impression_tabs',
        'impression_cta',
        'shop_eyebrow', 'shop_title_normal', 'shop_title_italic', 'shop_cta',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'gallery_images' => 'array',
            'facilities_left' => 'array',
            'facilities_right' => 'array',
            'impression_tabs' => 'array',
            'impression_slides' => 'array',
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
