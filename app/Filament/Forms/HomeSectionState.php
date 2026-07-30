<?php

namespace App\Filament\Forms;

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
        $en = is_array($payload['en'] ?? null) ? $payload['en'] : [];
        $ru = is_array($payload['ru'] ?? null) ? $payload['ru'] : [];

        $data['en'] = $en;
        $data['ru'] = $ru;

        return match ($key) {
            'hero' => self::fillHero($data, $en),
            'polaroids' => self::fillPolaroids($data, $en),
            'villas_intro' => self::fillVillas($data, $en, $ru),
            'location' => self::fillLocation($data, $en, $ru),
            'interior' => self::fillInterior($data, $en, $ru),
            'blog' => self::fillBlog($data, $en),
            'shop_teaser' => self::fillShop($data, $en),
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
            default => [
                'en' => is_array($data['en'] ?? null) ? $data['en'] : [],
                'ru' => is_array($data['ru'] ?? null) ? $data['ru'] : [],
            ],
        };

        $data['payload'] = $payload;
        unset(
            $data['en'],
            $data['ru'],
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
     * @return array<string, mixed>
     */
    private static function saveHero(array $data): array
    {
        $en = is_array($data['en'] ?? null) ? $data['en'] : [];
        $ru = is_array($data['ru'] ?? null) ? $data['ru'] : [];
        $ctaUrl = filled($data['cta_url'] ?? null) ? trim((string) $data['cta_url']) : 'stay';
        $shared = [
            // null = cleared in admin; front shows poster or dark stub (no seed fallback)
            'video' => self::nullablePath($data['video'] ?? null),
            'video_poster' => self::nullablePath($data['video_poster'] ?? null),
            'video_position' => $data['video_position'] ?? 'center',
            'cta_url' => $ctaUrl,
        ];

        return [
            'en' => array_merge($en, $shared),
            'ru' => array_merge($ru, $shared),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $en
     * @return array<string, mixed>
     */
    private static function fillPolaroids(array $data, array $en): array
    {
        $photos = is_array($en['photos'] ?? null) ? $en['photos'] : [];
        $data['photos'] = [
            self::nullablePath($photos[0] ?? null),
            self::nullablePath($photos[1] ?? null),
            self::nullablePath($photos[2] ?? null),
        ];
        $data['cta_url'] = is_string($en['cta_url'] ?? null) && $en['cta_url'] !== ''
            ? $en['cta_url']
            : 'stay';

        $ru = is_array($data['ru'] ?? null) ? $data['ru'] : [];
        if (! filled($en['cta'] ?? null)) {
            $data['en']['cta'] = __('lum.hero.cta', [], 'en');
        }
        if (! filled($ru['cta'] ?? null)) {
            $data['ru']['cta'] = __('lum.hero.cta', [], 'ru');
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private static function savePolaroids(array $data): array
    {
        $en = is_array($data['en'] ?? null) ? $data['en'] : [];
        $ru = is_array($data['ru'] ?? null) ? $data['ru'] : [];
        $photos = is_array($data['photos'] ?? null) ? array_values($data['photos']) : [];
        $photos = [
            self::nullablePath($photos[0] ?? null),
            self::nullablePath($photos[1] ?? null),
            self::nullablePath($photos[2] ?? null),
        ];
        $ctaUrl = filled($data['cta_url'] ?? null) ? trim((string) $data['cta_url']) : 'stay';

        // Keep motion ticker words if already present.
        foreach (['share', 'shine', 'impressions', 'relax'] as $word) {
            $en[$word] ??= $ru[$word] ?? null;
            $ru[$word] ??= $en[$word] ?? null;
        }

        if (! filled($en['cta'] ?? null)) {
            $en['cta'] = __('lum.hero.cta', [], 'en');
        }
        if (! filled($ru['cta'] ?? null)) {
            $ru['cta'] = __('lum.hero.cta', [], 'ru');
        }

        $en['photos'] = $photos;
        $ru['photos'] = $photos;
        $en['cta_url'] = $ctaUrl;
        $ru['cta_url'] = $ctaUrl;

        return ['en' => $en, 'ru' => $ru];
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $en
     * @param  array<string, mixed>  $ru
     * @return array<string, mixed>
     */
    private static function fillVillas(array $data, array $en, array $ru): array
    {
        $en = self::hydrateVillasIntro($en);
        $ru = self::hydrateVillasIntro($ru);
        $data['en'] = $en;
        $data['ru'] = $ru;

        $enSlides = is_array($en['slides'] ?? null) ? $en['slides'] : [];
        $ruSlides = is_array($ru['slides'] ?? null) ? $ru['slides'] : [];
        $count = max(count($enSlides), count($ruSlides), 1);
        $count = min($count, 4);
        $slides = [];

        for ($i = 0; $i < $count; $i++) {
            $e = is_array($enSlides[$i] ?? null) ? $enSlides[$i] : [];
            $r = is_array($ruSlides[$i] ?? null) ? $ruSlides[$i] : [];
            $slides[] = [
                'villa_id' => $e['villa_id'] ?? $r['villa_id'] ?? null,
                'slug' => $e['slug'] ?? $r['slug'] ?? null,
                'photo' => self::nullableVillaMedia($e['photo'] ?? $r['photo'] ?? null),
                'oval' => self::nullableVillaMedia($e['oval'] ?? $r['oval'] ?? null),
                'title_normal' => [
                    'en' => $e['title_normal'] ?? $e['titleNormal'] ?? '',
                    'ru' => $r['title_normal'] ?? $r['titleNormal'] ?? '',
                ],
                'title_italic' => [
                    'en' => $e['title_italic'] ?? $e['titleItalic'] ?? '',
                    'ru' => $r['title_italic'] ?? $r['titleItalic'] ?? '',
                ],
                'subtitle' => [
                    'en' => $e['subtitle'] ?? '',
                    'ru' => $r['subtitle'] ?? '',
                ],
                'subtitle_line1' => [
                    'en' => $e['subtitle_line1'] ?? $e['subtitleLine1'] ?? '',
                    'ru' => $r['subtitle_line1'] ?? $r['subtitleLine1'] ?? '',
                ],
                'subtitle_line2' => [
                    'en' => $e['subtitle_line2'] ?? $e['subtitleLine2'] ?? '',
                    'ru' => $r['subtitle_line2'] ?? $r['subtitleLine2'] ?? '',
                ],
            ];
        }

        $data['slides'] = $slides;

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private static function saveVillas(array $data): array
    {
        $en = self::syncVillasIntroLegacy(is_array($data['en'] ?? null) ? $data['en'] : []);
        $ru = self::syncVillasIntroLegacy(is_array($data['ru'] ?? null) ? $data['ru'] : []);
        $formSlides = is_array($data['slides'] ?? null) ? $data['slides'] : [];

        $enSlides = [];
        $ruSlides = [];

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

            $enSlides[] = array_merge($shared, [
                'title_normal' => data_get($slide, 'title_normal.en', ''),
                'title_italic' => data_get($slide, 'title_italic.en', ''),
                'subtitle' => data_get($slide, 'subtitle.en', ''),
                'subtitle_line1' => data_get($slide, 'subtitle_line1.en', ''),
                'subtitle_line2' => data_get($slide, 'subtitle_line2.en', ''),
                'titleNormal' => data_get($slide, 'title_normal.en', ''),
                'titleItalic' => data_get($slide, 'title_italic.en', ''),
                'subtitleLine1' => data_get($slide, 'subtitle_line1.en', ''),
                'subtitleLine2' => data_get($slide, 'subtitle_line2.en', ''),
            ]);

            $ruSlides[] = array_merge($shared, [
                'title_normal' => data_get($slide, 'title_normal.ru', ''),
                'title_italic' => data_get($slide, 'title_italic.ru', ''),
                'subtitle' => data_get($slide, 'subtitle.ru', ''),
                'subtitle_line1' => data_get($slide, 'subtitle_line1.ru', ''),
                'subtitle_line2' => data_get($slide, 'subtitle_line2.ru', ''),
                'titleNormal' => data_get($slide, 'title_normal.ru', ''),
                'titleItalic' => data_get($slide, 'title_italic.ru', ''),
                'subtitleLine1' => data_get($slide, 'subtitle_line1.ru', ''),
                'subtitleLine2' => data_get($slide, 'subtitle_line2.ru', ''),
            ]);
        }

        $en['slides'] = $enSlides;
        $ru['slides'] = $ruSlides;
        $en['view'] = $en['view'] ?? 'VIEW';
        $ru['view'] = $ru['view'] ?? 'VIEW';

        return ['en' => $en, 'ru' => $ru];
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
     * @param  array<string, mixed>  $en
     * @param  array<string, mixed>  $ru
     * @return array<string, mixed>
     */
    private static function fillLocation(array $data, array $en, array $ru): array
    {
        $enCards = is_array($en['cards'] ?? null) ? $en['cards'] : [];
        $ruCards = is_array($ru['cards'] ?? null) ? $ru['cards'] : [];
        $cards = [];

        $count = max(count($enCards), count($ruCards), 3);

        for ($i = 0; $i < $count; $i++) {
            $e = is_array($enCards[$i] ?? null) ? $enCards[$i] : [];
            $r = is_array($ruCards[$i] ?? null) ? $ruCards[$i] : [];
            $cards[] = [
                '_meta' => $e,
                'title' => [
                    'en' => $e['title'] ?? '',
                    'ru' => $r['title'] ?? '',
                ],
                'route' => $e['route'] ?? $r['route'] ?? '',
                'photo' => $e['photo'] ?? $r['photo'] ?? null,
                'activeImg' => $e['activeImg'] ?? $r['activeImg'] ?? null,
                'list_lines' => [
                    'en' => self::linesToText($e['listLines'] ?? []),
                    'ru' => self::linesToText($r['listLines'] ?? []),
                ],
            ];
        }

        $data['cards'] = $cards;

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private static function saveLocation(array $data): array
    {
        $en = is_array($data['en'] ?? null) ? $data['en'] : [];
        $ru = is_array($data['ru'] ?? null) ? $data['ru'] : [];
        $formCards = is_array($data['cards'] ?? null) ? $data['cards'] : [];

        $enCards = [];
        $ruCards = [];

        foreach ($formCards as $card) {
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

            $enCards[] = array_merge($meta, $shared, [
                'title' => data_get($card, 'title.en', ''),
                'listLines' => self::textToLines(data_get($card, 'list_lines.en', '')),
            ]);

            $ruCards[] = array_merge($meta, $shared, [
                'title' => data_get($card, 'title.ru', ''),
                'listLines' => self::textToLines(data_get($card, 'list_lines.ru', '')),
            ]);
        }

        $en['cards'] = $enCards;
        $ru['cards'] = $ruCards;

        return ['en' => $en, 'ru' => $ru];
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $en
     * @param  array<string, mixed>  $ru
     * @return array<string, mixed>
     */
    private static function fillInterior(array $data, array $en, array $ru): array
    {
        $enTabs = is_array($en['tabs'] ?? null) ? $en['tabs'] : [];
        $ruTabs = is_array($ru['tabs'] ?? null) ? $ru['tabs'] : [];

        // Legacy: tabs were string labels only.
        if ($enTabs !== [] && is_string($enTabs[0] ?? null)) {
            $images = ['interior/slide-01.webp', 'interior/slide-02.webp', 'interior/slide-03.webp', 'interior/slide-04.webp'];
            $tabs = [];
            foreach ($enTabs as $i => $label) {
                $tabs[] = [
                    'label' => [
                        'en' => (string) $label,
                        'ru' => (string) ($ruTabs[$i] ?? $label),
                    ],
                    'images' => $images,
                ];
            }
            $data['tabs'] = $tabs;

            return $data;
        }

        $tabs = [];
        $count = max(count($enTabs), count($ruTabs));

        for ($i = 0; $i < $count; $i++) {
            $e = is_array($enTabs[$i] ?? null) ? $enTabs[$i] : [];
            $r = is_array($ruTabs[$i] ?? null) ? $ruTabs[$i] : [];
            $tabs[] = [
                'label' => [
                    'en' => is_string($e['label'] ?? null) ? $e['label'] : (string) ($e['label']['en'] ?? ''),
                    'ru' => is_string($r['label'] ?? null) ? $r['label'] : (string) ($r['label']['ru'] ?? $e['label'] ?? ''),
                ],
                'images' => array_values(array_filter(
                    is_array($e['images'] ?? null) ? $e['images'] : (is_array($r['images'] ?? null) ? $r['images'] : [])
                )),
            ];
        }

        $data['tabs'] = $tabs;

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private static function saveInterior(array $data): array
    {
        $en = is_array($data['en'] ?? null) ? $data['en'] : [];
        $ru = is_array($data['ru'] ?? null) ? $data['ru'] : [];
        $formTabs = is_array($data['tabs'] ?? null) ? $data['tabs'] : [];

        $enTabs = [];
        $ruTabs = [];

        foreach ($formTabs as $tab) {
            if (! is_array($tab)) {
                continue;
            }

            $images = array_values(array_filter(is_array($tab['images'] ?? null) ? $tab['images'] : []));
            if ($images === []) {
                continue;
            }

            $enTabs[] = [
                'label' => data_get($tab, 'label.en', ''),
                'images' => $images,
            ];
            $ruTabs[] = [
                'label' => data_get($tab, 'label.ru', ''),
                'images' => $images,
            ];
        }

        $en['tabs'] = $enTabs;
        $ru['tabs'] = $ruTabs;

        return ['en' => $en, 'ru' => $ru];
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

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private static function saveBlog(array $data): array
    {
        $posts = \App\Filament\Resources\HomeSections\Schemas\Sections\BlogForm::extractSlugs($data);
        $posts = array_values(array_unique($posts));
        $posts = array_slice($posts, 0, 4);

        return [
            'en' => ['posts' => $posts],
            'ru' => ['posts' => $posts],
        ];
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
     * @return array<string, mixed>
     */
    private static function saveShop(array $data): array
    {
        $en = is_array($data['en'] ?? null) ? $data['en'] : [];
        $ru = is_array($data['ru'] ?? null) ? $data['ru'] : [];
        $bg = self::nullablePath($data['background_image'] ?? null);
        $en['background_image'] = $bg;
        $ru['background_image'] = $bg;

        return ['en' => $en, 'ru' => $ru];
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
            ->flatMap(fn (\App\Models\Villa $v) => [
                trim($v->getTranslation('title_normal', 'en').' '.$v->getTranslation('title_italic', 'en')),
                trim($v->getTranslation('title_normal', 'ru').' '.$v->getTranslation('title_italic', 'ru')),
            ])
            ->filter()
            ->all();

        $enTitle = trim((string) data_get($slide, 'title_normal.en').' '.(string) data_get($slide, 'title_italic.en'));
        $ruTitle = trim((string) data_get($slide, 'title_normal.ru').' '.(string) data_get($slide, 'title_italic.ru'));
        $titlesForeign = $enTitle === '' || in_array($enTitle, $foreignTitles, true);

        if ($titlesForeign || $photoForeign) {
            $slide['title_normal'] = [
                'en' => $villa->getTranslation('title_normal', 'en'),
                'ru' => $villa->getTranslation('title_normal', 'ru'),
            ];
            $slide['title_italic'] = [
                'en' => $villa->getTranslation('title_italic', 'en'),
                'ru' => $villa->getTranslation('title_italic', 'ru'),
            ];
        }

        if ($ruTitle === '' || in_array($ruTitle, $foreignTitles, true)) {
            data_set($slide, 'title_normal.ru', $villa->getTranslation('title_normal', 'ru'));
            data_set($slide, 'title_italic.ru', $villa->getTranslation('title_italic', 'ru'));
        }

        foreach (['subtitle', 'subtitle_line1', 'subtitle_line2'] as $field) {
            if (! filled(data_get($slide, "{$field}.en")) && ! filled(data_get($slide, "{$field}.ru"))) {
                $slide[$field] = [
                    'en' => $villa->getTranslation($field, 'en'),
                    'ru' => $villa->getTranslation($field, 'ru'),
                ];
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
