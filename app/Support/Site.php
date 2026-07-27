<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class Site
{
    private static ?SiteSetting $memo = null;

    public static function settings(): SiteSetting
    {
        return self::$memo ??= SiteSetting::current();
    }

    public static function forget(): void
    {
        self::$memo = null;
        Cache::forget('site_settings');
    }

    public static function bookingDestination(): string
    {
        if (Exely::enabled()) {
            return Exely::bookingUrl();
        }

        $settings = self::settings();

        if ($settings->use_booking_page) {
            return route('booking');
        }

        return $settings->book_url
            ?: $settings->take_a_break_url
            ?: route('booking');
    }

    public static function takeABreakUrl(): string
    {
        return self::bookingDestination();
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

        return self::bookingDestination();
    }

    public static function villaBookingUrl(?string $hotelId = null, ?string $roomTypeId = null): string
    {
        if (Exely::enabled()) {
            return Exely::bookingUrl($hotelId, $roomTypeId);
        }

        return self::bookingDestination();
    }

    public static function phone(): string
    {
        return (string) (self::settings()->phone ?: '');
    }

    public static function phoneHref(): string
    {
        return self::settings()->telHref();
    }

    public static function phonePersonal(): string
    {
        return (string) (self::settings()->phone_personal ?: '');
    }

    public static function phonePersonalHref(): string
    {
        return self::settings()->personalTelHref();
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

    public static function socialUrl(string $network): string
    {
        return match ($network) {
            'instagram' => self::instagramUrl(),
            'whatsapp' => self::whatsappUrl(),
            'telegram' => self::telegramUrl(),
            default => '#',
        };
    }

    /**
     * @return list<string>
     */
    public static function footerAddress(): array
    {
        $lines = self::settings()->getTranslation('footer_address', app()->getLocale()) ?: [];

        if (is_array($lines) && count(array_filter($lines)) > 0) {
            return array_values(array_map('strval', $lines));
        }

        return [
            (string) __('lum.footer.address_line1'),
            (string) __('lum.footer.address_line2'),
            (string) __('lum.footer.address_line3'),
        ];
    }

    public static function copyrightYear(): int
    {
        return (int) Cache::remember(
            'lum.footer_copyright_year',
            now()->endOfYear(),
            fn () => (int) now()->year,
        );
    }

    public static function copyright(): string
    {
        return (string) __('lum.footer.copyright', ['year' => self::copyrightYear()]);
    }

    public static function reviews(): string
    {
        return (string) __('lum.footer.reviews');
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
