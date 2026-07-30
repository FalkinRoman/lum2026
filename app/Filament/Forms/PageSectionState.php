<?php

namespace App\Filament\Forms;

use App\Support\Locales;

/**
 * Flatten / rebuild PageSection payload for typed Filament forms.
 */
class PageSectionState
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function fill(string $page, string $key, array $data): array
    {
        $payload = is_array($data['payload'] ?? null) ? $data['payload'] : [];

        foreach (Locales::codes() as $locale) {
            $data[$locale] = is_array($payload[$locale] ?? null) ? $payload[$locale] : [];
        }

        $en = $data['en'];

        return match ("{$page}.{$key}") {
            'stay.intro', 'dining.intro',
            'relax.intro', 'discover.intro',
            'stay.quote', 'dining.quote', 'relax.quote' => $data,
            'stay.media', 'dining.media', 'relax.media' => self::fillMedia($data, $en),
            default => $data,
        };
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function save(string $page, string $key, array $data): array
    {
        $payload = match ("{$page}.{$key}") {
            'stay.intro', 'dining.intro' => self::localeOnly($data, [
                'title_line1', 'title_line2', 'title_italic', 'eyebrow',
            ]),
            'relax.intro' => self::localeOnly($data, [
                'title_line1', 'title_line2', 'title_italic', 'eyebrow_line1', 'eyebrow_line2',
            ]),
            'discover.intro' => self::localeOnly($data, [
                'title_normal', 'title_italic', 'eyebrow',
            ]),
            'stay.media', 'dining.media', 'relax.media' => self::saveMedia($data),
            'stay.quote' => self::localeOnly($data, [
                'quote', 'quote_break', 'note_line1', 'note_line2',
            ]),
            'dining.quote', 'relax.quote' => self::localeOnly($data, [
                'quote_line1', 'quote_line2', 'note_line1', 'note_line2',
            ]),
            default => self::rawLocales($data),
        };

        $data['payload'] = $payload;

        foreach (Locales::codes() as $locale) {
            unset($data[$locale]);
        }

        unset(
            $data['hero_image'],
            $data['hero_image_mob'],
            $data['hero_image_tab'],
            $data['oval_image'],
        );

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $en
     * @return array<string, mixed>
     */
    private static function fillMedia(array $data, array $en): array
    {
        $data['hero_image'] = self::nullablePath($en['hero_image'] ?? null);
        $data['hero_image_mob'] = self::nullablePath($en['hero_image_mob'] ?? null);
        $data['hero_image_tab'] = self::nullablePath($en['hero_image_tab'] ?? null);
        $data['oval_image'] = self::nullablePath($en['oval_image'] ?? null);

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, array<string, mixed>>
     */
    private static function saveMedia(array $data): array
    {
        $shared = array_filter([
            'hero_image' => self::nullablePath($data['hero_image'] ?? null),
            'hero_image_mob' => self::nullablePath($data['hero_image_mob'] ?? null),
            'hero_image_tab' => self::nullablePath($data['hero_image_tab'] ?? null),
            'oval_image' => self::nullablePath($data['oval_image'] ?? null),
        ], fn (mixed $v): bool => $v !== null);

        $out = [];
        foreach (Locales::codes() as $locale) {
            $out[$locale] = $shared;
        }

        return $out;
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  list<string>  $fields
     * @return array<string, array<string, mixed>>
     */
    private static function localeOnly(array $data, array $fields): array
    {
        $out = [];

        foreach (Locales::codes() as $locale) {
            $localeData = [];
            foreach ($fields as $field) {
                $localeData[$field] = data_get($data, "{$locale}.{$field}", '');
            }
            $out[$locale] = $localeData;
        }

        return $out;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, array<string, mixed>>
     */
    private static function rawLocales(array $data): array
    {
        $out = [];

        foreach (Locales::codes() as $locale) {
            $out[$locale] = is_array($data[$locale] ?? null) ? $data[$locale] : [];
        }

        return $out;
    }

    private static function nullablePath(mixed $value): ?string
    {
        if (is_array($value)) {
            $value = $value[0] ?? null;
        }

        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value !== '' ? ltrim($value, '/') : null;
    }
}
