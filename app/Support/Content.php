<?php

namespace App\Support;

use App\Models\Activity;
use App\Models\BlogPost;
use App\Models\Excursion;
use App\Models\HomeSection;
use App\Models\MenuCategory;
use App\Models\Restaurant;
use App\Models\ShopProduct;
use App\Models\Villa;
use Illuminate\Support\Collection;

/**
 * Adapts CMS Eloquent models into the array shapes existing Blade partials expect.
 */
class Content
{
    public static function stripPrefix(?string $path, string $prefix): string
    {
        $path = (string) $path;
        if ($path !== '' && str_starts_with($path, $prefix)) {
            return substr($path, strlen($prefix));
        }

        return $path;
    }

    public static function slideStem(?string $path): string
    {
        $path = self::stripPrefix((string) $path, 'villas/');
        $path = preg_replace('/\.webp$/i', '', $path) ?? $path;

        return $path;
    }

    public static function blogPosts(): Collection
    {
        return BlogPost::published()->orderBy('sort_order')->get()->map(fn (BlogPost $p) => [
            'slug' => $p->slug,
            'title' => $p->title,
            'excerpt' => $p->excerpt,
            'image' => self::stripPrefix($p->image, 'blog/'),
            'tags' => $p->tags ?? [],
            'categories' => $p->categories ?? [],
            'theme' => $p->theme,
        ]);
    }

    public static function blogPost(string $slug): ?array
    {
        $p = BlogPost::published()->where('slug', $slug)->first();
        if (! $p) {
            return null;
        }

        return [
            'meta_title' => $p->meta_title ?: ($p->title.' — Lum'),
            'title' => $p->title,
            'excerpt' => $p->excerpt,
            'tags' => $p->tags ?? [],
            'hero' => self::stripPrefix($p->hero ?: $p->image, 'blog/'),
            'body' => is_array($p->body) ? $p->body : [],
            'image' => self::stripPrefix($p->image, 'blog/'),
            'theme' => $p->theme,
            'categories' => $p->categories ?? [],
            'slug' => $p->slug,
        ];
    }

    public static function villas(): Collection
    {
        return Villa::published()->get()->map(function (Villa $v) {
            return [
                'slug' => $v->slug,
                'image' => self::stripPrefix($v->listing_image, 'stay/'),
                'title_normal' => $v->title_normal ?? '',
                'title_italic' => $v->title_italic ?? '',
                'subtitle' => $v->subtitle ?? '',
                'subtitleLine1' => $v->subtitle_line1,
                'subtitleLine2' => $v->subtitle_line2,
                'photo' => self::slideStem($v->slide_photo),
                'oval' => self::slideStem($v->slide_oval),
                'titleNormal' => $v->title_normal,
                'titleItalic' => $v->title_italic,
                'titleMobileNormal' => $v->title_mobile_normal,
                'titleMobileItalic' => $v->title_mobile_italic,
            ];
        });
    }

    public static function villa(string $slug): ?array
    {
        $v = Villa::published()->where('slug', $slug)->first();
        if (! $v) {
            return null;
        }

        return [
            'meta_title' => $v->meta_title,
            'hero' => [
                'eyebrow' => $v->hero_eyebrow,
                'title_normal' => $v->hero_title_normal,
                'title_italic' => $v->hero_title_italic,
                'image' => $v->hero_image,
            ],
            'gallery' => [
                'eyebrow' => $v->gallery_eyebrow,
                'title_normal' => $v->gallery_title_normal,
                'title_italic' => $v->gallery_title_italic,
                'body' => $v->gallery_body,
                'body_bottom' => $v->gallery_body_bottom,
                'images' => $v->gallery_images ?? [],
            ],
            'facilities' => [
                'items_left' => $v->facilities_left ?? [],
                'items_right' => $v->facilities_right ?? [],
            ],
            'listing_image' => $v->listing_image,
            'slug' => $v->slug,
            'exely_hotel_id' => $v->exely_hotel_id,
            'exely_room_type_id' => $v->exely_room_type_id,
            'booking_url' => Site::villaBookingUrl(
                Exely::hotelIdForVilla($v->slug, $v->exely_hotel_id),
                $v->exely_room_type_id,
            ),
        ];
    }

    public static function restaurants(): Collection
    {
        return Restaurant::published()->get()->map(fn (Restaurant $r) => [
            'slug' => $r->slug,
            'image' => self::stripPrefix($r->listing_image, 'dining/'),
            'eyebrow' => $r->eyebrow,
            'subtitle' => $r->subtitle,
            'title_normal' => $r->title_normal,
            'title_italic' => $r->title_italic,
            'cta' => $r->opening_soon ? 'opening_soon' : 'more_info',
            'opening_soon' => $r->opening_soon,
        ]);
    }

    public static function restaurant(string $slug): ?array
    {
        $r = Restaurant::published()->where('slug', $slug)->first();
        if (! $r) {
            return null;
        }

        return [
            'meta_title' => $r->meta_title,
            'hero' => [
                'eyebrow' => $r->hero_eyebrow,
                'title_normal' => $r->hero_title_normal,
                'title_italic' => $r->hero_title_italic,
                'image' => $r->hero_image,
                'oval' => $r->oval_image,
            ],
            'gallery' => [
                'eyebrow' => $r->gallery_eyebrow,
                'title_normal' => $r->gallery_title_normal,
                'title_italic' => $r->gallery_title_italic,
                'body' => $r->gallery_body,
                'images' => $r->gallery_images ?? [],
            ],
            'quote' => [
                'line1' => $r->quote_line1,
                'line2' => $r->quote_line2,
                'note_line1' => $r->quote_note_line1,
                'note_line2' => $r->quote_note_line2,
            ],
            'book_url' => $r->book_url ?: Site::bookUrl(),
            'slug' => $r->slug,
        ];
    }

