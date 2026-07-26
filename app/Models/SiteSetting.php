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
        'email',
        'map_url',
        'whatsapp_url',
        'instagram_url',
        'telegram_url',
        'take_a_break_url',
        'book_url',
        'address',
        'hours',
        'legal',
        'footer_address',
        'reviews',
        'copyright',
    ];

    public array $translatable = [
        'address',
        'hours',
        'legal',
        'footer_address',
        'reviews',
        'copyright',
    ];

    protected function casts(): array
    {
        return [
            'hours' => 'array',
            'legal' => 'array',
            'footer_address' => 'array',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }

    public function telHref(): string
    {
        return $this->phone_href ?: ('tel:'.preg_replace('/[^\d+]/', '', (string) $this->phone));
    }

    public function mailHref(): string
    {
        return 'mailto:'.($this->email ?: '');
    }
}
