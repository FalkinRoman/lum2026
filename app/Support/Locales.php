<?php

namespace App\Support;

class Locales
{
    /**
     * @var list<string>
     */
    public const CODES = ['en', 'ru', 'zh'];

    /**
     * @return list<string>
     */
    public static function codes(): array
    {
        return self::CODES;
    }

    /**
     * Short labels for Filament tabs / language switcher UI.
     *
     * @return array<string, string>
     */
    public static function labels(): array
    {
        return [
            'en' => 'EN',
            'ru' => 'RU',
            'zh' => '中文',
        ];
    }

    public static function label(string $locale): string
    {
        return self::labels()[$locale] ?? strtoupper($locale);
    }

    public static function isSupported(string $locale): bool
    {
        return in_array($locale, self::CODES, true);
    }

    /**
     * Contact-row label for phone (CMS / contact page).
     */
    public static function phoneLabel(string $locale): string
    {
        return match ($locale) {
            'ru' => 'Телефон',
            'zh' => '电话',
            default => 'Phone',
        };
    }
}
