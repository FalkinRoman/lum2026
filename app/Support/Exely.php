<?php

namespace App\Support;

class Exely
{
    public static function enabled(): bool
    {
        return (bool) config('exely.enabled');
    }

    public static function integrationId(): string
    {
        return (string) config('exely.integration_id');
    }

    public static function locale(): string
    {
        $locale = app()->getLocale();

        return in_array($locale, ['en', 'ru'], true) ? $locale : 'en';
    }

    public static function hotelContext(?string $hotelId): string
    {
        $base = self::integrationId();

        if ($hotelId) {
            return $base.'.'.$hotelId;
        }

        return $base;
    }

    /**
     * @return array<string, string>
     */
    public static function hotelOptions(): array
    {
        $options = [];

        foreach (config('exely.hotels', []) as $id => $hotel) {
            $options[(string) $id] = ($hotel['label'] ?? $id).' ('.$id.')';
        }

        return $options;
    }

    /**
     * @return array<string, string>
     */
    public static function roomTypeOptions(?string $hotelId = null): array
    {
        $hotels = config('exely.hotels', []);
        $options = [];

        if ($hotelId && isset($hotels[$hotelId]['room_types'])) {
            foreach ($hotels[$hotelId]['room_types'] as $id => $label) {
                $options[(string) $id] = $label.' ('.$id.')';
            }

            return $options;
        }

        foreach ($hotels as $hotel) {
            foreach (($hotel['room_types'] ?? []) as $id => $label) {
                $options[(string) $id] = $label.' ('.$id.')';
            }
        }

        return $options;
    }

    public static function bookingUrl(?string $hotelId = null, ?string $roomTypeId = null, ?string $offerId = null): string
    {
        $query = array_filter([
            'hotel_id' => $hotelId ?: null,
            'room-type' => $roomTypeId ?: null,
            'special-offer' => $offerId ?: null,
        ], fn ($v) => $v !== null && $v !== '');

        return route('booking', $query);
    }

    public static function searchContainerId(?string $hotelId = null): string
    {
        return $hotelId
            ? 'be-search-form-'.$hotelId
            : 'be-search-form';
    }

    public static function hotelLabel(?string $hotelId): ?string
    {
        if (! $hotelId) {
            return null;
        }

        $hotel = config('exely.hotels.'.$hotelId);

        return is_array($hotel) ? (string) ($hotel['label'] ?? $hotelId) : $hotelId;
    }

    public static function hotelIdForVilla(?string $slug, ?string $storedHotelId = null): ?string
    {
        if (filled($storedHotelId)) {
            return (string) $storedHotelId;
        }

        if (! $slug) {
            return null;
        }

        $mapped = config('exely.villa_hotels.'.$slug);

        return $mapped ? (string) $mapped : null;
    }
}
