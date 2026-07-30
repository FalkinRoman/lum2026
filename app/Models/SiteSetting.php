<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SiteSetting extends Model
{
    use HasTranslations;

    protected $fillable = [
        'phone',
        'phone_href',
        'phone_personal',
        'phone_personal_href',
        'email',
        'map_url',
        'menu_image',
        'whatsapp_url',
        'instagram_url',
        'telegram_url',
        'take_a_break_url',
        'book_url',
        'use_booking_page',
        'address',
        'hours',
        'legal',
        'footer_address',
        'reviews',
        'copyright',
        'privacy_title',
        'privacy_body',
        'terms_title',
        'terms_body',
    ];

    public array $translatable = [
        'address',
        'hours',
        'legal',
        'footer_address',
        'reviews',
        'copyright',
        'privacy_title',
        'privacy_body',
        'terms_title',
        'terms_body',
    ];

    protected function casts(): array
    {
        return [
            'hours' => 'array',
            'legal' => 'array',
            'footer_address' => 'array',
            'use_booking_page' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }

    public function telHref(): string
    {
        return self::telLink((string) $this->phone);
    }

    public function personalTelHref(): string
    {
        return self::telLink((string) $this->phone_personal);
    }

    public function mailHref(): string
    {
        return 'mailto:'.($this->email ?: '');
    }

    public static function telLink(string $phone): string
    {
        $digits = preg_replace('/[^\d+]/', '', $phone);

        return $digits !== '' ? 'tel:'.$digits : '#';
    }
}
