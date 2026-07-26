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
        'gallery_body', 'gallery_body_bottom', 'facilities_left', 'facilities_right',
    ];

    public array $translatable = [
        'title_normal', 'title_italic', 'title_mobile_normal', 'title_mobile_italic',
        'subtitle', 'subtitle_line1', 'subtitle_line2', 'meta_title',
        'hero_eyebrow', 'hero_title_normal', 'hero_title_italic',
        'gallery_eyebrow', 'gallery_title_normal', 'gallery_title_italic',
        'gallery_body', 'gallery_body_bottom', 'facilities_left', 'facilities_right',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'gallery_images' => 'array',
            'facilities_left' => 'array',
            'facilities_right' => 'array',
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
