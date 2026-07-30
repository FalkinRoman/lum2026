<?php

use App\Models\PageSection;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $this->splitStayWellness();
        $this->splitQuoteMedia('dining');
        $this->splitQuoteMedia('relax');
    }

    public function down(): void
    {
        // irreversible split — keep media/quote rows
    }

    private function splitStayWellness(): void
    {
        $row = PageSection::query()->where('page', 'stay')->where('key', 'wellness')->first();

        if (! $row) {
            return;
        }

        $payload = is_array($row->payload) ? $row->payload : [];
        $en = is_array($payload['en'] ?? null) ? $payload['en'] : [];
        $ru = is_array($payload['ru'] ?? null) ? $payload['ru'] : [];

        $mediaKeys = ['hero_image', 'oval_image', 'hero_image_mob', 'hero_image_tab'];
        $textKeys = ['quote', 'quote_break', 'note_line1', 'note_line2'];

        PageSection::put('stay', 'media', [
            'en' => array_intersect_key($en, array_flip($mediaKeys)),
            'ru' => array_intersect_key($ru, array_flip($mediaKeys)),
        ]);

        PageSection::put('stay', 'quote', [
            'en' => array_intersect_key($en, array_flip($textKeys)),
            'ru' => array_intersect_key($ru, array_flip($textKeys)),
        ]);

        $row->delete();
    }

    private function splitQuoteMedia(string $page): void
    {
        $row = PageSection::query()->where('page', $page)->where('key', 'quote')->first();

        if (! $row) {
            return;
        }

        $payload = is_array($row->payload) ? $row->payload : [];
        $en = is_array($payload['en'] ?? null) ? $payload['en'] : [];
        $ru = is_array($payload['ru'] ?? null) ? $payload['ru'] : [];

        $mediaKeys = ['hero_image', 'oval_image', 'hero_image_mob', 'hero_image_tab'];
        $textKeys = ['quote_line1', 'quote_line2', 'note_line1', 'note_line2'];

        $hasMedia = collect($mediaKeys)->contains(fn (string $k) => filled($en[$k] ?? null) || filled($ru[$k] ?? null));

        if ($hasMedia) {
            PageSection::put($page, 'media', [
                'en' => array_intersect_key($en, array_flip($mediaKeys)),
                'ru' => array_intersect_key($ru, array_flip($mediaKeys)),
            ]);
        }

        PageSection::put($page, 'quote', [
            'en' => array_intersect_key($en, array_flip($textKeys)),
            'ru' => array_intersect_key($ru, array_flip($textKeys)),
        ]);
    }
};
