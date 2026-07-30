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
use Illuminate\Support\Arr;
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
            'phone_personal' => '+7 (916) 934-11-44',
            'email' => $en['contact']['email'],
            'map_url' => 'https://maps.google.com/?q=Thiththagalla+road,+Ahangama,+Sri+Lanka',
            'whatsapp_url' => $en['shop']['social_whatsapp_url'],
            'instagram_url' => $en['shop']['social_instagram_url'],
            'telegram_url' => 'https://t.me/ivantaskayev',
            'take_a_break_url' => $en['shop']['social_whatsapp_url'],
            'book_url' => $en['shop']['social_whatsapp_url'],
            'use_booking_page' => true,
            'menu_image' => 'menu/map.jpg',
        ]);

        $this->setTranslations($site, [
            'address' => ['en' => $en['contact']['address'], 'ru' => $ru['contact']['address']],
            'hours' => ['en' => $en['contact']['hours'], 'ru' => $ru['contact']['hours']],
            'legal' => ['en' => $en['contact']['legal'], 'ru' => $ru['contact']['legal']],
            'footer_address' => [
                'en' => [$en['footer']['address_line1'], $en['footer']['address_line2'], $en['footer']['address_line3']],
                'ru' => [$ru['footer']['address_line1'], $ru['footer']['address_line2'], $ru['footer']['address_line3']],
            ],
            'privacy_title' => [
                'en' => 'Privacy Policy',
                'ru' => 'Политика конфиденциальности',
            ],
            'privacy_body' => [
                'en' => <<<'TXT'
This is a placeholder Privacy Policy for Lum Residence.

We collect only the information you share with us when you enquire, book a stay, or contact us (for example your name, email, phone number, and stay details).

We use this information to respond to requests, manage bookings, and improve our guest experience. We do not sell your personal data.

If you have questions about how we handle your data, please contact us at the email listed on our Contacts page.

This text can be edited in the admin panel under Site settings → Privacy Policy.
TXT,
                'ru' => <<<'TXT'
Это заглушка Политики конфиденциальности Lum Residence.

Мы обрабатываем только те данные, которые вы сами передаёте при запросе, бронировании или обращении (например имя, email, телефон и детали проживания).

Данные используются для ответа на запросы, оформления бронирований и улучшения сервиса. Мы не продаём персональные данные третьим лицам.

Вопросы по обработке данных — на email со страницы Контакты.

Этот текст можно править в админке: Настройки сайта → Политика конфиденциальности.
TXT,
            ],
            'terms_title' => [
                'en' => 'Terms of Use',
                'ru' => 'Условия использования',
            ],
            'terms_body' => [
                'en' => <<<'TXT'
This is a placeholder Terms of Use for the Lum Residence website.

By using this website you agree to browse the content for informational purposes. Booking, payment, and stay terms may be confirmed separately when you reserve a villa or service.

Website content (texts, photos, design) belongs to Lum Residence unless otherwise noted. Please do not copy or reuse it without permission.

We may update these terms from time to time. The latest version is always published on this page.

This text can be edited in the admin panel under Site settings → Terms of Use.
TXT,
                'ru' => <<<'TXT'
Это заглушка Условий использования сайта Lum Residence.

Используя сайт, вы соглашаетесь просматривать материалы в информационных целях. Условия бронирования, оплаты и проживания подтверждаются отдельно при резерве виллы или услуги.

Контент сайта (тексты, фото, дизайн) принадлежит Lum Residence, если не указано иное. Копирование без разрешения не допускается.

Мы можем обновлять эти условия. Актуальная версия всегда на этой странице.

Этот текст можно править в админке: Настройки сайта → Условия использования.
TXT,
            ],
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
                    'sort_order' => $index + 1,
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
                    'en' => $enDetail['meta_title'] ?? ($enPost['title'].' — Lum'),
                    'ru' => $ruDetail['meta_title'] ?? ($ruPost['title'].' — Lum'),
                ],
                'meta_description' => [
                    'en' => $enDetail['meta_description'] ?? \Illuminate\Support\Str::limit($enPost['excerpt'] ?? '', 160, ''),
                    'ru' => $ruDetail['meta_description'] ?? \Illuminate\Support\Str::limit($ruPost['excerpt'] ?? '', 160, ''),
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
                    'sort_order' => $index + 1,
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
                    'sort_order' => $index + 1,
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
                ['sort_order' => $index + 1]
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
                    'sort_order' => $itemIndex + 1,
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
                    'sort_order' => $index + 1,
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
                    'sort_order' => $index + 1,
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
                    'sort_order' => $index + 1,
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
            'en' => array_merge($en['hero'], [
                'video' => 'hero/video.mp4',
                'video_poster' => 'hero/video-poster.png',
                'video_position' => 'center',
                'cta_url' => 'stay',
            ]),
            'ru' => array_merge($ru['hero'], [
                'video' => 'hero/video.mp4',
                'video_poster' => 'hero/video-poster.png',
                'video_position' => 'center',
                'cta_url' => 'stay',
            ]),
        ]);

        $polaroidPhotos = [
            'polaroids/photo-1.jpg',
            'polaroids/photo-2.jpg',
            'polaroids/photo-3.jpg',
        ];
        HomeSection::put('polaroids', [
            'en' => array_merge($en['polaroids'], [
                'photos' => $polaroidPhotos,
                'cta' => $en['hero']['cta'],
                'cta_url' => 'stay',
            ]),
            'ru' => array_merge($ru['polaroids'], [
                'photos' => $polaroidPhotos,
                'cta' => $ru['hero']['cta'],
                'cta_url' => 'stay',
            ]),
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

        $defaultInteriorImages = [
            'interior/slide-01.webp',
            'interior/slide-02.webp',
            'interior/slide-03.webp',
            'interior/slide-04.webp',
        ];
        $enInteriorTabs = [];
        $ruInteriorTabs = [];
        foreach ($en['interior']['tabs'] as $i => $label) {
            $enInteriorTabs[] = [
                'label' => $label,
                'images' => $defaultInteriorImages,
            ];
            $ruInteriorTabs[] = [
                'label' => $ru['interior']['tabs'][$i] ?? $label,
                'images' => $defaultInteriorImages,
            ];
        }

        HomeSection::put('interior', [
            'en' => [
                'title_normal' => $en['interior']['title_normal'],
                'title_caps' => $en['interior']['title_caps'],
                'tabs' => $enInteriorTabs,
            ],
            'ru' => [
                'title_normal' => $ru['interior']['title_normal'],
                'title_caps' => $ru['interior']['title_caps'],
                'tabs' => $ruInteriorTabs,
            ],
        ]);

        $blogSlugs = collect($en['blog']['posts'] ?? [])
            ->pluck('slug')
            ->filter()
            ->take(4)
            ->values()
            ->all();

        HomeSection::put('blog', [
            'en' => ['posts' => $blogSlugs],
            'ru' => ['posts' => $blogSlugs],
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

        $villasBySlug = Villa::query()->get()->keyBy('slug');
        $enSlides = [];
        $ruSlides = [];

        foreach ($en['villas']['slides'] as $i => $enSlide) {
            $slug = $enSlide['slug'] ?? null;
            $ruSlide = $ru['villas']['slides'][$i] ?? $enSlide;
            $villa = $slug ? $villasBySlug->get($slug) : null;
            $photo = $villa?->slide_photo ?: ('villas/' . ($enSlide['photo'] ?? sprintf('slide-%02d', $i + 1)) . '.webp');
            $oval = $villa?->slide_oval ?: ('villas/' . ($enSlide['oval'] ?? sprintf('oval-%02d', $i + 1)) . '.webp');

            $shared = [
                'villa_id' => $villa?->id,
                'slug' => $slug,
                'photo' => $photo,
                'oval' => $oval,
            ];

            $enSlides[] = array_merge($shared, [
                'title_normal' => $enSlide['titleNormal'] ?? '',
                'title_italic' => $enSlide['titleItalic'] ?? '',
                'title_mobile_normal' => $enSlide['titleMobileNormal'] ?? ($enSlide['titleNormal'] ?? ''),
                'title_mobile_italic' => $enSlide['titleMobileItalic'] ?? ($enSlide['titleItalic'] ?? ''),
                'subtitle' => $enSlide['subtitle'] ?? ($en['villas']['subtitle'] ?? ''),
                'subtitle_line1' => $enSlide['subtitleLine1'] ?? ($en['villas']['subtitle_line1'] ?? ''),
                'subtitle_line2' => $enSlide['subtitleLine2'] ?? ($en['villas']['subtitle_line2'] ?? ''),
                'titleNormal' => $enSlide['titleNormal'] ?? '',
                'titleItalic' => $enSlide['titleItalic'] ?? '',
                'subtitleLine1' => $enSlide['subtitleLine1'] ?? ($en['villas']['subtitle_line1'] ?? ''),
                'subtitleLine2' => $enSlide['subtitleLine2'] ?? ($en['villas']['subtitle_line2'] ?? ''),
            ]);

            $ruSlides[] = array_merge($shared, [
                'title_normal' => $ruSlide['titleNormal'] ?? '',
                'title_italic' => $ruSlide['titleItalic'] ?? '',
                'title_mobile_normal' => $ruSlide['titleMobileNormal'] ?? ($ruSlide['titleNormal'] ?? ''),
                'title_mobile_italic' => $ruSlide['titleMobileItalic'] ?? ($ruSlide['titleItalic'] ?? ''),
                'subtitle' => $ruSlide['subtitle'] ?? ($ru['villas']['subtitle'] ?? ''),
                'subtitle_line1' => $ruSlide['subtitleLine1'] ?? ($ru['villas']['subtitle_line1'] ?? ''),
                'subtitle_line2' => $ruSlide['subtitleLine2'] ?? ($ru['villas']['subtitle_line2'] ?? ''),
                'titleNormal' => $ruSlide['titleNormal'] ?? '',
                'titleItalic' => $ruSlide['titleItalic'] ?? '',
                'subtitleLine1' => $ruSlide['subtitleLine1'] ?? ($ru['villas']['subtitle_line1'] ?? ''),
                'subtitleLine2' => $ruSlide['subtitleLine2'] ?? ($ru['villas']['subtitle_line2'] ?? ''),
            ]);
        }

        $villasIntroKeys = [
            'eyebrow', 'lifestyle', 'view',
            'intro_mobile_1', 'intro_mobile_2', 'intro_mobile_3', 'intro_mobile_4', 'intro_mobile_5',
            'intro_tablet', 'intro_tablet_2', 'intro_tablet_3',
            'intro_desk_1', 'intro_desk_2', 'intro_desk_3', 'intro_desk_4',
            'subtitle', 'subtitle_line1', 'subtitle_line2',
        ];

        $enVillas = Arr::only($en['villas'], $villasIntroKeys);
        $ruVillas = Arr::only($ru['villas'], $villasIntroKeys);
        $enVillas['slides'] = $enSlides;
        $ruVillas['slides'] = $ruSlides;

        HomeSection::put('villas_intro', [
            'en' => $enVillas,
            'ru' => $ruVillas,
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
