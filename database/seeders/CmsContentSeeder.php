<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\BlogPost;
use App\Models\Excursion;
use App\Models\HomeSection;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\ShopProduct;
use App\Models\SiteSetting;
use App\Models\Villa;
use App\Support\Site;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Imports the static copy from lang/en/lum.php + lang/ru/lum.php into the CMS
 * Eloquent models so the front-end can eventually be driven from the database
 * instead of the translation files.
 */
class CmsContentSeeder extends Seeder
{
    private array $en;

    private array $ru;

    public function run(): void
    {
        $this->en = require lang_path('en/lum.php');
        $this->ru = require lang_path('ru/lum.php');

        DB::transaction(function () {
            $this->seedSiteSetting();
            $this->seedBlogPosts();
            $this->seedVillas();
            $this->seedRestaurants();
            $this->seedMenu();
            $this->seedActivities();
            $this->seedExcursions();
            $this->seedShopProducts();
            $this->seedHomeSections();
        });

        Site::forget();
    }

    private function seedSiteSetting(): void
    {
        $en = $this->en;
        $ru = $this->ru;

        $site = SiteSetting::query()->firstOrCreate([]);

        $site->fill([
            'phone' => $en['contact']['phone'],
            'phone_href' => 'tel:+94779296087',
            'email' => $en['contact']['email'],
            'map_url' => 'https://maps.google.com/?q=Thiththagalla+road,+Ahangama,+Sri+Lanka',
            'whatsapp_url' => $en['shop']['social_whatsapp_url'],
            'instagram_url' => $en['shop']['social_instagram_url'],
            'telegram_url' => 'https://t.me/ivantaskayev',
            'take_a_break_url' => $en['shop']['social_whatsapp_url'],
            'book_url' => $en['shop']['social_whatsapp_url'],
        ]);

        $this->setTranslations($site, [
            'address' => ['en' => $en['contact']['address'], 'ru' => $ru['contact']['address']],
            'hours' => ['en' => $en['contact']['hours'], 'ru' => $ru['contact']['hours']],
            'legal' => ['en' => $en['contact']['legal'], 'ru' => $ru['contact']['legal']],
            'footer_address' => [
                'en' => [$en['footer']['address_line1'], $en['footer']['address_line2'], $en['footer']['address_line3']],
                'ru' => [$ru['footer']['address_line1'], $ru['footer']['address_line2'], $ru['footer']['address_line3']],
            ],
            'reviews' => ['en' => $en['footer']['reviews'], 'ru' => $ru['footer']['reviews']],
            'copyright' => ['en' => $en['footer']['copyright'], 'ru' => $ru['footer']['copyright']],
        ]);
    }

    private function seedBlogPosts(): void
    {
        $enPosts = $this->en['blog']['posts'];
        $ruPosts = $this->ru['blog']['posts'];

        foreach ($enPosts as $index => $enPost) {
            $slug = $enPost['slug'];
            $ruPost = $ruPosts[$index] ?? $enPost;
            $enDetail = $this->en['post'][$slug] ?? [];
            $ruDetail = $this->ru['post'][$slug] ?? [];
            $heroImage = $enDetail['hero'] ?? $enPost['image'];

            $post = BlogPost::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'sort_order' => $index,
                    'is_published' => true,
                    'published_at' => now()->subDays(count($enPosts) - $index),
                    'theme' => $enPost['theme'] ?? 'cream',
                    'image' => 'blog/'.$enPost['image'],
                    'hero' => 'blog/'.$heroImage,
                    'tags' => $enPost['tags'] ?? [],
                    'categories' => $enPost['categories'] ?? [],
                ]
            );