    public static function menuCategories(): Collection
    {
        return MenuCategory::query()->with('items')->orderBy('sort_order')->get()->map(fn (MenuCategory $c) => [
            'key' => $c->key,
            'label' => $c->label,
            'items' => $c->items->map(fn ($i) => [
                'name' => $i->name,
                'description' => $i->description,
                'price' => $i->price,
                'image' => $i->image,
                'photo' => $i->image ?: 'dining/detail/shared/menu-item.webp',
            ])->all(),
        ]);
    }

    public static function activities(): Collection
    {
        return Activity::published()->get()->map(fn (Activity $a) => [
            'slug' => $a->slug,
            'image' => self::stripPrefix($a->listing_image, 'relax/'),
            'label_before' => $a->label_before,
            'label_italic' => $a->label_italic,
            'label_after' => $a->label_after,
            'name' => $a->name,
        ]);
    }

    public static function activity(string $slug): ?array
    {
        $a = Activity::published()->where('slug', $slug)->first();
        if (! $a) {
            return null;
        }

        $noteParts = preg_split("/\r\n|\n|\r/", (string) $a->quote_note) ?: [];

        return [
            'meta_title' => $a->meta_title,
            'hero' => [
                'eyebrow' => $a->hero_eyebrow,
                'title_normal' => $a->hero_title_normal,
                'title_italic' => $a->hero_title_italic,
                'image' => $a->hero_image,
                'oval' => $a->oval_image,
            ],
            'gallery' => [
                'eyebrow' => $a->gallery_eyebrow,
                'title_normal' => $a->gallery_title_normal,
                'title_italic' => $a->gallery_title_italic,
                'body' => $a->gallery_body,
                'images' => $a->gallery_images ?? [],
            ],
            'quote' => [
                'line1' => $a->quote_line1,
                'line2' => $a->quote_line2,
                'note' => $a->quote_note,
                'note_line1' => $noteParts[0] ?? '',
                'note_line2' => $noteParts[1] ?? '',
            ],
            'pricing' => [
                'eyebrow' => $a->pricing_eyebrow,
                'title_normal' => $a->pricing_title_normal,
                'title_italic' => $a->pricing_title_italic,
                'cta' => $a->pricing_cta,
                'cta_url' => $a->pricing_cta_url ?: Site::bookUrl(),
                'items' => $a->pricing_items ?? [],
            ],
            'slug' => $a->slug,
        ];
    }

    public static function excursions(): Collection
    {
        return Excursion::published()->get()->map(fn (Excursion $e) => [
            'slug' => $e->slug,
            'image' => self::stripPrefix($e->listing_image, 'discover/'),
            'title' => $e->title,
            'region' => $e->region,
        ]);
    }

    public static function excursion(string $slug): ?array
    {
        $e = Excursion::published()->where('slug', $slug)->first();
        if (! $e) {
            return null;
        }

        return [
            'meta_title' => $e->meta_title,
            'intro' => [
                'title' => $e->intro_title,
                'body' => $e->intro_body,
            ],
            'gallery' => [
                'eyebrow' => $e->gallery_eyebrow,
                'title_normal' => $e->gallery_title_normal,
                'title_italic' => $e->gallery_title_italic,
                'images' => $e->gallery_images ?? [],
                'polaroid_dates' => $e->polaroid_dates ?? [],
            ],
            'package' => [
                'eyebrow' => $e->package_eyebrow,
                'title_normal' => $e->package_title_normal,
                'title_italic' => $e->package_title_italic,
                'items' => $e->package_items ?? [],
                'cost' => $e->package_cost,
                'images' => $e->package_images ?? [],
            ],
            'oval' => $e->oval_image,
            'wellness_hero' => $e->wellness_hero,
            'book_url' => $e->book_url ?: Site::bookUrl(),
            'slug' => $e->slug,
        ];
    }

    public static function shopProducts(): Collection
    {
        return ShopProduct::published()->get()->map(function (ShopProduct $p) {
            $strip = fn (?string $path) => self::stripPrefix($path, 'shop/');

            return [
                'slug' => $p->slug,
                'type' => $p->type,
                'title' => $p->title,
                'subtitle' => $p->subtitle,
                'image' => $strip($p->image),
                'thumbs' => array_map($strip, $p->thumbs ?? []),
                'colors' => array_map($strip, $p->colors ?? []),
                'sizes' => $p->sizes ?? [],
                'price' => $p->price,
                'cta_label' => $p->cta_label ?: $p->price,
            ];
        });
    }

    public static function shopItemsKeyed(): array
    {
        $items = [];
        foreach (self::shopProducts() as $p) {
            $items[$p['slug']] = $p;
        }

        return $items;
    }

    public static function home(string $key, mixed $default = null): mixed
    {
        return HomeSection::get($key, $default);
    }

    public static function homeLocale(string $key, mixed $default = null, ?string $locale = null): mixed
    {
        $payload = self::home($key, $default);
        if (! is_array($payload)) {
            return $payload;
        }

        $locale ??= app()->getLocale();

        return $payload[$locale] ?? $payload['en'] ?? $payload;
    }

    public static function contact(): array
    {
        $s = Site::settings();

        return [
            'title' => __('lum.contact.title'),
            'address' => $s->address,
            'phone' => $s->phone,
            'email' => $s->email,
            'see_on_map' => __('lum.contact.see_on_map'),
            'hours' => $s->getTranslation('hours', app()->getLocale()) ?: [],
            'legal' => $s->getTranslation('legal', app()->getLocale()) ?: [],
            'map_url' => Site::mapUrl(),
            'phone_href' => Site::phoneHref(),
            'email_href' => Site::emailHref(),
        ];
    }
}
