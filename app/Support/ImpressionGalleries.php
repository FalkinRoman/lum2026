<?php

namespace App\Support;

/**
 * Default CMS "tabs + slides" payloads for impression carousels.
 */
class ImpressionGalleries
{
    /**
     * @return list<array{label: array<string, string>, images: list<string>}>
     */
    public static function forExcursion(): array
    {
        return self::fromLangTabs(
            'lum.excursion.impression.tabs',
            [
                'discover/detail/shared/impression/slide-01.webp',
                'discover/detail/shared/impression/slide-02.webp',
                'discover/detail/shared/impression/slide-03.webp',
                'discover/detail/shared/impression/slide-04.webp',
            ],
        );
    }

    /**
     * @return list<array{label: array<string, string>, images: list<string>}>
     */
    public static function forActivity(): array
    {
        return self::fromLangTabs(
            'lum.activity.impression.tabs',
            [
                'dining/detail/shared/impression/slide-01.webp',
                'dining/detail/shared/impression/slide-02.webp',
                'dining/detail/shared/impression/slide-03.webp',
                'dining/detail/shared/impression/slide-04.webp',
            ],
        );
    }

    /**
     * @param  list<string>  $images
     * @return list<array{label: array<string, string>, images: list<string>}>
     */
    public static function fromLangTabs(string $langKey, array $images): array
    {
        $byLocale = [];
        foreach (Locales::codes() as $locale) {
            $tabs = trans($langKey, [], $locale);
            $byLocale[$locale] = is_array($tabs) ? array_values($tabs) : [];
        }

        $count = 0;
        foreach ($byLocale as $tabs) {
            $count = max($count, count($tabs));
        }

        $galleries = [];
        for ($i = 0; $i < $count; $i++) {
            $label = [];
            foreach (Locales::codes() as $locale) {
                $value = $byLocale[$locale][$i] ?? null;
                $label[$locale] = is_string($value) ? $value : '';
            }

            if (trim(implode('', $label)) === '') {
                continue;
            }

            // Fill empty locales from en/ru so Filament required(en) still works.
            $fallback = $label['en'] !== '' ? $label['en'] : ($label['ru'] !== '' ? $label['ru'] : (string) reset($label));
            foreach ($label as $locale => $value) {
                if (trim($value) === '') {
                    $label[$locale] = $fallback;
                }
            }

            $galleries[] = [
                'label' => $label,
                'images' => $images,
            ];
        }

        return $galleries;
    }

    public static function isEmpty(mixed $galleries): bool
    {
        if (! is_array($galleries) || $galleries === []) {
            return true;
        }

        foreach ($galleries as $gallery) {
            if (! is_array($gallery)) {
                continue;
            }

            $label = is_array($gallery['label'] ?? null) ? $gallery['label'] : [];
            $hasLabel = false;
            foreach ($label as $value) {
                if (is_string($value) && trim($value) !== '') {
                    $hasLabel = true;
                    break;
                }
            }

            $images = is_array($gallery['images'] ?? null) ? $gallery['images'] : [];
            $hasImages = false;
            foreach ($images as $image) {
                if (is_string($image) && trim($image) !== '') {
                    $hasImages = true;
                    break;
                }
            }

            if ($hasLabel || $hasImages) {
                return false;
            }
        }

        return true;
    }
}
