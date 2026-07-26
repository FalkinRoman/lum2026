<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class Site
{
    public static function settings(): SiteSetting
    {
        // Request-level memo only — caching Eloquent+Spatie via DB store
        // unserializes as __PHP_Incomplete_Class.
        return once(fn () => SiteSetting::current());
    }

    public static function forget(): void
    {
        Cache::forget('site_settings');
    }

    public static function takeABreakUrl(): string
    {
        if (Exely::enabled()) {
            return Exely::bookingUrl();
        }

        return self::settings()->take_a_break_url ?: '#';
    }

    public static function mapUrl(): string
    {
        return self::settings()->map_url ?: '#';
    }

    public static function bookUrl(?string $fallback = null): string
    {
        if ($fallback) {
            return $fallback;
        }

        if (Exely::enabled()) {
            return Exely::bookingUrl();
        }

        return self::settings()->book_url ?: (self::settings()->take_a_break_url ?: '#');
    }

    public static function villaBookingUrl(?string $hotelId = null, ?string $roomTypeId = null): string
    {
        if (Exely::enabled()) {
            return Exely::bookingUrl($hotelId, $roomTypeId);
        }

        return self::takeABreakUrl();
    }

    public static function phone(): string
    {
        return (string) (self::settings()->phone ?: '');
    }

    public static function phoneHref(): string
    {
        return self::settings()->telHref();
    }

    public static function email(): string
    {
        return (string) (self::settings()->email ?: '');
    }

    public static function emailHref(): string
    {
        return self::settings()->mailHref();
    }

    public static function whatsappUrl(): string
    {
        return self::settings()->whatsapp_url ?: '#';
    }

    public static function instagramUrl(): string
    {
        return self::settings()->instagram_url ?: '#';
    }

    public static function telegramUrl(): string
    {
        return self::settings()->telegram_url ?: '#';
    }

    public static function imageUrl(?string $path, string $prefix = 'images/lum/'): string
    {
        if (! $path) {
            return '';
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/storage/')) {
            return $path;
        }

        if (str_starts_with($path, 'images/') || str_starts_with($path, '/images/')) {
            return asset(ltrim($path, '/'));
        }

        return asset($prefix.ltrim($path, '/'));
    }
}
