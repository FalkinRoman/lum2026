<?php

namespace App\Filament\Resources\Villas\Concerns;

use App\Support\Locales as AppLocales;

trait NormalizesVillaMedia
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function normalizeVillaMedia(array $data): array
    {
        if (array_key_exists('exely_hotel_id', $data) && blank($data['exely_hotel_id'])) {
            $data['exely_hotel_id'] = null;
        }

        if (($data['impression_cta_mode'] ?? 'villa') !== 'custom') {
            $data['impression_cta_url'] = null;
        }

        $data['gallery_images'] = collect($data['gallery_images'] ?? [])
            ->map(function (mixed $item): ?array {
                if (! is_array($item)) {
                    return null;
                }

                $path = $item['path'] ?? null;
                if (is_array($path)) {
                    $path = $path[0] ?? null;
                }

                if (! is_string($path) || trim($path) === '') {
                    return null;
                }

                return [
                    'path' => ltrim($path, '/'),
                    'date' => is_string($item['date'] ?? null) ? trim($item['date']) : '',
                ];
            })
            ->filter()
            ->values()
            ->all();

        $data['impression_galleries'] = collect($data['impression_galleries'] ?? [])
            ->map(function (mixed $gallery): ?array {
                if (! is_array($gallery)) {
                    return null;
                }

                $label = is_array($gallery['label'] ?? null) ? $gallery['label'] : [];
                $values = [];
                foreach (AppLocales::codes() as $locale) {
                    $values[$locale] = is_string($label[$locale] ?? null) ? trim($label[$locale]) : '';
                }

                if (collect($values)->every(fn (string $v): bool => $v === '')) {
                    return null;
                }

                $fallback = $values['en'] !== '' ? $values['en'] : collect($values)->first(fn (string $v): bool => $v !== '') ?? '';
                $normalizedLabel = [];
                foreach (AppLocales::codes() as $locale) {
                    $normalizedLabel[$locale] = $values[$locale] !== '' ? $values[$locale] : $fallback;
                }

                $images = collect($gallery['images'] ?? [])
                    ->map(function (mixed $path): ?string {
                        if (is_array($path)) {
                            $path = $path[0] ?? null;
                        }

                        if (! is_string($path) || trim($path) === '') {
                            return null;
                        }

                        return ltrim($path, '/');
                    })
                    ->filter()
                    ->values()
                    ->all();

                if ($images === []) {
                    return null;
                }

                return [
                    'label' => $normalizedLabel,
                    'images' => $images,
                ];
            })
            ->filter()
            ->values()
            ->all();

        foreach ([
            'listing_image', 'slide_photo', 'slide_oval', 'hero_image',
            'facilities_image_left', 'facilities_image_right',
        ] as $field) {
            $value = $data[$field] ?? null;
            if (is_array($value)) {
                $value = $value[0] ?? null;
            }
            $data[$field] = is_string($value) && trim($value) !== '' ? ltrim($value, '/') : null;
        }

        unset($data['impression_slides']);

        return $data;
    }
}
