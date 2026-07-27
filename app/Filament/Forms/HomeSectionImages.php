<?php

namespace App\Filament\Forms;

/**
 * Sync image fields between HomeSection payload (en/ru) and flat form state.
 */
class HomeSectionImages
{
    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    public static function extract(string $key, array $payload): array
    {
        $en = is_array($payload['en'] ?? null) ? $payload['en'] : [];

        return match ($key) {
            'shop_teaser' => [
                'shop_bg' => $en['background_image'] ?? null,
            ],
            'hero' => [
                'hero_poster' => $en['video_poster'] ?? 'hero/video-poster.png',
            ],
            'polaroids' => [
                'polaroid_1' => $en['photos'][0] ?? 'polaroids/photo-1.jpg',
                'polaroid_2' => $en['photos'][1] ?? 'polaroids/photo-2.jpg',
                'polaroid_3' => $en['photos'][2] ?? 'polaroids/photo-3.jpg',
            ],
            'location' => [
                'location_0_photo' => data_get($en, 'cards.0.photo'),
                'location_0_active' => data_get($en, 'cards.0.activeImg'),
                'location_1_photo' => data_get($en, 'cards.1.photo'),
                'location_1_active' => data_get($en, 'cards.1.activeImg'),
                'location_2_photo' => data_get($en, 'cards.2.photo'),
                'location_2_active' => data_get($en, 'cards.2.activeImg'),
            ],
            default => [],
        };
    }

    /**
     * @param  array<string, mixed>  $payload
     * @param  array<string, mixed>  $images
     * @return array<string, mixed>
     */
    public static function merge(string $key, array $payload, array $images): array
    {
        foreach (['en', 'ru'] as $locale) {
            if (! isset($payload[$locale]) || ! is_array($payload[$locale])) {
                $payload[$locale] = [];
            }
        }

        return match ($key) {
            'shop_teaser' => self::setBoth($payload, 'background_image', $images['shop_bg'] ?? null),
            'hero' => self::setBoth($payload, 'video_poster', $images['hero_poster'] ?? null),
            'polaroids' => self::mergePolaroids($payload, $images),
            'location' => self::mergeLocation($payload, $images),
            default => $payload,
        };
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    private static function setBoth(array $payload, string $field, mixed $value): array
    {
        foreach (['en', 'ru'] as $locale) {
            $payload[$locale][$field] = $value;
        }

        return $payload;
    }

    /**
     * @param  array<string, mixed>  $payload
     * @param  array<string, mixed>  $images
     * @return array<string, mixed>
     */
    private static function mergePolaroids(array $payload, array $images): array
    {
        $photos = [
            $images['polaroid_1'] ?? 'polaroids/photo-1.jpg',
            $images['polaroid_2'] ?? 'polaroids/photo-2.jpg',
            $images['polaroid_3'] ?? 'polaroids/photo-3.jpg',
        ];

        foreach (['en', 'ru'] as $locale) {
            $payload[$locale]['photos'] = $photos;
        }

        return $payload;
    }

    /**
     * @param  array<string, mixed>  $payload
     * @param  array<string, mixed>  $images
     * @return array<string, mixed>
     */
    private static function mergeLocation(array $payload, array $images): array
    {
        foreach (['en', 'ru'] as $locale) {
            $cards = $payload[$locale]['cards'] ?? [];
            if (! is_array($cards)) {
                $cards = [];
            }

            for ($i = 0; $i < 3; $i++) {
                if (! isset($cards[$i]) || ! is_array($cards[$i])) {
                    $cards[$i] = [];
                }
                if (! empty($images["location_{$i}_photo"])) {
                    $cards[$i]['photo'] = $images["location_{$i}_photo"];
                }
                if (! empty($images["location_{$i}_active"])) {
                    $cards[$i]['activeImg'] = $images["location_{$i}_active"];
                }
            }

            $payload[$locale]['cards'] = $cards;
        }

        return $payload;
    }
}
