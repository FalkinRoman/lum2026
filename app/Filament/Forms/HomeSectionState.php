<?php

namespace App\Filament\Forms;

use App\Support\Locales;

/**
 * Flatten / rebuild HomeSection payload for typed Filament forms.
 */
class HomeSectionState
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function fill(string $key, array $data): array
    {
        $payload = is_array($data['payload'] ?? null) ? $data['payload'] : [];

        foreach (Locales::codes() as $locale) {
            $data[$locale] = is_array($payload[$locale] ?? null) ? $payload[$locale] : [];
        }

        return match ($key) {
            'hero' => self::fillHero($data, $data['en']),
            'polaroids' => self::fillPolaroids($data),
            'villas_intro' => self::fillVillas($data),
            'location' => self::fillLocation($data),
            'interior' => self::fillInterior($data),
            'blog' => self::fillBlog($data, $data['en']),
            'shop_teaser' => self::fillShop($data, $data['en']),
            default => $data,
        };
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function save(string $key, array $data): array
    {
        $payload = match ($key) {
            'hero' => self::saveHero($data),
            'polaroids' => self::savePolaroids($data),
            'villas_intro' => self::saveVillas($data),
            'location' => self::saveLocation($data),
            'interior' => self::saveInterior($data),
            'blog' => self::saveBlog($data),
            'shop_teaser' => self::saveShop($data),
            default => self::localePayloadFromData($data),
        };

        $data['payload'] = $payload;

        foreach (Locales::codes() as $locale) {
            unset($data[$locale]);
        }

        unset(
            $data['video'],
            $data['video_poster'],
            $data['video_position'],
            $data['photos'],
            $data['slides'],
            $data['cards'],
            $data['tabs'],
            $data['post_1'],
            $data['post_2'],
            $data['post_3'],
            $data['post_4'],
            $data['posts'],
            $data['background_image'],
            $data['cta_url'],
        );

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, array<string, mixed>>
     */
    private static function localePayloadFromData(array $data): array
    {
        $payload = [];

        foreach (Locales::codes() as $locale) {
            $payload[$locale] = is_array($data[$locale] ?? null) ? $data[$locale] : [];
        }

        return $payload;
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $en
     * @return array<string, mixed>
     */
    private static function fillHero(array $data, array $en): array
    {
        $data['video'] = self::nullablePath($en['video'] ?? null);
        $data['video_poster'] = self::nullablePath($en['video_poster'] ?? null);
        $data['video_position'] = $en['video_position'] ?? 'center';
        $data['cta_url'] = is_string($en['cta_url'] ?? null) && $en['cta_url'] !== ''
            ? $en['cta_url']
            : 'stay';

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, array<string, mixed>>
     */
    private static function saveHero(array $data): array
    {
        $ctaUrl = filled($data['cta_url'] ?? null) ? trim((string) $data['cta_url']) : 'stay';
        $shared = [
            // null = cleared in admin; front shows poster or dark stub (no seed fallback)
            'video' => self::nullablePath($data['video'] ?? null),
            'video_poster' => self::nullablePath($data['video_poster'] ?? null),
            'video_position' => $data['video_position'] ?? 'center',
            'cta_url' => $ctaUrl,
        ];

        $payload = [];

        foreach (Locales::codes() as $locale) {
            $localeData = is_array($data[$locale] ?? null) ? $data[$locale] : [];
            $payload[$locale] = array_merge($localeData, $shared);
        }

        return $payload;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private static function fillPolaroids(array $data): array
    {
        $en = $data['en'];
        $photos = is_array($en['photos'] ?? null) ? $en['photos'] : [];
        $data['photos'] = [
            self::nullablePath($photos[0] ?? null),
            self::nullablePath($photos[1] ?? null),
            self::nullablePath($photos[2] ?? null),
        ];
        $data['cta_url'] = is_string($en['cta_url'] ?? null) && $en['cta_url'] !== ''
            ? $en['cta_url']
            : 'stay';

        foreach (Locales::codes() as $locale) {
            if (! filled($data[$locale]['cta'] ?? null)) {
                $data[$locale]['cta'] = __('lum.hero.cta', [], $locale);
            }
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, array<string, mixed>>
     */
    private static function savePolaroids(array $data): array
    {
        $locales = [];

        foreach (Locales::codes() as $locale) {
            $locales[$locale] = is_array($data[$locale] ?? null) ? $data[$locale] : [];
        }

        $photos = is_array($data['photos'] ?? null) ? array_values($data['photos']) : [];
        $photos = [
            self::nullablePath($photos[0] ?? null),
            self::nullablePath($photos[1] ?? null),
            self::nullablePath($photos[2] ?? null),
        ];
        $ctaUrl = filled($data['cta_url'] ?? null) ? trim((string) $data['cta_url']) : 'stay';

        // Keep motion ticker words if already present.
        foreach (['share', 'shine', 'impressions', 'relax'] as $word) {
            $found = null;

            foreach (Locales::codes() as $locale) {
                if (filled($locales[$locale][$word] ?? null)) {
                    $found = $locales[$locale][$word];
                    break;
                }
            }

            foreach (Locales::codes() as $locale) {
                $locales[$locale][$word] ??= $found;
            }
        }

        foreach (Locales::codes() as $locale) {
            if (! filled($locales[$locale]['cta'] ?? null)) {
                $locales[$locale]['cta'] = __('lum.hero.cta', [], $locale);
            }

            $locales[$locale]['photos'] = $photos;
            $locales[$locale]['cta_url'] = $ctaUrl;
        }

        return $locales;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private static function fillVillas(array $data): array
    {
        foreach (Locales::codes() as $locale) {
            $data[$locale] = self::hydrateVillasIntro($data[$locale]);
        }

        $localeSlides = [];

        foreach (Locales::codes() as $locale) {
            $localeSlides[$locale] = is_array($data[$locale]['slides'] ?? null) ? $data[$locale]['slides'] : [];
        }

        $count = max(array_merge(array_map('count', $localeSlides), [1]));
        $count = min($count, 4);
        $slides = [];

        for ($i = 0; $i < $count; $i++) {
            $slides[] = [
                'villa_id' => self::sharedSlideField($localeSlides, $i, 'villa_id'),
                'slug' => self::sharedSlideField($localeSlides, $i, 'slug'),
                'photo' => self::nullableVillaMedia(self::sharedSlideField($localeSlides, $i, 'photo')),
                'oval' => self::nullableVillaMedia(self::sharedSlideField($localeSlides, $i, 'oval')),
                'title_normal' => self::localeMapFromSlides($localeSlides, $i, 'title_normal', 'titleNormal'),
                'title_italic' => self::localeMapFromSlides($localeSlides, $i, 'title_italic', 'titleItalic'),
                'subtitle' => self::localeMapFromSlides($localeSlides, $i, 'subtitle'),
                'subtitle_line1' => self::localeMapFromSlides($localeSlides, $i, 'subtitle_line1', 'subtitleLine1'),
                'subtitle_line2' => self::localeMapFromSlides($localeSlides, $i, 'subtitle_line2', 'subtitleLine2'),
            ];
        }

        $data['slides'] = $slides;

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, array<string, mixed>>
     */
    private static function saveVillas(array $data): array
    {
        $formSlides = is_array($data['slides'] ?? null) ? $data['slides'] : [];
        $payload = [];

        foreach (Locales::codes() as $locale) {
            $localePayload = self::syncVillasIntroLegacy(is_array($data[$locale] ?? null) ? $data[$locale] : []);
            $localeSlides = [];

            foreach (array_slice(array_values($formSlides), 0, 4) as $slide) {
                if (! is_array($slide)) {
                    continue;
                }

                $slide = self::reconcileVillaSlide($slide);

                $shared = [
                    'villa_id' => $slide['villa_id'] ?? null,
                    'slug' => $slide['slug'] ?? null,
                    'photo' => self::nullableVillaMedia($slide['photo'] ?? null),
                    'oval' => self::nullableVillaMedia($slide['oval'] ?? null),
                ];

                $localeSlides[] = array_merge($shared, [
                    'title_normal' => data_get($slide, "title_normal.{$locale}", ''),
                    'title_italic' => data_get($slide, "title_italic.{$locale}", ''),
                    'subtitle' => data_get($slide, "subtitle.{$locale}", ''),
                    'subtitle_line1' => data_get($slide, "subtitle_line1.{$locale}", ''),
                    'subtitle_line2' => data_get($slide, "subtitle_line2.{$locale}", ''),
                    'titleNormal' => data_get($slide, "title_normal.{$locale}", ''),
                    'titleItalic' => data_get($slide, "title_italic.{$locale}", ''),
                    'subtitleLine1' => data_get($slide, "subtitle_line1.{$locale}", ''),
                    'subtitleLine2' => data_get($slide, "subtitle_line2.{$locale}", ''),
                ]);
            }

            $localePayload['slides'] = $localeSlides;
            $localePayload['view'] = $localePayload['view'] ?? 'VIEW';
            $payload[$locale] = $localePayload;
        }

        return $payload;
    }

    /**
     * @param  array<string, list<array<string, mixed>>>  $localeSlides
     * @return array<string, string>
     */
    private static function localeMapFromSlides(array $localeSlides, int $i, string $field, ?string $legacy = null): array
    {
        $map = [];

        foreach (Locales::codes() as $locale) {
            $slide = is_array($localeSlides[$locale][$i] ?? null) ? $localeSlides[$locale][$i] : [];
            $map[$locale] = $slide[$field] ?? ($legacy ? ($slide[$legacy] ?? '') : '');
        }

        return $map;
    }

    /**
     * First non-empty slide field across locales (en preferred).
     *
     * @param  array<string, list<array<string, mixed>>>  $localeSlides
     */
    private static function sharedSlideField(array $localeSlides, int $i, string $field): mixed
    {
        $order = array_merge(['en'], array_diff(Locales::codes(), ['en']));

        foreach ($order as $locale) {
            $slide = is_array($localeSlides[$locale][$i] ?? null) ? $localeSlides[$locale][$i] : [];
            $value = $slide[$field] ?? null;

            if (filled($value)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    private static function hydrateVillasIntro(array $payload): array
    {
        if (! filled($payload['intro_desk'] ?? null)) {
            $payload['intro_desk'] = self::joinIntroLines([
                $payload['intro_desk_1'] ?? null,
                $payload['intro_desk_2'] ?? null,
                $payload['intro_desk_3'] ?? null,
                $payload['intro_desk_4'] ?? null,
            ]);
        }

        $tablet = (string) ($payload['intro_tablet'] ?? '');
        if ($tablet === '' || (! str_contains($tablet, "\n") && filled($payload['intro_tablet_2'] ?? null))) {
            $joined = self::joinIntroLines([
                $payload['intro_tablet'] ?? null,
                $payload['intro_tablet_2'] ?? null,
                $payload['intro_tablet_3'] ?? null,
            ]);
            if ($joined !== '') {
                $payload['intro_tablet'] = $joined;
            }
        }

        if (! filled($payload['intro_mobile'] ?? null)) {
            $payload['intro_mobile'] = self::joinIntroLines([
                $payload['intro_mobile_1'] ?? null,
                (($payload['intro_mobile_2'] ?? null) !== null && ($payload['intro_mobile_2'] ?? '') !== '')
                    ? ':lifestyle '.ltrim((string) $payload['intro_mobile_2'])
                    : null,
                $payload['intro_mobile_3'] ?? null,
                $payload['intro_mobile_4'] ?? null,
                $payload['intro_mobile_5'] ?? null,
            ]);
        }

        return $payload;
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    private static function syncVillasIntroLegacy(array $payload): array
    {
        $desk = self::splitIntroLines($payload['intro_desk'] ?? '');
        $payload['intro_desk_1'] = $desk[0] ?? '';
        $payload['intro_desk_2'] = $desk[1] ?? '';
        $payload['intro_desk_3'] = $desk[2] ?? '';
        $payload['intro_desk_4'] = $desk[3] ?? '';

        $tab = self::splitIntroLines($payload['intro_tablet'] ?? '');
        $payload['intro_tablet_2'] = $tab[1] ?? '';
        $payload['intro_tablet_3'] = $tab[2] ?? '';

        $mob = self::splitIntroLines($payload['intro_mobile'] ?? '');
        $payload['intro_mobile_1'] = $mob[0] ?? '';
        $payload['intro_mobile_2'] = $mob[1] ?? '';
        $payload['intro_mobile_3'] = $mob[2] ?? '';
        $payload['intro_mobile_4'] = $mob[3] ?? '';
        $payload['intro_mobile_5'] = $mob[4] ?? '';

        return $payload;
    }

    /**
     * @param  list<mixed>  $lines
     */
    private static function joinIntroLines(array $lines): string
    {
        return implode("\n", array_values(array_filter(
            array_map(fn ($l) => is_string($l) ? trim($l) : '', $lines),
            fn (string $l) => $l !== '',
        )));
    }

    /**
     * @return list<string>
     */
    private static function splitIntroLines(mixed $text): array
    {
        $text = (string) $text;
        if (trim($text) === '') {
            return [];
        }

        return array_values(array_filter(array_map(
            'trim',
            preg_split('/\r\n|\r|\n/', $text) ?: [],
        ), fn (string $l) => $l !== ''));
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private static function fillLocation(array $data): array
    {
        $localeCards = [];

        foreach (Locales::codes() as $locale) {
            $localeCards[$locale] = is_array($data[$locale]['cards'] ?? null) ? $data[$locale]['cards'] : [];
        }

        $cards = [];

        for ($i = 0; $i < 3; $i++) {
            $metaLocale = self::firstNonEmptyCardMeta($localeCards, $i);
            $meta = is_array($localeCards[$metaLocale][$i] ?? null) ? $localeCards[$metaLocale][$i] : [];

            $titleMap = [];
            $listLinesMap = [];

            foreach (Locales::codes() as $locale) {
                $card = is_array($localeCards[$locale][$i] ?? null) ? $localeCards[$locale][$i] : [];
                $titleMap[$locale] = $card['title'] ?? '';
                $listLinesMap[$locale] = self::linesToText($card['listLines'] ?? []);
            }

            $cards[] = [
                '_meta' => $meta,
                'title' => $titleMap,
                'route' => self::sharedCardField($localeCards, $i, 'route'),
                'photo' => self::sharedCardField($localeCards, $i, 'photo'),
                'activeImg' => self::sharedCardField($localeCards, $i, 'activeImg'),
                'list_lines' => $listLinesMap,
            ];
        }

        $data['cards'] = $cards;

        return $data;
    }

    /**
     * @param  array<string, list<array<string, mixed>>>  $localeCards
     */
    private static function firstNonEmptyCardMeta(array $localeCards, int $i): string
    {
        $order = array_merge(['en'], array_diff(Locales::codes(), ['en']));

        foreach ($order as $locale) {
            if (is_array($localeCards[$locale][$i] ?? null)) {
                return $locale;
            }
        }

        return 'en';
    }

    /**
     * @param  array<string, list<array<string, mixed>>>  $localeCards
     */
    private static function sharedCardField(array $localeCards, int $i, string $field): mixed
    {
        $order = array_merge(['en'], array_diff(Locales::codes(), ['en']));

        foreach ($order as $locale) {
            $card = is_array($localeCards[$locale][$i] ?? null) ? $localeCards[$locale][$i] : [];
            $value = $card[$field] ?? null;

            if (filled($value)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, array<string, mixed>>
     */
    private static function saveLocation(array $data): array
    {
        $formCards = is_array($data['cards'] ?? null) ? $data['cards'] : [];
        $payload = [];

        foreach (Locales::codes() as $locale) {
            $localePayload = is_array($data[$locale] ?? null) ? $data[$locale] : [];
            $localeCards = [];

            foreach (array_slice(array_values($formCards), 0, 3) as $card) {
                if (! is_array($card)) {
                    continue;
                }

                $meta = $card['_meta'] ?? [];
                if (is_string($meta)) {
                    $meta = json_decode($meta, true) ?? [];
                }
                if (! is_array($meta)) {
                    $meta = [];
                }

                $shared = [
                    'photo' => self::nullablePath($card['photo'] ?? null),
                    'activeImg' => self::nullablePath($card['activeImg'] ?? null),
                    'route' => $card['route'] ?? ($meta['route'] ?? null),
                ];

                $localeCards[] = array_merge($meta, $shared, [
                    'title' => data_get($card, "title.{$locale}", ''),
                    'listLines' => self::textToLines(data_get($card, "list_lines.{$locale}", '')),
                ]);
            }

            // Pad to exactly 3 so front layout never breaks.
            while (count($localeCards) < 3) {
                $localeCards[] = [
                    'title' => '',
                    'listLines' => [],
                    'photo' => null,
                    'activeImg' => null,
                    'route' => null,
                ];
            }

            $localePayload['cards'] = array_slice($localeCards, 0, 3);
            $payload[$locale] = $localePayload;
        }

        return $payload;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private static function fillInterior(array $data): array
    {
        $localeTabs = [];

        foreach (Locales::codes() as $locale) {
            $localeTabs[$locale] = is_array($data[$locale]['tabs'] ?? null) ? $data[$locale]['tabs'] : [];
        }

        $enTabs = $localeTabs['en'];

        // Legacy: tabs were string labels only.
        if ($enTabs !== [] && is_string($enTabs[0] ?? null)) {
            $images = ['interior/slide-01.webp', 'interior/slide-02.webp', 'interior/slide-03.webp', 'interior/slide-04.webp'];
            $tabs = [];

            foreach ($enTabs as $i => $label) {
                $labelMap = ['en' => (string) $label];

                foreach (array_diff(Locales::codes(), ['en']) as $locale) {
                    $labelMap[$locale] = (string) ($localeTabs[$locale][$i] ?? $label);
                }

                $tabs[] = [
                    'label' => $labelMap,
                    'images' => $images,
                ];
            }

            $data['tabs'] = $tabs;

            return $data;
        }

        $tabs = [];
        $count = max(array_map('count', $localeTabs));

        for ($i = 0; $i < $count; $i++) {
            $labelMap = [];

            foreach (Locales::codes() as $locale) {
                $tab = is_array($localeTabs[$locale][$i] ?? null) ? $localeTabs[$locale][$i] : [];
                $enTab = is_array($localeTabs['en'][$i] ?? null) ? $localeTabs['en'][$i] : [];

                if ($locale === 'en') {
                    $labelMap[$locale] = is_string($tab['label'] ?? null)
                        ? $tab['label']
                        : (string) ($tab['label']['en'] ?? '');
                } else {
                    $fallback = is_string($enTab['label'] ?? null)
                        ? $enTab['label']
                        : (string) ($enTab['label']['en'] ?? '');

                    $labelMap[$locale] = is_string($tab['label'] ?? null)
                        ? $tab['label']
                        : (string) ($tab['label'][$locale] ?? $fallback);
                }
            }

            $tabs[] = [
                'label' => $labelMap,
                'images' => array_values(array_filter(self::firstNonEmptyTabImages($localeTabs, $i, []))),
            ];
        }

        $data['tabs'] = $tabs;

        return $data;
    }

    /**
     * @param  array<string, list<array<string, mixed>>>  $localeTabs
     * @param  list<mixed>  $fallback
     * @return list<mixed>
     */
    private static function firstNonEmptyTabImages(array $localeTabs, int $i, array $fallback): array
    {
        $order = array_merge(['en'], array_diff(Locales::codes(), ['en']));

        foreach ($order as $locale) {
            $tab = is_array($localeTabs[$locale][$i] ?? null) ? $localeTabs[$locale][$i] : [];
            $images = is_array($tab['images'] ?? null) ? $tab['images'] : [];

            if ($images !== []) {
                return $images;
            }
        }

        return $fallback;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, array<string, mixed>>
     */
    private static function saveInterior(array $data): array
    {
        $formTabs = is_array($data['tabs'] ?? null) ? $data['tabs'] : [];
        $payload = [];

        foreach (Locales::codes() as $locale) {
            $localePayload = is_array($data[$locale] ?? null) ? $data[$locale] : [];
            $localeTabs = [];

            foreach ($formTabs as $tab) {
                if (! is_array($tab)) {
                    continue;
                }

                $images = array_values(array_filter(is_array($tab['images'] ?? null) ? $tab['images'] : []));
                if ($images === []) {
                    continue;
                }

                $localeTabs[] = [
                    'label' => data_get($tab, "label.{$locale}", ''),
                    'images' => $images,
                ];
            }

            $localePayload['tabs'] = $localeTabs;
            $payload[$locale] = $localePayload;
        }

        return $payload;
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $en
     * @return array<string, mixed>
     */
    private static function fillBlog(array $data, array $en): array
    {
        $posts = is_array($en['posts'] ?? null) ? $en['posts'] : [];
        $data['posts'] = array_values(array_map(
            function (mixed $slug): ?string {
                if (is_array($slug)) {
                    $slug = $slug['slug'] ?? null;
                }

                return filled($slug) ? (string) $slug : null;
            },
            array_slice(array_values($posts), 0, 4),
        ));

        if ($data['posts'] === []) {
            $data['posts'] = [null];
        }

        foreach (['title_line1', 'title_line2', 'title_single'] as $field) {
            $map = [];
            foreach (Locales::codes() as $locale) {
                $map[$locale] = (string) ($data[$locale][$field] ?? '');
            }
            $data[$field] = $map;
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, array<string, mixed>>
     */
    private static function saveBlog(array $data): array
    {
        $posts = \App\Filament\Resources\HomeSections\Schemas\Sections\BlogForm::extractSlugs($data);
        $posts = array_values(array_unique($posts));
        $posts = array_slice($posts, 0, 4);

        $payload = [];

        foreach (Locales::codes() as $locale) {
            $payload[$locale] = [
                'posts' => $posts,
                'title_line1' => trim((string) data_get($data, "title_line1.{$locale}", '')),
                'title_line2' => trim((string) data_get($data, "title_line2.{$locale}", '')),
                'title_single' => trim((string) data_get($data, "title_single.{$locale}", '')),
            ];
        }

        return $payload;
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $en
     * @return array<string, mixed>
     */
    private static function fillShop(array $data, array $en): array
    {
        $data['background_image'] = self::nullablePath($en['background_image'] ?? null);

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, array<string, mixed>>
     */
    private static function saveShop(array $data): array
    {
        $bg = self::nullablePath($data['background_image'] ?? null);
        $payload = [];

        foreach (Locales::codes() as $locale) {
            $localePayload = is_array($data[$locale] ?? null) ? $data[$locale] : [];
            $localePayload['background_image'] = $bg;
            $payload[$locale] = $localePayload;
        }

        return $payload;
    }

    /**
     * Keep slug/media/titles aligned with selected villa.
     * Custom uploads (non-stock paths) are preserved; stock media from another villa is replaced.
     *
     * @param  array<string, mixed>  $slide
     * @return array<string, mixed>
     */
    private static function reconcileVillaSlide(array $slide): array
    {
        $villaId = $slide['villa_id'] ?? null;
        if (! filled($villaId)) {
            return $slide;
        }

        $villa = \App\Models\Villa::query()->find((int) $villaId);
        if (! $villa) {
            return $slide;
        }

        $slide['slug'] = $villa->slug;

        $foreignPhotos = \App\Models\Villa::query()
            ->whereKeyNot($villa->id)
            ->pluck('slide_photo')
            ->filter()
            ->all();
        $foreignOvals = \App\Models\Villa::query()
            ->whereKeyNot($villa->id)
            ->pluck('slide_oval')
            ->filter()
            ->all();

        $photo = self::nullableVillaMedia($slide['photo'] ?? null);
        $oval = self::nullableVillaMedia($slide['oval'] ?? null);
        $photoForeign = ! filled($photo) || in_array($photo, $foreignPhotos, true);
        $ovalForeign = ! filled($oval) || in_array($oval, $foreignOvals, true);

        if ($photoForeign) {
            $slide['photo'] = $villa->slide_photo;
        }
        if ($ovalForeign) {
            $slide['oval'] = $villa->slide_oval;
        }

        // Titles still pointing at another villa (classic after broken swap) → pull from model.
        $foreignTitles = \App\Models\Villa::query()
            ->whereKeyNot($villa->id)
            ->get()
            ->flatMap(fn (\App\Models\Villa $v) => collect(Locales::codes())->map(
                fn (string $locale) => trim($v->getTranslation('title_normal', $locale).' '.$v->getTranslation('title_italic', $locale))
            ))
            ->filter()
            ->all();

        $localeTitles = [];

        foreach (Locales::codes() as $locale) {
            $localeTitles[$locale] = trim((string) data_get($slide, "title_normal.{$locale}").' '.(string) data_get($slide, "title_italic.{$locale}"));
        }

        $enTitle = $localeTitles['en'] ?? '';
        $titlesForeign = $enTitle === '' || in_array($enTitle, $foreignTitles, true);

        if ($titlesForeign || $photoForeign) {
            $slide['title_normal'] = [];
            $slide['title_italic'] = [];

            foreach (Locales::codes() as $locale) {
                $slide['title_normal'][$locale] = $villa->getTranslation('title_normal', $locale);
                $slide['title_italic'][$locale] = $villa->getTranslation('title_italic', $locale);
            }
        }

        foreach (Locales::codes() as $locale) {
            if ($locale === 'en' && ($titlesForeign || $photoForeign)) {
                continue;
            }

            $title = $localeTitles[$locale] ?? '';

            if ($title === '' || in_array($title, $foreignTitles, true)) {
                data_set($slide, "title_normal.{$locale}", $villa->getTranslation('title_normal', $locale));
                data_set($slide, "title_italic.{$locale}", $villa->getTranslation('title_italic', $locale));
            }
        }

        foreach (['subtitle', 'subtitle_line1', 'subtitle_line2'] as $field) {
            $allEmpty = true;

            foreach (Locales::codes() as $locale) {
                if (filled(data_get($slide, "{$field}.{$locale}"))) {
                    $allEmpty = false;
                    break;
                }
            }

            if ($allEmpty) {
                $slide[$field] = [];

                foreach (Locales::codes() as $locale) {
                    $slide[$field][$locale] = $villa->getTranslation($field, $locale);
                }
            }
        }

        return $slide;
    }

    private static function nullableVillaMedia(mixed $value): ?string
    {
        if (! is_string($value) || trim($value) === '') {
            return null;
        }

        if (str_contains($value, '/')) {
            return $value;
        }

        return 'villas/'.preg_replace('/\.(webp|jpe?g|png)$/i', '', $value).'.webp';
    }

    private static function normalizeVillaMedia(mixed $value, string $kind, int $index): string
    {
        return self::nullableVillaMedia($value)
            ?? sprintf('villas/%s-%02d.webp', $kind, $index);
    }

    /**
     * Filament FileUpload may send null, '', or [] when cleared.
     */
    private static function nullablePath(mixed $value): ?string
    {
        if (is_array($value)) {
            $value = $value[0] ?? null;
        }

        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value !== '' ? $value : null;
    }

    private static function linesToText(mixed $lines): string
    {
        if (! is_array($lines)) {
            return is_string($lines) ? $lines : '';
        }

        return implode("\n", array_map(fn ($l) => (string) $l, $lines));
    }

    /**
     * @return list<string>
     */
    private static function textToLines(mixed $text): array
    {
        $text = (string) $text;
        if (trim($text) === '') {
            return [];
        }

        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $text) ?: [])));
    }
}
