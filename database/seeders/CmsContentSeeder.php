<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\BlogPost;
use App\Models\Excursion;
use App\Models\HomeSection;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\PageSection;
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
 * Imports the static copy from lang/en/lum.php, lang/ru/lum.php, and lang/zh/lum.php
 * into the CMS Eloquent models so the front-end can eventually be driven from the
 * database instead of the translation files.
 */
class CmsContentSeeder extends Seeder
{
    private array $en;

    private array $ru;

    private array $zh;

    private bool $zhOnly = false;

    /**
     * @return array{en: mixed, ru: mixed, zh: mixed}
     */
    private function i18n(mixed $en, mixed $ru, mixed $zh = null): array
    {
        return ['en' => $en, 'ru' => $ru, 'zh' => $zh ?? $en];
    }

    public function run(): void
    {
        $this->en = require lang_path('en/lum.php');
        $this->ru = require lang_path('ru/lum.php');
        $this->zh = require lang_path('zh/lum.php');
        $this->zhOnly = false;

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
            $this->seedPageSections();
        });

        Site::forget();
    }

    public function backfillZhOnly(): void
    {
        $this->en = require lang_path('en/lum.php');
        $this->ru = require lang_path('ru/lum.php');
        $this->zh = require lang_path('zh/lum.php');
        $this->zhOnly = true;

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
            $this->seedPageSections();
        });

        Site::forget();
    }

    /**
     * @param  list<string>  $enTabs
     * @param  list<string>  $ruTabs
     * @param  list<string>  $zhTabs
     * @param  list<string>  $images
     * @return list<array{label: array{en: string, ru: string, zh: string}, images: list<string>}>
     */
    private function buildImpressionGalleries(array $enTabs, array $ruTabs, array $zhTabs, array $images): array
    {
        $galleries = [];
        $tabCount = max(count($enTabs), count($ruTabs), count($zhTabs));

        for ($ti = 0; $ti < $tabCount; $ti++) {
            $enLabel = is_string($enTabs[$ti] ?? null) ? $enTabs[$ti] : '';
            $ruLabel = is_string($ruTabs[$ti] ?? null) ? $ruTabs[$ti] : '';
            $zhLabel = is_string($zhTabs[$ti] ?? null) ? $zhTabs[$ti] : '';

            if ($enLabel === '' && $ruLabel === '' && $zhLabel === '') {
                continue;
            }

            $galleries[] = [
                'label' => $this->i18n(
                    $enLabel !== '' ? $enLabel : ($ruLabel !== '' ? $ruLabel : $zhLabel),
                    $ruLabel !== '' ? $ruLabel : ($enLabel !== '' ? $enLabel : $zhLabel),
                    $zhLabel !== '' ? $zhLabel : ($enLabel !== '' ? $enLabel : $ruLabel),
                ),
                'images' => $images,
            ];
        }

        return $galleries;
    }

    /**
     * @param  list<array{label: array<string, string>, images: list<string>}>  $galleries
     * @param  list<string>  $zhTabs
     * @return list<array{label: array<string, string>, images: list<string>}>
     */
    private function mergeImpressionGalleryZh(array $galleries, array $zhTabs): array
    {
        foreach ($galleries as $i => $gallery) {
            $zhLabel = is_string($zhTabs[$i] ?? null) ? $zhTabs[$i] : '';
            $enLabel = $gallery['label']['en'] ?? '';
            $ruLabel = $gallery['label']['ru'] ?? '';
            $galleries[$i]['label']['zh'] = $zhLabel !== '' ? $zhLabel : ($enLabel !== '' ? $enLabel : $ruLabel);
        }

        return $galleries;
    }

    private function putHomeSection(string $key, array $payload): void
    {
        if ($this->zhOnly) {
            $existing = HomeSection::get($key, []);
            $existing['zh'] = $payload['zh'];
            HomeSection::put($key, $existing);

            return;
        }

        HomeSection::put($key, $payload);
    }

    private function putPageSection(string $page, string $key, array $payload): void
    {
        if ($this->zhOnly) {
            $existing = PageSection::get($page, $key, []);
            $existing['zh'] = $payload['zh'];
            PageSection::put($page, $key, $existing);

            return;
        }

        PageSection::put($page, $key, $payload);
    }

    private function seedSiteSetting(): void
    {
        $en = $this->en;
        $ru = $this->ru;
        $zh = $this->zh;

        if ($this->zhOnly) {
            $site = SiteSetting::query()->first();
            if (! $site) {
                return;
            }
        } else {
            $site = SiteSetting::query()->firstOrCreate([]);
        }

        if (! $this->zhOnly) {
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
        }

        $this->setTranslations($site, [
            'address' => $this->i18n($en['contact']['address'], $ru['contact']['address'], $zh['contact']['address']),
            'hours' => $this->i18n($en['contact']['hours'], $ru['contact']['hours'], $zh['contact']['hours']),
            'legal' => $this->i18n($en['contact']['legal'], $ru['contact']['legal'], $zh['contact']['legal']),
            'footer_address' => $this->i18n(
                [$en['footer']['address_line1'], $en['footer']['address_line2'], $en['footer']['address_line3']],
                [$ru['footer']['address_line1'], $ru['footer']['address_line2'], $ru['footer']['address_line3']],
                [$zh['footer']['address_line1'], $zh['footer']['address_line2'], $zh['footer']['address_line3']],
            ),
            'privacy_title' => $this->i18n('Privacy Policy', 'Политика конфиденциальности', '隐私政策'),
            'privacy_body' => $this->i18n(
                <<<'TXT'
This is a placeholder Privacy Policy for Lum Residence.

We collect only the information you share with us when you enquire, book a stay, or contact us (for example your name, email, phone number, and stay details).

We use this information to respond to requests, manage bookings, and improve our guest experience. We do not sell your personal data.

If you have questions about how we handle your data, please contact us at the email listed on our Contacts page.

This text can be edited in the admin panel under Site settings → Privacy Policy.
TXT,
                <<<'TXT'
Это заглушка Политики конфиденциальности Lum Residence.

Мы обрабатываем только те данные, которые вы сами передаёте при запросе, бронировании или обращении (например имя, email, телефон и детали проживания).

Данные используются для ответа на запросы, оформления бронирований и улучшения сервиса. Мы не продаём персональные данные третьим лицам.

Вопросы по обработке данных — на email со страницы Контакты.

Этот текст можно править в админке: Настройки сайта → Политика конфиденциальности.
TXT,
                <<<'TXT'
这是 Lum Residence 隐私政策的占位文本。

我们仅收集您在咨询、预订或联系我们时主动提供的信息（例如姓名、电子邮件、电话号码及住宿详情）。

这些信息用于回复您的请求、管理预订并改善宾客体验。我们不会出售您的个人数据。

如对数据处理有任何疑问，请通过联系我们页面所列邮箱与我们联系。

可在管理后台「网站设置 → 隐私政策」中编辑本文本。
TXT,
            ),
            'terms_title' => $this->i18n('Terms of Use', 'Условия использования', '使用条款'),
            'terms_body' => $this->i18n(
                <<<'TXT'
This is a placeholder Terms of Use for the Lum Residence website.

By using this website you agree to browse the content for informational purposes. Booking, payment, and stay terms may be confirmed separately when you reserve a villa or service.

Website content (texts, photos, design) belongs to Lum Residence unless otherwise noted. Please do not copy or reuse it without permission.

We may update these terms from time to time. The latest version is always published on this page.

This text can be edited in the admin panel under Site settings → Terms of Use.
TXT,
                <<<'TXT'
Это заглушка Условий использования сайта Lum Residence.

Используя сайт, вы соглашаетесь просматривать материалы в информационных целях. Условия бронирования, оплаты и проживания подтверждаются отдельно при резерве виллы или услуги.

Контент сайта (тексты, фото, дизайн) принадлежит Lum Residence, если не указано иное. Копирование без разрешения не допускается.

Мы можем обновлять эти условия. Актуальная версия всегда на этой странице.

Этот текст можно править в админке: Настройки сайта → Условия использования.
TXT,
                <<<'TXT'
这是 Lum Residence 网站使用条款的占位文本。

使用本网站即表示您同意为获取信息而浏览相关内容。预订、付款及住宿条款可能在您预订别墅或服务时另行确认。

网站内容（文字、照片、设计）除非另有说明，均归 Lum Residence 所有。未经许可请勿复制或使用。

我们可能不时更新本条款。最新版本始终发布于本页面。

可在管理后台「网站设置 → 使用条款」中编辑本文本。
TXT,
            ),
        ]);
    }

    private function seedBlogPosts(): void
    {
        $enPosts = $this->en['blog']['posts'];
        $ruPosts = $this->ru['blog']['posts'];
        $zhPosts = $this->zh['blog']['posts'];

        foreach ($enPosts as $index => $enPost) {
            $slug = $enPost['slug'];
            $ruPost = $ruPosts[$index] ?? $enPost;
            $zhPost = $zhPosts[$index] ?? $enPost;
            $enDetail = $this->en['post'][$slug] ?? [];
            $ruDetail = $this->ru['post'][$slug] ?? [];
            $zhDetail = $this->zh['post'][$slug] ?? [];
            $heroImage = $enDetail['hero'] ?? $enPost['image'];

            if ($this->zhOnly) {
                $post = BlogPost::query()->where('slug', $slug)->first();
                if (! $post) {
                    continue;
                }
            } else {
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
            }

            $this->setTranslations($post, [
                'title' => $this->i18n($enPost['title'], $ruPost['title'], $zhPost['title']),
                'excerpt' => $this->i18n($enPost['excerpt'], $ruPost['excerpt'], $zhPost['excerpt']),
                'meta_title' => $this->i18n(
                    $enDetail['meta_title'] ?? ($enPost['title'].' — Lum'),
                    $ruDetail['meta_title'] ?? ($ruPost['title'].' — Lum'),
                    $zhDetail['meta_title'] ?? ($zhPost['title'].' — Lum'),
                ),
                'meta_description' => $this->i18n(
                    $enDetail['meta_description'] ?? \Illuminate\Support\Str::limit($enPost['excerpt'] ?? '', 160, ''),
                    $ruDetail['meta_description'] ?? \Illuminate\Support\Str::limit($ruPost['excerpt'] ?? '', 160, ''),
                    $zhDetail['meta_description'] ?? \Illuminate\Support\Str::limit($zhPost['excerpt'] ?? '', 160, ''),
                ),
                'body' => $this->i18n(
                    $enDetail['body'] ?? [],
                    $ruDetail['body'] ?? [],
                    $zhDetail['body'] ?? [],
                ),
            ]);
        }
    }

    private function seedVillas(): void
    {
        $enProperties = $this->en['stay']['properties'];
        $ruProperties = collect($this->ru['stay']['properties'])->keyBy('slug');
        $zhProperties = collect($this->zh['stay']['properties'])->keyBy('slug');
        $enSlides = collect($this->en['villas']['slides'])->keyBy('slug');
        $ruSlides = collect($this->ru['villas']['slides'])->keyBy('slug');
        $zhSlides = collect($this->zh['villas']['slides'])->keyBy('slug');
        $enFacilities = $this->en['villa']['facilities'];
        $ruFacilities = $this->ru['villa']['facilities'];
        $zhFacilities = $this->zh['villa']['facilities'];

        foreach ($enProperties as $index => $enProperty) {
            $slug = $enProperty['slug'];
            $ruProperty = $ruProperties->get($slug, $enProperty);
            $zhProperty = $zhProperties->get($slug, $enProperty);
            $enSlide = $enSlides->get($slug, []);
            $ruSlide = $ruSlides->get($slug, []);
            $zhSlide = $zhSlides->get($slug, []);
            $enDetail = $this->en['villa'][$slug] ?? [];
            $ruDetail = $this->ru['villa'][$slug] ?? [];
            $zhDetail = $this->zh['villa'][$slug] ?? [];

            $enImpression = $this->en['villa']['impression'] ?? [];
            $ruImpression = $this->ru['villa']['impression'] ?? [];
            $zhImpression = $this->zh['villa']['impression'] ?? [];
            $enTabs = is_array($enImpression['tabs'] ?? null) ? $enImpression['tabs'] : [];
            $ruTabs = is_array($ruImpression['tabs'] ?? null) ? $ruImpression['tabs'] : [];
            $zhTabs = is_array($zhImpression['tabs'] ?? null) ? $zhImpression['tabs'] : [];
            $impressionImages = [
                'villa/impression/slide-01.webp',
                'villa/impression/slide-02.webp',
                'villa/impression/slide-03.webp',
                'villa/impression/slide-04.webp',
            ];
            $impressionGalleries = $this->buildImpressionGalleries($enTabs, $ruTabs, $zhTabs, $impressionImages);

            if ($this->zhOnly) {
                $villa = Villa::query()->where('slug', $slug)->first();
                if (! $villa) {
                    continue;
                }
                $villa->impression_galleries = $this->mergeImpressionGalleryZh(
                    $villa->impression_galleries ?? $impressionGalleries,
                    $zhTabs,
                );
                $villa->save();
            } else {
                $villa = Villa::query()->updateOrCreate(
                    ['slug' => $slug],
                    [
                        'sort_order' => $index + 1,
                        'is_published' => true,
                        'exely_hotel_id' => config('exely.villa_hotels.'.$slug) ?: null,
                        'impression_cta_mode' => 'villa',
                        'listing_image' => 'stay/'.$enProperty['image'],
                        'slide_photo' => isset($enSlide['photo']) ? 'villas/'.$enSlide['photo'].'.webp' : null,
                        'slide_oval' => isset($enSlide['oval']) ? 'villas/'.$enSlide['oval'].'.webp' : null,
                        'hero_image' => 'villa/hero.webp',
                        'gallery_images' => [
                            ['path' => 'villa/gallery-01.webp', 'date' => '06.08.2023'],
                            ['path' => 'villa/gallery-02.webp', 'date' => '06.01.2024'],
                            ['path' => 'villa/gallery-03.webp', 'date' => '07.03.2023'],
                        ],
                        'facilities_image_left' => 'villa/facilities-left.webp',
                        'facilities_image_right' => 'villa/facilities-right.webp',
                        'impression_galleries' => $impressionGalleries,
                    ]
                );
            }

            $this->setTranslations($villa, [
                'title_normal' => $this->i18n(
                    $enSlide['titleNormal'] ?? $enProperty['title_normal'],
                    $ruSlide['titleNormal'] ?? $ruProperty['title_normal'],
                    $zhSlide['titleNormal'] ?? $zhProperty['title_normal'],
                ),
                'title_italic' => $this->i18n(
                    $enSlide['titleItalic'] ?? $enProperty['title_italic'],
                    $ruSlide['titleItalic'] ?? $ruProperty['title_italic'],
                    $zhSlide['titleItalic'] ?? $zhProperty['title_italic'],
                ),
                'title_mobile_normal' => $this->i18n(
                    $enSlide['titleMobileNormal'] ?? '',
                    $ruSlide['titleMobileNormal'] ?? '',
                    $zhSlide['titleMobileNormal'] ?? '',
                ),
                'title_mobile_italic' => $this->i18n(
                    $enSlide['titleMobileItalic'] ?? '',
                    $ruSlide['titleMobileItalic'] ?? '',
                    $zhSlide['titleMobileItalic'] ?? '',
                ),
                'subtitle' => $this->i18n(
                    $enSlide['subtitle'] ?? $enProperty['subtitle'],
                    $ruSlide['subtitle'] ?? $ruProperty['subtitle'],
                    $zhSlide['subtitle'] ?? $zhProperty['subtitle'],
                ),
                'subtitle_line1' => $this->i18n(
                    $enSlide['subtitleLine1'] ?? '',
                    $ruSlide['subtitleLine1'] ?? '',
                    $zhSlide['subtitleLine1'] ?? '',
                ),
                'subtitle_line2' => $this->i18n(
                    $enSlide['subtitleLine2'] ?? '',
                    $ruSlide['subtitleLine2'] ?? '',
                    $zhSlide['subtitleLine2'] ?? '',
                ),
                'meta_title' => $this->i18n(
                    $enDetail['meta_title'] ?? '',
                    $ruDetail['meta_title'] ?? '',
                    $zhDetail['meta_title'] ?? '',
                ),
                'hero_eyebrow' => $this->i18n(
                    $enDetail['hero']['eyebrow'] ?? '',
                    $ruDetail['hero']['eyebrow'] ?? '',
                    $zhDetail['hero']['eyebrow'] ?? '',
                ),
                'hero_title_normal' => $this->i18n(
                    $enDetail['hero']['title_normal'] ?? '',
                    $ruDetail['hero']['title_normal'] ?? '',
                    $zhDetail['hero']['title_normal'] ?? '',
                ),
                'hero_title_italic' => $this->i18n(
                    $enDetail['hero']['title_italic'] ?? '',
                    $ruDetail['hero']['title_italic'] ?? '',
                    $zhDetail['hero']['title_italic'] ?? '',
                ),
                'gallery_eyebrow' => $this->i18n(
                    $enDetail['gallery']['eyebrow'] ?? '',
                    $ruDetail['gallery']['eyebrow'] ?? '',
                    $zhDetail['gallery']['eyebrow'] ?? '',
                ),
                'gallery_title_normal' => $this->i18n(
                    $enDetail['gallery']['title_normal'] ?? '',
                    $ruDetail['gallery']['title_normal'] ?? '',
                    $zhDetail['gallery']['title_normal'] ?? '',
                ),
                'gallery_title_italic' => $this->i18n(
                    $enDetail['gallery']['title_italic'] ?? '',
                    $ruDetail['gallery']['title_italic'] ?? '',
                    $zhDetail['gallery']['title_italic'] ?? '',
                ),
                'gallery_body' => $this->i18n(
                    $enDetail['gallery']['body'] ?? '',
                    $ruDetail['gallery']['body'] ?? '',
                    $zhDetail['gallery']['body'] ?? '',
                ),
                'gallery_body_bottom' => $this->i18n(
                    $enDetail['gallery']['body_bottom'] ?? '',
                    $ruDetail['gallery']['body_bottom'] ?? '',
                    $zhDetail['gallery']['body_bottom'] ?? '',
                ),
                'facilities_eyebrow' => $this->i18n(
                    $enFacilities['eyebrow'] ?? '',
                    $ruFacilities['eyebrow'] ?? '',
                    $zhFacilities['eyebrow'] ?? '',
                ),
                'facilities_title_normal' => $this->i18n(
                    $enFacilities['title_normal'] ?? '',
                    $ruFacilities['title_normal'] ?? '',
                    $zhFacilities['title_normal'] ?? '',
                ),
                'facilities_title_italic' => $this->i18n(
                    $enFacilities['title_italic'] ?? '',
                    $ruFacilities['title_italic'] ?? '',
                    $zhFacilities['title_italic'] ?? '',
                ),
                'facilities_left' => $this->i18n(
                    $enFacilities['items_left'],
                    $ruFacilities['items_left'],
                    $zhFacilities['items_left'],
                ),
                'facilities_right' => $this->i18n(
                    $enFacilities['items_right'],
                    $ruFacilities['items_right'],
                    $zhFacilities['items_right'],
                ),
                'impression_title_normal' => $this->i18n(
                    $enImpression['title_normal'] ?? '',
                    $ruImpression['title_normal'] ?? '',
                    $zhImpression['title_normal'] ?? '',
                ),
                'impression_title_caps' => $this->i18n(
                    $enImpression['title_caps'] ?? '',
                    $ruImpression['title_caps'] ?? '',
                    $zhImpression['title_caps'] ?? '',
                ),
                'impression_cta' => $this->i18n(
                    $this->en['nav']['take_a_break'] ?? 'take a break',
                    $this->ru['nav']['take_a_break'] ?? 'сделать паузу',
                    $this->zh['nav']['take_a_break'] ?? '稍作休息',
                ),
            ]);
        }
    }

    private function seedRestaurants(): void
    {
        $enVenues = $this->en['dining']['venues'];
        $ruVenues = collect($this->ru['dining']['venues'])->keyBy('slug');
        $zhVenues = collect($this->zh['dining']['venues'])->keyBy('slug');
        $whatsapp = $this->en['shop']['social_whatsapp_url'];
        $enImpression = $this->en['restaurant']['impression'] ?? [];
        $ruImpression = $this->ru['restaurant']['impression'] ?? [];
        $zhImpression = $this->zh['restaurant']['impression'] ?? [];
        $enTabs = is_array($enImpression['tabs'] ?? null) ? $enImpression['tabs'] : [];
        $ruTabs = is_array($ruImpression['tabs'] ?? null) ? $ruImpression['tabs'] : [];
        $zhTabs = is_array($zhImpression['tabs'] ?? null) ? $zhImpression['tabs'] : [];
        $impressionImages = [
            'dining/detail/shared/impression/slide-01.webp',
            'dining/detail/shared/impression/slide-02.webp',
            'dining/detail/shared/impression/slide-03.webp',
            'dining/detail/shared/impression/slide-04.webp',
        ];
        $impressionGalleries = $this->buildImpressionGalleries($enTabs, $ruTabs, $zhTabs, $impressionImages);

        foreach ($enVenues as $index => $enVenue) {
            $slug = $enVenue['slug'];
            $ruVenue = $ruVenues->get($slug, $enVenue);
            $zhVenue = $zhVenues->get($slug, $enVenue);
            $enDetail = $this->en['restaurant'][$slug] ?? [];
            $ruDetail = $this->ru['restaurant'][$slug] ?? [];
            $zhDetail = $this->zh['restaurant'][$slug] ?? [];
            $assetBase = 'dining/detail/'.$slug;

            if ($this->zhOnly) {
                $restaurant = Restaurant::query()->where('slug', $slug)->first();
                if (! $restaurant) {
                    continue;
                }
                $restaurant->impression_galleries = $this->mergeImpressionGalleryZh(
                    $restaurant->impression_galleries ?? $impressionGalleries,
                    $zhTabs,
                );
                $restaurant->save();
            } else {
                $restaurant = Restaurant::query()->updateOrCreate(
                    ['slug' => $slug],
                    [
                        'sort_order' => $index + 1,
                        'is_published' => true,
                        'opening_soon' => ($enVenue['cta'] ?? null) === 'opening_soon',
                        'listing_image' => 'dining/'.$enVenue['image'],
                        'hero_image' => $assetBase.'/hero.webp',
                        'oval_image' => $assetBase.'/oval.webp',
                        'gallery_images' => [
                            ['path' => $assetBase.'/gallery-01.webp', 'date' => '06.08.2023'],
                            ['path' => $assetBase.'/gallery-02.webp', 'date' => '06.01.2024'],
                            ['path' => $assetBase.'/gallery-03.webp', 'date' => '07.03.2023'],
                        ],
                        'impression_cta_mode' => 'restaurant',
                        'impression_galleries' => $impressionGalleries,
                        'quote_hero_image' => 'dining/detail/shared/quote-hero.webp',
                        'quote_oval_image' => 'dining/detail/shared/quote-oval.webp',
                        'book_url' => $whatsapp,
                    ]
                );
            }

            $this->setTranslations($restaurant, [
                'eyebrow' => $this->i18n($enVenue['eyebrow'] ?? '', $ruVenue['eyebrow'] ?? '', $zhVenue['eyebrow'] ?? ''),
                'subtitle' => $this->i18n($enVenue['subtitle'] ?? '', $ruVenue['subtitle'] ?? '', $zhVenue['subtitle'] ?? ''),
                'title_normal' => $this->i18n($enVenue['title_normal'] ?? '', $ruVenue['title_normal'] ?? '', $zhVenue['title_normal'] ?? ''),
                'title_italic' => $this->i18n($enVenue['title_italic'] ?? '', $ruVenue['title_italic'] ?? '', $zhVenue['title_italic'] ?? ''),
                'meta_title' => $this->i18n($enDetail['meta_title'] ?? '', $ruDetail['meta_title'] ?? '', $zhDetail['meta_title'] ?? ''),
                'hero_eyebrow' => $this->i18n($enDetail['hero']['eyebrow'] ?? '', $ruDetail['hero']['eyebrow'] ?? '', $zhDetail['hero']['eyebrow'] ?? ''),
                'hero_title_normal' => $this->i18n($enDetail['hero']['title_normal'] ?? '', $ruDetail['hero']['title_normal'] ?? '', $zhDetail['hero']['title_normal'] ?? ''),
                'hero_title_italic' => $this->i18n($enDetail['hero']['title_italic'] ?? '', $ruDetail['hero']['title_italic'] ?? '', $zhDetail['hero']['title_italic'] ?? ''),
                'gallery_eyebrow' => $this->i18n($enDetail['gallery']['eyebrow'] ?? '', $ruDetail['gallery']['eyebrow'] ?? '', $zhDetail['gallery']['eyebrow'] ?? ''),
                'gallery_title_normal' => $this->i18n($enDetail['gallery']['title_normal'] ?? '', $ruDetail['gallery']['title_normal'] ?? '', $zhDetail['gallery']['title_normal'] ?? ''),
                'gallery_title_italic' => $this->i18n($enDetail['gallery']['title_italic'] ?? '', $ruDetail['gallery']['title_italic'] ?? '', $zhDetail['gallery']['title_italic'] ?? ''),
                'gallery_body' => $this->i18n($enDetail['gallery']['body'] ?? '', $ruDetail['gallery']['body'] ?? '', $zhDetail['gallery']['body'] ?? ''),
                'gallery_body_bottom' => $this->i18n($enDetail['gallery']['body_bottom'] ?? '', $ruDetail['gallery']['body_bottom'] ?? '', $zhDetail['gallery']['body_bottom'] ?? ''),
                'menu_eyebrow' => $this->i18n(
                    $this->en['restaurant']['menu_eyebrow'] ?? '',
                    $this->ru['restaurant']['menu_eyebrow'] ?? '',
                    $this->zh['restaurant']['menu_eyebrow'] ?? '',
                ),
                'menu_title_normal' => $this->i18n(
                    $this->en['restaurant']['menu_title_normal'] ?? '',
                    $this->ru['restaurant']['menu_title_normal'] ?? '',
                    $this->zh['restaurant']['menu_title_normal'] ?? '',
                ),
                'menu_title_italic' => $this->i18n(
                    $this->en['restaurant']['menu_title_italic'] ?? '',
                    $this->ru['restaurant']['menu_title_italic'] ?? '',
                    $this->zh['restaurant']['menu_title_italic'] ?? '',
                ),
                'impression_title_normal' => $this->i18n(
                    $enImpression['title_normal'] ?? '',
                    $ruImpression['title_normal'] ?? '',
                    $zhImpression['title_normal'] ?? '',
                ),
                'impression_title_caps' => $this->i18n(
                    $enImpression['title_caps'] ?? '',
                    $ruImpression['title_caps'] ?? '',
                    $zhImpression['title_caps'] ?? '',
                ),
                'impression_cta' => $this->i18n(
                    $this->en['restaurant']['book_table'] ?? 'book a table',
                    $this->ru['restaurant']['book_table'] ?? 'забронировать стол',
                    $this->zh['restaurant']['book_table'] ?? '预订餐桌',
                ),
                'quote_line1' => $this->i18n($enDetail['quote']['line1'] ?? '', $ruDetail['quote']['line1'] ?? '', $zhDetail['quote']['line1'] ?? ''),
                'quote_line2' => $this->i18n($enDetail['quote']['line2'] ?? '', $ruDetail['quote']['line2'] ?? '', $zhDetail['quote']['line2'] ?? ''),
                'quote_note_line1' => $this->i18n($enDetail['quote']['note_line1'] ?? '', $ruDetail['quote']['note_line1'] ?? '', $zhDetail['quote']['note_line1'] ?? ''),
                'quote_note_line2' => $this->i18n($enDetail['quote']['note_line2'] ?? '', $ruDetail['quote']['note_line2'] ?? '', $zhDetail['quote']['note_line2'] ?? ''),
            ]);
        }
    }

    private function seedMenu(): void
    {
        $enCategories = $this->en['restaurant']['menu_categories'];
        $ruCategories = collect($this->ru['restaurant']['menu_categories'])->keyBy('key');
        $zhCategories = collect($this->zh['restaurant']['menu_categories'])->keyBy('key');
        $enItems = $this->en['restaurant']['menu_items'];
        $ruItems = $this->ru['restaurant']['menu_items'];
        $zhItems = $this->zh['restaurant']['menu_items'];

        $restaurants = Restaurant::query()->orderBy('id')->get();
        if ($restaurants->isEmpty()) {
            return;
        }

        foreach ($restaurants as $restaurant) {
            foreach ($enCategories as $index => $enCategory) {
                $key = $enCategory['key'];
                $ruCategory = $ruCategories->get($key, $enCategory);
                $zhCategory = $zhCategories->get($key, $enCategory);

                if ($this->zhOnly) {
                    $category = MenuCategory::query()
                        ->where('restaurant_id', $restaurant->id)
                        ->where('key', $key)
                        ->first();
                    if (! $category) {
                        continue;
                    }
                } else {
                    $category = MenuCategory::query()->updateOrCreate(
                        [
                            'restaurant_id' => $restaurant->id,
                            'key' => $key,
                        ],
                        ['sort_order' => $index + 1]
                    );
                }

                $this->setTranslations($category, [
                    'label' => $this->i18n($enCategory['label'], $ruCategory['label'], $zhCategory['label']),
                ]);

                $enCategoryItems = $enItems[$key] ?? [];
                $ruCategoryItems = $ruItems[$key] ?? [];
                $zhCategoryItems = $zhItems[$key] ?? [];

                if ($this->zhOnly) {
                    $existingItems = $category->items()->orderBy('sort_order')->get();
                    foreach ($enCategoryItems as $itemIndex => $enItem) {
                        $menuItem = $existingItems[$itemIndex] ?? null;
                        if (! $menuItem) {
                            continue;
                        }
                        $ruItem = $ruCategoryItems[$itemIndex] ?? $enItem;
                        $zhItem = $zhCategoryItems[$itemIndex] ?? $enItem;

                        $this->setTranslations($menuItem, [
                            'name' => $this->i18n($enItem['name'], $ruItem['name'], $zhItem['name']),
                            'description' => $this->i18n($enItem['description'], $ruItem['description'], $zhItem['description']),
                            'price' => $this->i18n($enItem['price'], $ruItem['price'], $zhItem['price']),
                        ]);
                    }

                    continue;
                }

                $category->items()->delete();

                foreach ($enCategoryItems as $itemIndex => $enItem) {
                    $ruItem = $ruCategoryItems[$itemIndex] ?? $enItem;
                    $zhItem = $zhCategoryItems[$itemIndex] ?? $enItem;

                    $menuItem = MenuItem::query()->create([
                        'menu_category_id' => $category->id,
                        'sort_order' => $itemIndex + 1,
                        'image' => 'dining/detail/shared/menu-item.webp',
                    ]);

                    $this->setTranslations($menuItem, [
                        'name' => $this->i18n($enItem['name'], $ruItem['name'], $zhItem['name']),
                        'description' => $this->i18n($enItem['description'], $ruItem['description'], $zhItem['description']),
                        'price' => $this->i18n($enItem['price'], $ruItem['price'], $zhItem['price']),
                    ]);
                }
            }
        }
    }

    private function seedActivities(): void
    {
        $enActivities = $this->en['relax']['activities'];
        $ruActivities = collect($this->ru['relax']['activities'])->keyBy('slug');
        $zhActivities = collect($this->zh['relax']['activities'])->keyBy('slug');
        $whatsapp = $this->en['shop']['social_whatsapp_url'];
        $enImpression = $this->en['activity']['impression'] ?? [];
        $ruImpression = $this->ru['activity']['impression'] ?? [];
        $zhImpression = $this->zh['activity']['impression'] ?? [];
        $enTabs = is_array($enImpression['tabs'] ?? null) ? $enImpression['tabs'] : [];
        $ruTabs = is_array($ruImpression['tabs'] ?? null) ? $ruImpression['tabs'] : [];
        $zhTabs = is_array($zhImpression['tabs'] ?? null) ? $zhImpression['tabs'] : [];
        $impressionImages = [
            'dining/detail/shared/impression/slide-01.webp',
            'dining/detail/shared/impression/slide-02.webp',
            'dining/detail/shared/impression/slide-03.webp',
            'dining/detail/shared/impression/slide-04.webp',
        ];
        $impressionGalleries = $this->buildImpressionGalleries($enTabs, $ruTabs, $zhTabs, $impressionImages);

        foreach ($enActivities as $index => $enActivity) {
            $slug = $enActivity['slug'];
            $ruActivity = $ruActivities->get($slug, $enActivity);
            $zhActivity = $zhActivities->get($slug, $enActivity);
            $enDetail = $this->en['activity'][$slug] ?? [];
            $ruDetail = $this->ru['activity'][$slug] ?? [];
            $zhDetail = $this->zh['activity'][$slug] ?? [];
            $assetBase = 'relax/detail/'.$slug;

            if ($this->zhOnly) {
                $activity = Activity::query()->where('slug', $slug)->first();
                if (! $activity) {
                    continue;
                }
                $activity->impression_galleries = $this->mergeImpressionGalleryZh(
                    $activity->impression_galleries ?? $impressionGalleries,
                    $zhTabs,
                );
                $activity->save();
            } else {
                $activity = Activity::query()->updateOrCreate(
                    ['slug' => $slug],
                    [
                        'sort_order' => $index + 1,
                        'is_published' => true,
                        'listing_image' => 'relax/'.$enActivity['image'],
                        'hero_image' => $assetBase.'/hero.webp',
                        'oval_image' => $assetBase.'/oval.webp',
                        'gallery_images' => [
                            ['path' => $assetBase.'/gallery-01.webp', 'date' => '06.05.2026'],
                            ['path' => $assetBase.'/gallery-02.webp', 'date' => '06.05.2026'],
                            ['path' => $assetBase.'/gallery-03.webp', 'date' => '06.05.2026'],
                        ],
                        'pricing_cta_url' => $whatsapp,
                        'impression_cta_mode' => 'activity',
                        'impression_galleries' => $impressionGalleries,
                        'quote_hero_image' => 'dining/detail/shared/quote-hero.webp',
                        'quote_oval_image' => 'dining/detail/shared/quote-oval.webp',
                    ]
                );
            }

            $this->setTranslations($activity, [
                'label_before' => $this->i18n($enActivity['label_before'] ?? '', $ruActivity['label_before'] ?? '', $zhActivity['label_before'] ?? ''),
                'label_italic' => $this->i18n(
                    $enActivity['label_italic'] ?? $enActivity['label_all_italic'] ?? '',
                    $ruActivity['label_italic'] ?? $ruActivity['label_all_italic'] ?? '',
                    $zhActivity['label_italic'] ?? $zhActivity['label_all_italic'] ?? '',
                ),
                'label_after' => $this->i18n($enActivity['label_after'] ?? '', $ruActivity['label_after'] ?? '', $zhActivity['label_after'] ?? ''),
                'name' => $this->i18n($enActivity['name'], $ruActivity['name'], $zhActivity['name']),
                'meta_title' => $this->i18n($enDetail['meta_title'] ?? '', $ruDetail['meta_title'] ?? '', $zhDetail['meta_title'] ?? ''),
                'hero_eyebrow' => $this->i18n($enDetail['hero']['eyebrow'] ?? '', $ruDetail['hero']['eyebrow'] ?? '', $zhDetail['hero']['eyebrow'] ?? ''),
                'hero_title_normal' => $this->i18n($enDetail['hero']['title_normal'] ?? '', $ruDetail['hero']['title_normal'] ?? '', $zhDetail['hero']['title_normal'] ?? ''),
                'hero_title_italic' => $this->i18n($enDetail['hero']['title_italic'] ?? '', $ruDetail['hero']['title_italic'] ?? '', $zhDetail['hero']['title_italic'] ?? ''),
                'gallery_eyebrow' => $this->i18n($enDetail['gallery']['eyebrow'] ?? '', $ruDetail['gallery']['eyebrow'] ?? '', $zhDetail['gallery']['eyebrow'] ?? ''),
                'gallery_title_normal' => $this->i18n($enDetail['gallery']['title_normal'] ?? '', $ruDetail['gallery']['title_normal'] ?? '', $zhDetail['gallery']['title_normal'] ?? ''),
                'gallery_title_italic' => $this->i18n($enDetail['gallery']['title_italic'] ?? '', $ruDetail['gallery']['title_italic'] ?? '', $zhDetail['gallery']['title_italic'] ?? ''),
                'gallery_body' => $this->i18n($enDetail['gallery']['body'] ?? '', $ruDetail['gallery']['body'] ?? '', $zhDetail['gallery']['body'] ?? ''),
                'gallery_body_bottom' => $this->i18n($enDetail['gallery']['body_bottom'] ?? '', $ruDetail['gallery']['body_bottom'] ?? '', $zhDetail['gallery']['body_bottom'] ?? ''),
                'quote_line1' => $this->i18n($enDetail['quote']['line1'] ?? '', $ruDetail['quote']['line1'] ?? '', $zhDetail['quote']['line1'] ?? ''),
                'quote_line2' => $this->i18n($enDetail['quote']['line2'] ?? '', $ruDetail['quote']['line2'] ?? '', $zhDetail['quote']['line2'] ?? ''),
                'quote_note' => $this->i18n(
                    implode("\n", array_filter([$enDetail['quote']['note_line1'] ?? '', $enDetail['quote']['note_line2'] ?? ''])),
                    implode("\n", array_filter([$ruDetail['quote']['note_line1'] ?? '', $ruDetail['quote']['note_line2'] ?? ''])),
                    implode("\n", array_filter([$zhDetail['quote']['note_line1'] ?? '', $zhDetail['quote']['note_line2'] ?? ''])),
                ),
                'pricing_eyebrow' => $this->i18n($enDetail['pricing']['eyebrow'] ?? '', $ruDetail['pricing']['eyebrow'] ?? '', $zhDetail['pricing']['eyebrow'] ?? ''),
                'pricing_title_normal' => $this->i18n($enDetail['pricing']['title_normal'] ?? '', $ruDetail['pricing']['title_normal'] ?? '', $zhDetail['pricing']['title_normal'] ?? ''),
                'pricing_title_italic' => $this->i18n($enDetail['pricing']['title_italic'] ?? '', $ruDetail['pricing']['title_italic'] ?? '', $zhDetail['pricing']['title_italic'] ?? ''),
                'pricing_cta' => $this->i18n($enDetail['pricing']['cta'] ?? '', $ruDetail['pricing']['cta'] ?? '', $zhDetail['pricing']['cta'] ?? ''),
                'pricing_items' => $this->i18n($enDetail['pricing']['items'] ?? [], $ruDetail['pricing']['items'] ?? [], $zhDetail['pricing']['items'] ?? []),
                'impression_title_normal' => $this->i18n(
                    $enImpression['title_normal'] ?? '',
                    $ruImpression['title_normal'] ?? '',
                    $zhImpression['title_normal'] ?? '',
                ),
                'impression_title_caps' => $this->i18n(
                    $enImpression['title_caps'] ?? '',
                    $ruImpression['title_caps'] ?? '',
                    $zhImpression['title_caps'] ?? '',
                ),
                'impression_cta' => $this->i18n(
                    $this->en['activity']['make_reservation'] ?? 'make a reservation',
                    $this->ru['activity']['make_reservation'] ?? 'забронировать',
                    $this->zh['activity']['make_reservation'] ?? '预约',
                ),
            ]);
        }
    }

    private function seedExcursions(): void
    {
        $enPlaces = $this->en['discover']['places'];
        $ruPlaces = collect($this->ru['discover']['places'])->keyBy('slug');
        $zhPlaces = collect($this->zh['discover']['places'])->keyBy('slug');
        $whatsapp = $this->en['shop']['social_whatsapp_url'];
        $enImpression = $this->en['excursion']['impression'] ?? [];
        $ruImpression = $this->ru['excursion']['impression'] ?? [];
        $zhImpression = $this->zh['excursion']['impression'] ?? [];
        $enTabs = is_array($enImpression['tabs'] ?? null) ? $enImpression['tabs'] : [];
        $ruTabs = is_array($ruImpression['tabs'] ?? null) ? $ruImpression['tabs'] : [];
        $zhTabs = is_array($zhImpression['tabs'] ?? null) ? $zhImpression['tabs'] : [];
        $impressionImages = [
            'discover/detail/shared/impression/slide-01.webp',
            'discover/detail/shared/impression/slide-02.webp',
            'discover/detail/shared/impression/slide-03.webp',
            'discover/detail/shared/impression/slide-04.webp',
        ];
        $impressionGalleries = $this->buildImpressionGalleries($enTabs, $ruTabs, $zhTabs, $impressionImages);

        foreach ($enPlaces as $index => $enPlace) {
            $slug = $enPlace['slug'];
            $ruPlace = $ruPlaces->get($slug, $enPlace);
            $zhPlace = $zhPlaces->get($slug, $enPlace);
            $enDetail = $this->en['excursion'][$slug] ?? [];
            $ruDetail = $this->ru['excursion'][$slug] ?? [];
            $zhDetail = $this->zh['excursion'][$slug] ?? [];
            $assetBase = 'discover/detail/'.$slug;
            $enDates = $enDetail['gallery']['polaroid_dates'] ?? ['06.08.2023', '06.01.2024', '07.03.2023'];

            if ($this->zhOnly) {
                $excursion = Excursion::query()->where('slug', $slug)->first();
                if (! $excursion) {
                    continue;
                }
                $excursion->impression_galleries = $this->mergeImpressionGalleryZh(
                    $excursion->impression_galleries ?? $impressionGalleries,
                    $zhTabs,
                );
                $excursion->save();
            } else {
                $excursion = Excursion::query()->updateOrCreate(
                    ['slug' => $slug],
                    [
                        'sort_order' => $index + 1,
                        'is_published' => true,
                        'listing_image' => 'discover/'.$enPlace['image'],
                        'oval_image' => $assetBase.'/oval.webp',
                        'wellness_hero' => $assetBase.'/wellness-hero.webp',
                        'gallery_images' => [
                            ['path' => $assetBase.'/gallery-01.webp', 'date' => $enDates[0] ?? '06.08.2023'],
                            ['path' => $assetBase.'/gallery-02.webp', 'date' => $enDates[1] ?? '06.01.2024'],
                            ['path' => $assetBase.'/gallery-03.webp', 'date' => $enDates[2] ?? '07.03.2023'],
                        ],
                        'package_images' => [$assetBase.'/package-01.webp', $assetBase.'/package-02.webp'],
                        'book_url' => $whatsapp,
                        'impression_cta_mode' => 'excursion',
                        'impression_galleries' => $impressionGalleries,
                    ]
                );
            }

            $this->setTranslations($excursion, [
                'title' => $this->i18n($enPlace['title'], $ruPlace['title'], $zhPlace['title']),
                'region' => $this->i18n($enPlace['region'], $ruPlace['region'], $zhPlace['region']),
                'meta_title' => $this->i18n($enDetail['meta_title'] ?? '', $ruDetail['meta_title'] ?? '', $zhDetail['meta_title'] ?? ''),
                'intro_title' => $this->i18n($enDetail['intro']['title'] ?? '', $ruDetail['intro']['title'] ?? '', $zhDetail['intro']['title'] ?? ''),
                'intro_body' => $this->i18n($enDetail['intro']['body'] ?? '', $ruDetail['intro']['body'] ?? '', $zhDetail['intro']['body'] ?? ''),
                'gallery_eyebrow' => $this->i18n($enDetail['gallery']['eyebrow'] ?? '', $ruDetail['gallery']['eyebrow'] ?? '', $zhDetail['gallery']['eyebrow'] ?? ''),
                'gallery_title_normal' => $this->i18n($enDetail['gallery']['title_normal'] ?? '', $ruDetail['gallery']['title_normal'] ?? '', $zhDetail['gallery']['title_normal'] ?? ''),
                'gallery_title_italic' => $this->i18n($enDetail['gallery']['title_italic'] ?? '', $ruDetail['gallery']['title_italic'] ?? '', $zhDetail['gallery']['title_italic'] ?? ''),
                'gallery_body' => $this->i18n($enDetail['gallery']['body'] ?? '', $ruDetail['gallery']['body'] ?? '', $zhDetail['gallery']['body'] ?? ''),
                'gallery_body_bottom' => $this->i18n($enDetail['gallery']['body_bottom'] ?? '', $ruDetail['gallery']['body_bottom'] ?? '', $zhDetail['gallery']['body_bottom'] ?? ''),
                'package_eyebrow' => $this->i18n($enDetail['package']['eyebrow'] ?? '', $ruDetail['package']['eyebrow'] ?? '', $zhDetail['package']['eyebrow'] ?? ''),
                'package_title_normal' => $this->i18n($enDetail['package']['title_normal'] ?? '', $ruDetail['package']['title_normal'] ?? '', $zhDetail['package']['title_normal'] ?? ''),
                'package_title_italic' => $this->i18n($enDetail['package']['title_italic'] ?? '', $ruDetail['package']['title_italic'] ?? '', $zhDetail['package']['title_italic'] ?? ''),
                'package_items' => $this->i18n($enDetail['package']['items'] ?? [], $ruDetail['package']['items'] ?? [], $zhDetail['package']['items'] ?? []),
                'package_cost' => $this->i18n($enDetail['package']['cost'] ?? '', $ruDetail['package']['cost'] ?? '', $zhDetail['package']['cost'] ?? ''),
                'impression_title_normal' => $this->i18n(
                    $enImpression['title_normal'] ?? '',
                    $ruImpression['title_normal'] ?? '',
                    $zhImpression['title_normal'] ?? '',
                ),
                'impression_title_caps' => $this->i18n(
                    $enImpression['title_caps'] ?? '',
                    $ruImpression['title_caps'] ?? '',
                    $zhImpression['title_caps'] ?? '',
                ),
                'impression_cta' => $this->i18n(
                    $this->en['excursion']['book'] ?? 'book',
                    $this->ru['excursion']['book'] ?? 'забронировать',
                    $this->zh['excursion']['book'] ?? '预订',
                ),
            ]);
        }
    }

    private function seedShopProducts(): void
    {
        $enItems = $this->en['shop']['items'];
        $ruItems = $this->ru['shop']['items'];
        $zhItems = $this->zh['shop']['items'];
        $price = $this->en['shop']['cta_price'];
        $whatsapp = $this->en['shop']['social_whatsapp_url'] ?? null;

        $index = 0;

        foreach ($enItems as $slug => $enItem) {
            $ruItem = $ruItems[$slug] ?? $enItem;
            $zhItem = $zhItems[$slug] ?? $enItem;

            if ($this->zhOnly) {
                $product = ShopProduct::query()->where('slug', $slug)->first();
                if (! $product) {
                    $index++;

                    continue;
                }
            } else {
                $product = ShopProduct::query()->updateOrCreate(
                    ['slug' => $slug],
                    [
                        'type' => $enItem['type'] ?? 'tee',
                        'sort_order' => $index + 1,
                        'is_published' => true,
                        'image' => 'shop/'.$enItem['image'],
                        'thumbs' => array_map(fn ($thumb) => 'shop/'.$thumb, $enItem['thumbs'] ?? []),
                        'colors' => array_map(
                            fn ($color) => ['kind' => 'image', 'image' => 'shop/'.$color, 'hex' => null],
                            $enItem['colors'] ?? [],
                        ),
                        'sizes' => $enItem['sizes'] ?? [],
                        'price' => $price,
                        'cta_url' => $whatsapp,
                    ]
                );
            }

            $this->setTranslations($product, [
                'title' => $this->i18n($enItem['title'], $ruItem['title'], $zhItem['title']),
                'subtitle' => $this->i18n($enItem['subtitle'], $ruItem['subtitle'], $zhItem['subtitle']),
            ]);

            $index++;
        }
    }

    private function seedHomeSections(): void
    {
        $en = $this->en;
        $ru = $this->ru;
        $zh = $this->zh;

        $this->putHomeSection('hero', [
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
            'zh' => array_merge($zh['hero'], [
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
        $this->putHomeSection('polaroids', [
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
            'zh' => array_merge($zh['polaroids'], [
                'photos' => $polaroidPhotos,
                'cta' => $zh['hero']['cta'],
                'cta_url' => 'stay',
            ]),
        ]);

        $this->putHomeSection('location', [
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
            'zh' => [
                'heading' => $zh['location']['heading'],
                'see_on_map' => $zh['location']['see_on_map'],
                'see_on_map_upper' => $zh['location']['see_on_map_upper'],
                'more_info' => $zh['location']['more_info'],
                'cards' => $zh['location']['cards'],
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
        $zhInteriorTabs = [];
        foreach ($en['interior']['tabs'] as $i => $label) {
            $enInteriorTabs[] = [
                'label' => $label,
                'images' => $defaultInteriorImages,
            ];
            $ruInteriorTabs[] = [
                'label' => $ru['interior']['tabs'][$i] ?? $label,
                'images' => $defaultInteriorImages,
            ];
            $zhInteriorTabs[] = [
                'label' => $zh['interior']['tabs'][$i] ?? $label,
                'images' => $defaultInteriorImages,
            ];
        }

        $this->putHomeSection('interior', [
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
            'zh' => [
                'title_normal' => $zh['interior']['title_normal'],
                'title_caps' => $zh['interior']['title_caps'],
                'tabs' => $zhInteriorTabs,
            ],
        ]);

        $blogSlugs = collect($en['blog']['posts'] ?? [])
            ->pluck('slug')
            ->filter()
            ->take(4)
            ->values()
            ->all();

        $this->putHomeSection('blog', [
            'en' => ['posts' => $blogSlugs],
            'ru' => ['posts' => $blogSlugs],
            'zh' => ['posts' => $blogSlugs],
        ]);

        $this->putHomeSection('shop_teaser', [
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
            'zh' => [
                'eyebrow' => $zh['shop']['eyebrow'],
                'title_normal' => $zh['shop']['title_normal'],
                'title_italic' => $zh['shop']['title_italic'],
                'cta' => $zh['shop']['cta'],
                'background_image' => 'shop/bg.jpg',
            ],
        ]);

        $villasBySlug = Villa::query()->get()->keyBy('slug');
        $enSlides = [];
        $ruSlides = [];
        $zhSlides = [];

        foreach ($en['villas']['slides'] as $i => $enSlide) {
            $slug = $enSlide['slug'] ?? null;
            $ruSlide = $ru['villas']['slides'][$i] ?? $enSlide;
            $zhSlide = $zh['villas']['slides'][$i] ?? $enSlide;
            $villa = $slug ? $villasBySlug->get($slug) : null;
            $photo = $villa?->slide_photo ?: ('villas/'.($enSlide['photo'] ?? sprintf('slide-%02d', $i + 1)).'.webp');
            $oval = $villa?->slide_oval ?: ('villas/'.($enSlide['oval'] ?? sprintf('oval-%02d', $i + 1)).'.webp');

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

            $zhSlides[] = array_merge($shared, [
                'title_normal' => $zhSlide['titleNormal'] ?? '',
                'title_italic' => $zhSlide['titleItalic'] ?? '',
                'title_mobile_normal' => $zhSlide['titleMobileNormal'] ?? ($zhSlide['titleNormal'] ?? ''),
                'title_mobile_italic' => $zhSlide['titleMobileItalic'] ?? ($zhSlide['titleItalic'] ?? ''),
                'subtitle' => $zhSlide['subtitle'] ?? ($zh['villas']['subtitle'] ?? ''),
                'subtitle_line1' => $zhSlide['subtitleLine1'] ?? ($zh['villas']['subtitle_line1'] ?? ''),
                'subtitle_line2' => $zhSlide['subtitleLine2'] ?? ($zh['villas']['subtitle_line2'] ?? ''),
                'titleNormal' => $zhSlide['titleNormal'] ?? '',
                'titleItalic' => $zhSlide['titleItalic'] ?? '',
                'subtitleLine1' => $zhSlide['subtitleLine1'] ?? ($zh['villas']['subtitle_line1'] ?? ''),
                'subtitleLine2' => $zhSlide['subtitleLine2'] ?? ($zh['villas']['subtitle_line2'] ?? ''),
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
        $zhVillas = Arr::only($zh['villas'], $villasIntroKeys);
        $enVillas['slides'] = $enSlides;
        $ruVillas['slides'] = $ruSlides;
        $zhVillas['slides'] = $zhSlides;

        $this->putHomeSection('villas_intro', [
            'en' => $enVillas,
            'ru' => $ruVillas,
            'zh' => $zhVillas,
        ]);
    }

    private function seedPageSections(): void
    {
        $en = $this->en;
        $ru = $this->ru;
        $zh = $this->zh;

        $this->putPageSection('stay', 'intro', [
            'en' => Arr::only($en['stay'], ['title_line1', 'title_line2', 'title_italic', 'eyebrow']),
            'ru' => Arr::only($ru['stay'], ['title_line1', 'title_line2', 'title_italic', 'eyebrow']),
            'zh' => Arr::only($zh['stay'], ['title_line1', 'title_line2', 'title_italic', 'eyebrow']),
        ]);

        $this->putPageSection('stay', 'media', [
            'en' => ['hero_image' => 'stay/wellness-hero.webp', 'oval_image' => 'stay/wellness-oval.webp'],
            'ru' => ['hero_image' => 'stay/wellness-hero.webp', 'oval_image' => 'stay/wellness-oval.webp'],
            'zh' => ['hero_image' => 'stay/wellness-hero.webp', 'oval_image' => 'stay/wellness-oval.webp'],
        ]);

        $this->putPageSection('stay', 'quote', [
            'en' => Arr::only($en['stay'], ['quote', 'quote_break', 'note_line1', 'note_line2']),
            'ru' => Arr::only($ru['stay'], ['quote', 'quote_break', 'note_line1', 'note_line2']),
            'zh' => Arr::only($zh['stay'], ['quote', 'quote_break', 'note_line1', 'note_line2']),
        ]);

        $this->putPageSection('dining', 'intro', [
            'en' => Arr::only($en['dining'], ['title_line1', 'title_line2', 'title_italic', 'eyebrow']),
            'ru' => Arr::only($ru['dining'], ['title_line1', 'title_line2', 'title_italic', 'eyebrow']),
            'zh' => Arr::only($zh['dining'], ['title_line1', 'title_line2', 'title_italic', 'eyebrow']),
        ]);

        $this->putPageSection('dining', 'media', [
            'en' => ['hero_image' => 'dining/wellness-hero.webp', 'oval_image' => 'dining/wellness-oval.webp'],
            'ru' => ['hero_image' => 'dining/wellness-hero.webp', 'oval_image' => 'dining/wellness-oval.webp'],
            'zh' => ['hero_image' => 'dining/wellness-hero.webp', 'oval_image' => 'dining/wellness-oval.webp'],
        ]);

        $this->putPageSection('dining', 'quote', [
            'en' => Arr::only($en['dining'], ['quote_line1', 'quote_line2', 'note_line1', 'note_line2']),
            'ru' => Arr::only($ru['dining'], ['quote_line1', 'quote_line2', 'note_line1', 'note_line2']),
            'zh' => Arr::only($zh['dining'], ['quote_line1', 'quote_line2', 'note_line1', 'note_line2']),
        ]);

        $this->putPageSection('relax', 'intro', [
            'en' => Arr::only($en['relax'], ['title_line1', 'title_line2', 'title_italic', 'eyebrow_line1', 'eyebrow_line2']),
            'ru' => Arr::only($ru['relax'], ['title_line1', 'title_line2', 'title_italic', 'eyebrow_line1', 'eyebrow_line2']),
            'zh' => Arr::only($zh['relax'], ['title_line1', 'title_line2', 'title_italic', 'eyebrow_line1', 'eyebrow_line2']),
        ]);

        $this->putPageSection('relax', 'media', [
            'en' => [
                'hero_image' => 'relax/wellness-hero.webp',
                'hero_image_mob' => 'relax/wellness-hero-mob.webp',
                'hero_image_tab' => 'relax/wellness-hero-tab.webp',
                'oval_image' => 'relax/wellness-oval.webp',
            ],
            'ru' => [
                'hero_image' => 'relax/wellness-hero.webp',
                'hero_image_mob' => 'relax/wellness-hero-mob.webp',
                'hero_image_tab' => 'relax/wellness-hero-tab.webp',
                'oval_image' => 'relax/wellness-oval.webp',
            ],
            'zh' => [
                'hero_image' => 'relax/wellness-hero.webp',
                'hero_image_mob' => 'relax/wellness-hero-mob.webp',
                'hero_image_tab' => 'relax/wellness-hero-tab.webp',
                'oval_image' => 'relax/wellness-oval.webp',
            ],
        ]);

        // Relax quote texts mirrored from dining (legacy blade), own media above.
        $this->putPageSection('relax', 'quote', [
            'en' => Arr::only($en['dining'], ['quote_line1', 'quote_line2', 'note_line1', 'note_line2']),
            'ru' => Arr::only($ru['dining'], ['quote_line1', 'quote_line2', 'note_line1', 'note_line2']),
            'zh' => Arr::only($zh['dining'], ['quote_line1', 'quote_line2', 'note_line1', 'note_line2']),
        ]);

        $this->putPageSection('discover', 'intro', [
            'en' => Arr::only($en['discover'], ['title_normal', 'title_italic', 'eyebrow']),
            'ru' => Arr::only($ru['discover'], ['title_normal', 'title_italic', 'eyebrow']),
            'zh' => Arr::only($zh['discover'], ['title_normal', 'title_italic', 'eyebrow']),
        ]);
    }

    private function setTranslations(Model $model, array $fields): void
    {
        foreach ($fields as $field => $locales) {
            if ($this->zhOnly) {
                if (array_key_exists('zh', $locales)) {
                    $model->setTranslation($field, 'zh', $locales['zh']);
                }
            } else {
                $model->setTranslations($field, $locales);
            }
        }

        $model->save();
    }
}
