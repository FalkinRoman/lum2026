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
use Illuminate\Pagination\LengthAwarePaginator;
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

    /**
     * URL for CMS-managed media. Empty path → espresso stub (no seed asset fallback).
     */
    public static function mediaUrl(?string $path): string
    {
        $path = is_string($path) ? trim($path) : '';

        if ($path === '') {
            return self::mediaStubUrl();
        }

        return asset('images/lum/'.ltrim($path, '/'));
    }

    public static function mediaStubUrl(): string
    {
        static $url = null;

        return $url ??= 'data:image/svg+xml,'.rawurlencode(
            '<svg xmlns="http://www.w3.org/2000/svg" width="8" height="8"><rect fill="#2C1810" width="8" height="8"/></svg>'
        );
    }

    public static function hasMedia(mixed $path): bool
    {
        return is_string($path) && trim($path) !== '';
    }

    /**
     * CMS CTA href. Absolute URL / path / named route; empty → fallback route.
     */
    public static function link(?string $url, string $fallbackRoute = 'stay'): string
    {
        $url = is_string($url) ? trim($url) : '';

        if ($url === '') {
            return route($fallbackRoute);
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, '//') || str_starts_with($url, '/')) {
            return $url;
        }

        if (\Illuminate\Support\Facades\Route::has($url)) {
            return route($url);
        }

        return url($url);
    }

    public static function slideStem(?string $path): string
    {
        $path = self::stripPrefix((string) $path, 'villas/');
        $path = preg_replace('/\.(webp|jpe?g|png)$/i', '', $path) ?? $path;

        return $path;
    }

    /**
     * Resolve villa carousel image for JS/blade.
     * Legacy slide-01 / oval-02 → stem + -sm.webp variants.
     * CMS upload (hash.jpg etc.) → absolute URL, same for all breakpoints.
     *
     * @return array{stem: ?string, src: string, srcSm: string}
     */
    public static function villaCarouselMedia(?string $path): array
    {
        if (! self::hasMedia($path)) {
            $stub = self::mediaStubUrl();

            return ['stem' => null, 'src' => $stub, 'srcSm' => $stub];
        }

        $relative = str_contains($path, '/') ? $path : 'villas/'.$path;
        $stem = self::slideStem($relative);

        if (preg_match('/^(slide|oval)-\d{2}$/', $stem) === 1) {
            $base = asset('images/lum/villas');

            return [
                'stem' => $stem,
                'src' => $base.'/'.$stem.'.webp',
                'srcSm' => $base.'/'.$stem.'-sm.webp',
            ];
        }

        $url = self::mediaUrl($relative);

        return ['stem' => null, 'src' => $url, 'srcSm' => $url];
    }

    public static function interiorStem(?string $path): string
    {
        $path = self::stripPrefix((string) $path, 'interior/');
        $path = preg_replace('/\.(webp|jpe?g|png)$/i', '', $path) ?? $path;
        $path = preg_replace('/-sm$/i', '', $path) ?? $path;

        return $path;
    }

    /**
     * Home blog carousel: CMS picks, else first published posts.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public static function homeBlogPosts(int $limit = 4): Collection
    {
        $picks = self::homeLocale('blog')['posts'] ?? null;
        $all = self::blogPosts()->keyBy('slug');

        if (is_array($picks) && $picks !== []) {
            $resolved = collect($picks)
                ->filter(fn ($slug) => filled($slug) && $all->has($slug))
                ->map(fn ($slug) => $all->get($slug))
                ->values();

            if ($resolved->isNotEmpty()) {
                $themes = BlogPost::THEME_CYCLE;

                return $resolved
                    ->take($limit)
                    ->values()
                    ->map(fn (array $post, int $index) => array_merge($post, [
                        'theme' => $themes[$index % count($themes)],
                    ]));
            }
        }

        return self::blogPosts()->take($limit)->values();
    }

    /**
     * Home villas carousel slides from CMS (fallback to Villa models).
     *
     * @return list<array<string, mixed>>
     */
    public static function homeVillaSlides(): array
    {
        $intro = self::homeLocale('villas_intro') ?? [];
        $cmsSlides = is_array($intro['slides'] ?? null) ? $intro['slides'] : [];

        if ($cmsSlides !== []) {
            return collect($cmsSlides)->map(function (array $slide) use ($intro) {
                $slug = $slide['slug'] ?? null;
                if (! $slug && ! empty($slide['villa_id'])) {
                    $slug = Villa::query()->whereKey($slide['villa_id'])->value('slug');
                }

                $slug = $slug ?: 'villas';

                $photo = self::villaCarouselMedia($slide['photo'] ?? null);
                $oval = self::villaCarouselMedia($slide['oval'] ?? null);

                return [
                    'slug' => $slug,
                    'href' => route('villa.show', $slug),
                    'photo' => $photo['stem'],
                    'oval' => $oval['stem'],
                    'photoSrc' => $photo['src'],
                    'photoSrcSm' => $photo['srcSm'],
                    'ovalSrc' => $oval['src'],
                    'ovalSrcSm' => $oval['srcSm'],
                    'titleNormal' => $slide['title_normal'] ?? $slide['titleNormal'] ?? '',
                    'titleItalic' => $slide['title_italic'] ?? $slide['titleItalic'] ?? '',
                    'titleMobileNormal' => $slide['title_mobile_normal'] ?? $slide['titleMobileNormal'] ?? ($slide['title_normal'] ?? $slide['titleNormal'] ?? ''),
                    'titleMobileItalic' => $slide['title_mobile_italic'] ?? $slide['titleMobileItalic'] ?? ($slide['title_italic'] ?? $slide['titleItalic'] ?? ''),
                    'subtitle' => $slide['subtitle'] ?? ($intro['subtitle'] ?? __('lum.villas.subtitle')),
                    'subtitleLine1' => $slide['subtitle_line1'] ?? $slide['subtitleLine1'] ?? ($intro['subtitle_line1'] ?? __('lum.villas.subtitle_line1')),
                    'subtitleLine2' => $slide['subtitle_line2'] ?? $slide['subtitleLine2'] ?? ($intro['subtitle_line2'] ?? __('lum.villas.subtitle_line2')),
                ];
            })->values()->all();
        }

        return self::villas()->map(function ($slide) use ($intro) {
            $photo = self::villaCarouselMedia(
                isset($slide['photo']) ? 'villas/'.$slide['photo'].'.webp' : null
            );
            $oval = self::villaCarouselMedia(
                isset($slide['oval']) ? 'villas/'.$slide['oval'].'.webp' : null
            );

            return array_merge($slide, [
                'photo' => $photo['stem'] ?? ($slide['photo'] ?? null),
                'oval' => $oval['stem'] ?? ($slide['oval'] ?? null),
                'photoSrc' => $photo['src'],
                'photoSrcSm' => $photo['srcSm'],
                'ovalSrc' => $oval['src'],
                'ovalSrcSm' => $oval['srcSm'],
                'subtitle' => $slide['subtitle'] ?? ($intro['subtitle'] ?? __('lum.villas.subtitle')),
                'subtitleLine1' => $slide['subtitleLine1'] ?? ($intro['subtitle_line1'] ?? __('lum.villas.subtitle_line1')),
                'subtitleLine2' => $slide['subtitleLine2'] ?? ($intro['subtitle_line2'] ?? __('lum.villas.subtitle_line2')),
                'href' => route('villa.show', $slide['slug']),
            ]);
        })->values()->all();
    }

    /**
     * Home interior tabs+galleries from CMS.
     *
     * @return array{title_normal: string, title_caps: string, tabs: list<array{label: string, slides: list<string>}>}|null
     */
    public static function homeInterior(): ?array
    {
        $data = self::homeLocale('interior');
        if (! is_array($data)) {
            return null;
        }

        $rawTabs = is_array($data['tabs'] ?? null) ? $data['tabs'] : [];
        $tabs = [];

        foreach ($rawTabs as $tab) {
            if (is_string($tab)) {
                $tabs[] = [
                    'label' => $tab,
                    'slides' => ['slide-01', 'slide-02', 'slide-03', 'slide-04'],
                ];

                continue;
            }

            if (! is_array($tab)) {
                continue;
            }

            $images = is_array($tab['images'] ?? null) ? $tab['images'] : [];
            $slides = array_values(array_filter(array_map(
                fn ($img) => self::interiorStem(is_string($img) ? $img : null),
                $images,
            )));

            if ($slides === []) {
                continue;
            }

            $label = is_string($tab['label'] ?? null) ? $tab['label'] : '';
            if ($label === '') {
                continue;
            }

            $tabs[] = [
                'label' => $label,
                'slides' => $slides,
            ];
        }

        if ($tabs === []) {
            return [
                'title_normal' => $data['title_normal'] ?? __('lum.interior.title_normal'),
                'title_caps' => $data['title_caps'] ?? __('lum.interior.title_caps'),
                'tabs' => [],
            ];
        }

        return [
            'title_normal' => $data['title_normal'] ?? __('lum.interior.title_normal'),
            'title_caps' => $data['title_caps'] ?? __('lum.interior.title_caps'),
            'tabs' => $tabs,
        ];
    }

    public const BLOG_PER_PAGE = 6;

    public static function blogPosts(): Collection
    {
        $themes = BlogPost::THEME_CYCLE;

        return BlogPost::published()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->values()
            ->map(fn (BlogPost $p, int $index) => [
                'slug' => $p->slug,
                'title' => $p->title,
                'excerpt' => $p->excerpt,
                'image' => self::stripPrefix($p->image, 'blog/'),
                'tags' => $p->tags ?? [],
                'categories' => $p->categories ?? [],
                'theme' => $themes[$index % count($themes)],
            ]);
    }

    /**
     * Paginated blog listing. Themes cycle within the active category filter.
     * Pagination UI should render only when $paginator->hasPages().
     */
    public static function blogIndex(?string $category = null, int $page = 1): LengthAwarePaginator
    {
        $category = filled($category) ? $category : 'all';
        $page = max(1, $page);
        $themes = BlogPost::THEME_CYCLE;

        $all = self::blogPosts();

        if ($category !== 'all') {
            $all = $all
                ->filter(fn (array $post): bool => in_array($category, $post['categories'] ?? [], true))
                ->values()
                ->map(fn (array $post, int $index): array => array_merge($post, [
                    'theme' => $themes[$index % count($themes)],
                ]));
        }

        $perPage = self::BLOG_PER_PAGE;
        $total = $all->count();
        $items = $all->forPage($page, $perPage)->values();

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => route('blog'),
                'pageName' => 'page',
                'query' => array_filter([
                    'category' => $category !== 'all' ? $category : null,
                ]),
            ],
        );
    }

    /**
     * Filter tabs for /blog: All + distinct categories from published posts.
     *
     * @return array{keys: list<string>, labels: list<string>}
     */
    public static function blogTabs(): array
    {
        $keys = ['all'];
        $labels = [__('lum.blog.tab_all')];

        $labelMap = [
            'food' => 'lum.blog.tab_food',
            'beach' => 'lum.blog.tab_beach',
            'kitchen' => 'lum.blog.tab_kitchen',
            'sri-lanka' => 'lum.blog.tab_sri_lanka',
        ];

        foreach (BlogPost::usedCategories() as $category) {
            $keys[] = $category;
            $labels[] = isset($labelMap[$category])
                ? __($labelMap[$category])
                : mb_strtoupper(str_replace('-', '—', $category));
        }

        return ['keys' => $keys, 'labels' => $labels];
    }

    public static function blogPost(string $slug): ?array
    {
        $p = BlogPost::published()->where('slug', $slug)->first();
        if (! $p) {
            return null;
        }

        $title = (string) $p->title;
        $excerpt = (string) $p->excerpt;
        $metaTitle = trim((string) ($p->meta_title ?: ''));
        $metaDescription = trim((string) ($p->meta_description ?: ''));

        return [
            'meta_title' => $metaTitle !== '' ? $metaTitle : ($title.' — Lum'),
            'meta_description' => $metaDescription !== ''
                ? $metaDescription
                : \Illuminate\Support\Str::limit($excerpt, 160, ''),
            'title' => $title,
            'excerpt' => $excerpt,
            'tags' => $p->tags ?? [],
            'hero' => self::stripPrefix($p->hero ?: $p->image, 'blog/'),
            'body' => is_array($p->body) ? $p->body : [],
            'image' => self::stripPrefix($p->image, 'blog/'),
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
                'body_bottom' => $r->gallery_body_bottom ?? '',
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
                'body_bottom' => $a->gallery_body_bottom ?? '',
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
                'body' => $e->gallery_body ?? '',
                'body_bottom' => $e->gallery_body_bottom ?? '',
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
        $locale = app()->getLocale();
        $legal = $s->getTranslation('legal', $locale) ?: [];

        if ($s->phone_personal) {
            $replaced = false;

            foreach ($legal as $i => $row) {
                $label = mb_strtolower((string) ($row['label'] ?? ''));

                if (in_array($label, ['phone', 'телефон'], true)) {
                    $legal[$i]['value'] = $s->phone_personal;
                    $replaced = true;
                    break;
                }
            }

            if (! $replaced) {
                $legal[] = [
                    'label' => $locale === 'ru' ? 'Телефон' : 'Phone',
                    'value' => $s->phone_personal,
                ];
            }
        }

        return [
            'title' => __('lum.contact.title'),
            'address' => $s->address,
            'phone' => $s->phone,
            'phone_personal' => $s->phone_personal,
            'email' => $s->email,
            'see_on_map' => __('lum.contact.see_on_map'),
            'hours' => $s->getTranslation('hours', $locale) ?: [],
            'legal' => $legal,
            'map_url' => Site::mapUrl(),
            'phone_href' => Site::phoneHref(),
            'phone_personal_href' => Site::phonePersonalHref(),
            'email_href' => Site::emailHref(),
        ];
    }
}