            $this->setTranslations($post, [
                'title' => ['en' => $enPost['title'], 'ru' => $ruPost['title']],
                'excerpt' => ['en' => $enPost['excerpt'], 'ru' => $ruPost['excerpt']],
                'meta_title' => [
                    'en' => $enDetail['meta_title'] ?? $enPost['title'],
                    'ru' => $ruDetail['meta_title'] ?? $ruPost['title'],
                ],
                'body' => [
                    'en' => $enDetail['body'] ?? [],
                    'ru' => $ruDetail['body'] ?? [],
                ],
            ]);
        }
    }

    private function seedVillas(): void
    {
        $enProperties = $this->en['stay']['properties'];
        $ruProperties = collect($this->ru['stay']['properties'])->keyBy('slug');
        $enSlides = collect($this->en['villas']['slides'])->keyBy('slug');
        $ruSlides = collect($this->ru['villas']['slides'])->keyBy('slug');
        $enFacilities = $this->en['villa']['facilities'];
        $ruFacilities = $this->ru['villa']['facilities'];

        foreach ($enProperties as $index => $enProperty) {
            $slug = $enProperty['slug'];
            $ruProperty = $ruProperties->get($slug, $enProperty);
            $enSlide = $enSlides->get($slug, []);
            $ruSlide = $ruSlides->get($slug, []);
            $enDetail = $this->en['villa'][$slug] ?? [];
            $ruDetail = $this->ru['villa'][$slug] ?? [];

            $villa = Villa::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'sort_order' => $index,
                    'is_published' => true,
                    'listing_image' => 'stay/'.$enProperty['image'],
                    'slide_photo' => isset($enSlide['photo']) ? 'villas/'.$enSlide['photo'].'.webp' : null,
                    'slide_oval' => isset($enSlide['oval']) ? 'villas/'.$enSlide['oval'].'.webp' : null,
                    'hero_image' => 'villa/hero.webp',
                    'gallery_images' => ['villa/gallery-01.webp', 'villa/gallery-02.webp'],
                ]
            );

            $this->setTranslations($villa, [
                'title_normal' => [
                    'en' => $enSlide['titleNormal'] ?? $enProperty['title_normal'],
                    'ru' => $ruSlide['titleNormal'] ?? $ruProperty['title_normal'],
                ],
                'title_italic' => [
                    'en' => $enSlide['titleItalic'] ?? $enProperty['title_italic'],
                    'ru' => $ruSlide['titleItalic'] ?? $ruProperty['title_italic'],
                ],
                'title_mobile_normal' => [
                    'en' => $enSlide['titleMobileNormal'] ?? '',
                    'ru' => $ruSlide['titleMobileNormal'] ?? '',
                ],
                'title_mobile_italic' => [
                    'en' => $enSlide['titleMobileItalic'] ?? '',
                    'ru' => $ruSlide['titleMobileItalic'] ?? '',
                ],
                'subtitle' => [
                    'en' => $enSlide['subtitle'] ?? $enProperty['subtitle'],
                    'ru' => $ruSlide['subtitle'] ?? $ruProperty['subtitle'],
                ],
                'subtitle_line1' => [
                    'en' => $enSlide['subtitleLine1'] ?? '',
                    'ru' => $ruSlide['subtitleLine1'] ?? '',
                ],
                'subtitle_line2' => [
                    'en' => $enSlide['subtitleLine2'] ?? '',
                    'ru' => $ruSlide['subtitleLine2'] ?? '',
                ],
                'meta_title' => ['en' => $enDetail['meta_title'] ?? '', 'ru' => $ruDetail['meta_title'] ?? ''],
                'hero_eyebrow' => ['en' => $enDetail['hero']['eyebrow'] ?? '', 'ru' => $ruDetail['hero']['eyebrow'] ?? ''],
                'hero_title_normal' => ['en' => $enDetail['hero']['title_normal'] ?? '', 'ru' => $ruDetail['hero']['title_normal'] ?? ''],
                'hero_title_italic' => ['en' => $enDetail['hero']['title_italic'] ?? '', 'ru' => $ruDetail['hero']['title_italic'] ?? ''],
                'gallery_eyebrow' => ['en' => $enDetail['gallery']['eyebrow'] ?? '', 'ru' => $ruDetail['gallery']['eyebrow'] ?? ''],
                'gallery_title_normal' => ['en' => $enDetail['gallery']['title_normal'] ?? '', 'ru' => $ruDetail['gallery']['title_normal'] ?? ''],
                'gallery_title_italic' => ['en' => $enDetail['gallery']['title_italic'] ?? '', 'ru' => $ruDetail['gallery']['title_italic'] ?? ''],
                'gallery_body' => ['en' => $enDetail['gallery']['body'] ?? '', 'ru' => $ruDetail['gallery']['body'] ?? ''],
                'gallery_body_bottom' => ['en' => $enDetail['gallery']['body_bottom'] ?? '', 'ru' => $ruDetail['gallery']['body_bottom'] ?? ''],
                'facilities_left' => ['en' => $enFacilities['items_left'], 'ru' => $ruFacilities['items_left']],
                'facilities_right' => ['en' => $enFacilities['items_right'], 'ru' => $ruFacilities['items_right']],
            ]);
        }
    }

    private function seedRestaurants(): void
    {
        $enVenues = $this->en['dining']['venues'];
        $ruVenues = collect($this->ru['dining']['venues'])->keyBy('slug');
        $whatsapp = $this->en['shop']['social_whatsapp_url'];

        foreach ($enVenues as $index => $enVenue) {
            $slug = $enVenue['slug'];
            $ruVenue = $ruVenues->get($slug, $enVenue);
            $enDetail = $this->en['restaurant'][$slug] ?? [];
            $ruDetail = $this->ru['restaurant'][$slug] ?? [];
            $assetBase = 'dining/detail/'.$slug;

            $restaurant = Restaurant::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'sort_order' => $index,
                    'is_published' => true,
                    'opening_soon' => ($enVenue['cta'] ?? null) === 'opening_soon',
                    'listing_image' => 'dining/'.$enVenue['image'],
                    'hero_image' => $assetBase.'/hero.webp',
                    'oval_image' => $assetBase.'/oval.webp',
                    'gallery_images' => [$assetBase.'/gallery-01.webp', $assetBase.'/gallery-02.webp'],
                    'book_url' => $whatsapp,
                ]
            );

            $this->setTranslations($restaurant, [
                'eyebrow' => ['en' => $enVenue['eyebrow'] ?? '', 'ru' => $ruVenue['eyebrow'] ?? ''],
                'subtitle' => ['en' => $enVenue['subtitle'] ?? '', 'ru' => $ruVenue['subtitle'] ?? ''],
                'title_normal' => ['en' => $enVenue['title_normal'] ?? '', 'ru' => $ruVenue['title_normal'] ?? ''],
                'title_italic' => ['en' => $enVenue['title_italic'] ?? '', 'ru' => $ruVenue['title_italic'] ?? ''],
                'meta_title' => ['en' => $enDetail['meta_title'] ?? '', 'ru' => $ruDetail['meta_title'] ?? ''],
                'hero_eyebrow' => ['en' => $enDetail['hero']['eyebrow'] ?? '', 'ru' => $ruDetail['hero']['eyebrow'] ?? ''],
                'hero_title_normal' => ['en' => $enDetail['hero']['title_normal'] ?? '', 'ru' => $ruDetail['hero']['title_normal'] ?? ''],
                'hero_title_italic' => ['en' => $enDetail['hero']['title_italic'] ?? '', 'ru' => $ruDetail['hero']['title_italic'] ?? ''],
                'gallery_eyebrow' => ['en' => $enDetail['gallery']['eyebrow'] ?? '', 'ru' => $ruDetail['gallery']['eyebrow'] ?? ''],
                'gallery_title_normal' => ['en' => $enDetail['gallery']['title_normal'] ?? '', 'ru' => $ruDetail['gallery']['title_normal'] ?? ''],
                'gallery_title_italic' => ['en' => $enDetail['gallery']['title_italic'] ?? '', 'ru' => $ruDetail['gallery']['title_italic'] ?? ''],
                'gallery_body' => ['en' => $enDetail['gallery']['body'] ?? '', 'ru' => $ruDetail['gallery']['body'] ?? ''],
                'gallery_body_bottom' => ['en' => $enDetail['gallery']['body_bottom'] ?? '', 'ru' => $ruDetail['gallery']['body_bottom'] ?? ''],
                'quote_line1' => ['en' => $enDetail['quote']['line1'] ?? '', 'ru' => $ruDetail['quote']['line1'] ?? ''],
                'quote_line2' => ['en' => $enDetail['quote']['line2'] ?? '', 'ru' => $ruDetail['quote']['line2'] ?? ''],
                'quote_note_line1' => ['en' => $enDetail['quote']['note_line1'] ?? '', 'ru' => $ruDetail['quote']['note_line1'] ?? ''],
                'quote_note_line2' => ['en' => $enDetail['quote']['note_line2'] ?? '', 'ru' => $ruDetail['quote']['note_line2'] ?? ''],
            ]);
        }
    }

    private function seedMenu(): void
    {
        $enCategories = $this->en['restaurant']['menu_categories'];
        $ruCategories = collect($this->ru['restaurant']['menu_categories'])->keyBy('key');
        $enItems = $this->en['restaurant']['menu_items'];
        $ruItems = $this->ru['restaurant']['menu_items'];

        foreach ($enCategories as $index => $enCategory) {
            $key = $enCategory['key'];
            $ruCategory = $ruCategories->get($key, $enCategory);

            $category = MenuCategory::query()->updateOrCreate(
                ['key' => $key],
                ['sort_order' => $index]
            );

            $this->setTranslations($category, [
                'label' => ['en' => $enCategory['label'], 'ru' => $ruCategory['label']],
            ]);

            // Menu items have no natural unique key, so re-create them per category on every run.
            $category->items()->delete();

            $enCategoryItems = $enItems[$key] ?? [];
            $ruCategoryItems = $ruItems[$key] ?? [];

            foreach ($enCategoryItems as $itemIndex => $enItem) {
                $ruItem = $ruCategoryItems[$itemIndex] ?? $enItem;

                $menuItem = MenuItem::query()->create([
                    'menu_category_id' => $category->id,
                    'sort_order' => $itemIndex,
                ]);

                $this->setTranslations($menuItem, [
                    'name' => ['en' => $enItem['name'], 'ru' => $ruItem['name']],
                    'description' => ['en' => $enItem['description'], 'ru' => $ruItem['description']],
                    'price' => ['en' => $enItem['price'], 'ru' => $ruItem['price']],
                ]);
            }
        }
    }

    private function seedActivities(): void
    {
        $enActivities = $this->en['relax']['activities'];
        $ruActivities = collect($this->ru['relax']['activities'])->keyBy('slug');
        $whatsapp = $this->en['shop']['social_whatsapp_url'];

        foreach ($enActivities as $index => $enActivity) {
            $slug = $enActivity['slug'];
            $ruActivity = $ruActivities->get($slug, $enActivity);
            $enDetail = $this->en['activity'][$slug] ?? [];
            $ruDetail = $this->ru['activity'][$slug] ?? [];
            $assetBase = 'relax/detail/'.$slug;

            $activity = Activity::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'sort_order' => $index,
                    'is_published' => true,
                    'listing_image' => 'relax/'.$enActivity['image'],
                    'hero_image' => $assetBase.'/hero.webp',
                    'oval_image' => $assetBase.'/oval.webp',
                    'gallery_images' => [$assetBase.'/gallery-01.webp', $assetBase.'/gallery-02.webp'],
                    'pricing_cta_url' => $whatsapp,
                ]
            );

            $this->setTranslations($activity, [
                'label_before' => ['en' => $enActivity['label_before'] ?? '', 'ru' => $ruActivity['label_before'] ?? ''],
                'label_italic' => [
                    'en' => $enActivity['label_italic'] ?? $enActivity['label_all_italic'] ?? '',
                    'ru' => $ruActivity['label_italic'] ?? $ruActivity['label_all_italic'] ?? '',
                ],
                'label_after' => ['en' => $enActivity['label_after'] ?? '', 'ru' => $ruActivity['label_after'] ?? ''],
                'name' => ['en' => $enActivity['name'], 'ru' => $ruActivity['name']],
                'meta_title' => ['en' => $enDetail['meta_title'] ?? '', 'ru' => $ruDetail['meta_title'] ?? ''],
                'hero_eyebrow' => ['en' => $enDetail['hero']['eyebrow'] ?? '', 'ru' => $ruDetail['hero']['eyebrow'] ?? ''],
                'hero_title_normal' => ['en' => $enDetail['hero']['title_normal'] ?? '', 'ru' => $ruDetail['hero']['title_normal'] ?? ''],
                'hero_title_italic' => ['en' => $enDetail['hero']['title_italic'] ?? '', 'ru' => $ruDetail['hero']['title_italic'] ?? ''],
                'gallery_eyebrow' => ['en' => $enDetail['gallery']['eyebrow'] ?? '', 'ru' => $ruDetail['gallery']['eyebrow'] ?? ''],
                'gallery_title_normal' => ['en' => $enDetail['gallery']['title_normal'] ?? '', 'ru' => $ruDetail['gallery']['title_normal'] ?? ''],
                'gallery_title_italic' => ['en' => $enDetail['gallery']['title_italic'] ?? '', 'ru' => $ruDetail['gallery']['title_italic'] ?? ''],
                'gallery_body' => ['en' => $enDetail['gallery']['body'] ?? '', 'ru' => $ruDetail['gallery']['body'] ?? ''],
                'gallery_body_bottom' => ['en' => $enDetail['gallery']['body_bottom'] ?? '', 'ru' => $ruDetail['gallery']['body_bottom'] ?? ''],
                'quote_line1' => ['en' => $enDetail['quote']['line1'] ?? '', 'ru' => $ruDetail['quote']['line1'] ?? ''],
                'quote_line2' => ['en' => $enDetail['quote']['line2'] ?? '', 'ru' => $ruDetail['quote']['line2'] ?? ''],
                'quote_note' => [
                    'en' => implode("\n", array_filter([$enDetail['quote']['note_line1'] ?? '', $enDetail['quote']['note_line2'] ?? ''])),
                    'ru' => implode("\n", array_filter([$ruDetail['quote']['note_line1'] ?? '', $ruDetail['quote']['note_line2'] ?? ''])),
                ],
                'pricing_eyebrow' => ['en' => $enDetail['pricing']['eyebrow'] ?? '', 'ru' => $ruDetail['pricing']['eyebrow'] ?? ''],
                'pricing_title_normal' => ['en' => $enDetail['pricing']['title_normal'] ?? '', 'ru' => $ruDetail['pricing']['title_normal'] ?? ''],
                'pricing_title_italic' => ['en' => $enDetail['pricing']['title_italic'] ?? '', 'ru' => $ruDetail['pricing']['title_italic'] ?? ''],
                'pricing_cta' => ['en' => $enDetail['pricing']['cta'] ?? '', 'ru' => $ruDetail['pricing']['cta'] ?? ''],
                'pricing_items' => ['en' => $enDetail['pricing']['items'] ?? [], 'ru' => $ruDetail['pricing']['items'] ?? []],
            ]);
        }
    }

    private function seedExcursions(): void
    {
        $enPlaces = $this->en['discover']['places'];
        $ruPlaces = collect($this->ru['discover']['places'])->keyBy('slug');
        $whatsapp = $this->en['shop']['social_whatsapp_url'];

        foreach ($enPlaces as $index => $enPlace) {
            $slug = $enPlace['slug'];
            $ruPlace = $ruPlaces->get($slug, $enPlace);
            $enDetail = $this->en['excursion'][$slug] ?? [];
            $ruDetail = $this->ru['excursion'][$slug] ?? [];
            $assetBase = 'discover/detail/'.$slug;

            $excursion = Excursion::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'sort_order' => $index,
                    'is_published' => true,
                    'listing_image' => 'discover/'.$enPlace['image'],
                    'oval_image' => $assetBase.'/oval.webp',
                    'wellness_hero' => $assetBase.'/wellness-hero.webp',
                    'gallery_images' => [$assetBase.'/gallery-01.webp', $assetBase.'/gallery-02.webp', $assetBase.'/gallery-03.webp'],
                    'package_images' => [$assetBase.'/package-01.webp', $assetBase.'/package-02.webp'],
                    'book_url' => $whatsapp,
                ]
            );

            $this->setTranslations($excursion, [
                'title' => ['en' => $enPlace['title'], 'ru' => $ruPlace['title']],
                'region' => ['en' => $enPlace['region'], 'ru' => $ruPlace['region']],
                'meta_title' => ['en' => $enDetail['meta_title'] ?? '', 'ru' => $ruDetail['meta_title'] ?? ''],
                'intro_title' => ['en' => $enDetail['intro']['title'] ?? '', 'ru' => $ruDetail['intro']['title'] ?? ''],
                'intro_body' => ['en' => $enDetail['intro']['body'] ?? '', 'ru' => $ruDetail['intro']['body'] ?? ''],
                'gallery_eyebrow' => ['en' => $enDetail['gallery']['eyebrow'] ?? '', 'ru' => $ruDetail['gallery']['eyebrow'] ?? ''],
                'gallery_title_normal' => ['en' => $enDetail['gallery']['title_normal'] ?? '', 'ru' => $ruDetail['gallery']['title_normal'] ?? ''],
                'gallery_title_italic' => ['en' => $enDetail['gallery']['title_italic'] ?? '', 'ru' => $ruDetail['gallery']['title_italic'] ?? ''],
                'gallery_body' => ['en' => $enDetail['gallery']['body'] ?? '', 'ru' => $ruDetail['gallery']['body'] ?? ''],
                'gallery_body_bottom' => ['en' => $enDetail['gallery']['body_bottom'] ?? '', 'ru' => $ruDetail['gallery']['body_bottom'] ?? ''],
                'polaroid_dates' => ['en' => $enDetail['gallery']['polaroid_dates'] ?? [], 'ru' => $ruDetail['gallery']['polaroid_dates'] ?? []],
                'package_eyebrow' => ['en' => $enDetail['package']['eyebrow'] ?? '', 'ru' => $ruDetail['package']['eyebrow'] ?? ''],
                'package_title_normal' => ['en' => $enDetail['package']['title_normal'] ?? '', 'ru' => $ruDetail['package']['title_normal'] ?? ''],
                'package_title_italic' => ['en' => $enDetail['package']['title_italic'] ?? '', 'ru' => $ruDetail['package']['title_italic'] ?? ''],
                'package_items' => ['en' => $enDetail['package']['items'] ?? [], 'ru' => $ruDetail['package']['items'] ?? []],
                'package_cost' => ['en' => $enDetail['package']['cost'] ?? '', 'ru' => $ruDetail['package']['cost'] ?? ''],
            ]);
        }
    }

    private function seedShopProducts(): void
    {
        $enItems = $this->en['shop']['items'];
        $ruItems = $this->ru['shop']['items'];
        $price = $this->en['shop']['cta_price'];

        $index = 0;

        foreach ($enItems as $slug => $enItem) {
            $ruItem = $ruItems[$slug] ?? $enItem;

            $product = ShopProduct::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'type' => $enItem['type'] ?? 'tee',
                    'sort_order' => $index,
                    'is_published' => true,
                    'image' => 'shop/'.$enItem['image'],
                    'thumbs' => array_map(fn ($thumb) => 'shop/'.$thumb, $enItem['thumbs'] ?? []),
                    'colors' => array_map(fn ($color) => 'shop/'.$color, $enItem['colors'] ?? []),
                    'sizes' => $enItem['sizes'] ?? [],
                    'price' => $price,
                ]
            );

            $this->setTranslations($product, [
                'title' => ['en' => $enItem['title'], 'ru' => $ruItem['title']],
                'subtitle' => ['en' => $enItem['subtitle'], 'ru' => $ruItem['subtitle']],
            ]);

            $index++;
        }
    }

    private function seedHomeSections(): void
    {
        $en = $this->en;
        $ru = $this->ru;

        HomeSection::put('hero', [
            'en' => $en['hero'],
            'ru' => $ru['hero'],
        ]);

        HomeSection::put('polaroids', [
            'en' => $en['polaroids'],
            'ru' => $ru['polaroids'],
        ]);

        HomeSection::put('location', [
            'en' => [
                'heading' => $en['location']['heading'],
                'see_on_map' => $en['location']['see_on_map'],
                'see_on_map_upper' => $en['location']['see_on_map_upper'],
                'more_info' => $en['location']['more_info'],
                'cards' => $en['location']['cards'],
            ],
            'ru' => [
                'heading' => $ru['location']['heading'],
                'see_on_map' => $ru['location']['see_on_map'],
                'see_on_map_upper' => $ru['location']['see_on_map_upper'],
                'more_info' => $ru['location']['more_info'],
                'cards' => $ru['location']['cards'],
            ],
        ]);

        HomeSection::put('interior', [
            'en' => $en['interior'],
            'ru' => $ru['interior'],
        ]);

        HomeSection::put('shop_teaser', [
            'en' => [
                'eyebrow' => $en['shop']['eyebrow'],
                'title_normal' => $en['shop']['title_normal'],
                'title_italic' => $en['shop']['title_italic'],
                'cta' => $en['shop']['cta'],
                'background_image' => 'shop/bg.jpg',
            ],
            'ru' => [
                'eyebrow' => $ru['shop']['eyebrow'],
                'title_normal' => $ru['shop']['title_normal'],
                'title_italic' => $ru['shop']['title_italic'],
                'cta' => $ru['shop']['cta'],
                'background_image' => 'shop/bg.jpg',
            ],
        ]);

        HomeSection::put('villas_intro', [
            'en' => $en['villas'],
            'ru' => $ru['villas'],
        ]);
    }

    private function setTranslations(Model $model, array $fields): void
    {
        foreach ($fields as $field => $locales) {
            $model->setTranslations($field, $locales);
        }

        $model->save();
    }
}
