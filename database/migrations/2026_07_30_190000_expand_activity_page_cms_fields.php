<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->json('impression_title_normal')->nullable()->after('pricing_items');
            $table->json('impression_title_caps')->nullable()->after('impression_title_normal');
            $table->json('impression_galleries')->nullable()->after('impression_title_caps');
            $table->json('impression_cta')->nullable()->after('impression_galleries');
            $table->string('impression_cta_mode')->default('activity')->after('impression_cta');
            $table->string('impression_cta_url')->nullable()->after('impression_cta_mode');

            $table->string('quote_hero_image')->nullable()->after('quote_note');
            $table->string('quote_oval_image')->nullable()->after('quote_hero_image');
        });

        $this->normalizeGalleryImages('activities');
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn([
                'impression_title_normal',
                'impression_title_caps',
                'impression_galleries',
                'impression_cta',
                'impression_cta_mode',
                'impression_cta_url',
                'quote_hero_image',
                'quote_oval_image',
            ]);
        });
    }

    private function normalizeGalleryImages(string $table): void
    {
        $defaultDates = ['06.05.2026', '06.05.2026', '06.05.2026'];

        foreach (DB::table($table)->select(['id', 'gallery_images'])->get() as $row) {
            $raw = $row->gallery_images;
            if ($raw === null || $raw === '') {
                continue;
            }

            $items = is_string($raw) ? json_decode($raw, true) : $raw;
            if (! is_array($items)) {
                continue;
            }

            $normalized = [];
            foreach (array_values($items) as $i => $item) {
                if (is_string($item) && trim($item) !== '') {
                    $normalized[] = [
                        'path' => ltrim($item, '/'),
                        'date' => $defaultDates[$i] ?? '',
                    ];

                    continue;
                }

                if (is_array($item) && filled($item['path'] ?? null)) {
                    $normalized[] = [
                        'path' => ltrim((string) $item['path'], '/'),
                        'date' => (string) ($item['date'] ?? ($defaultDates[$i] ?? '')),
                    ];
                }
            }

            DB::table($table)->where('id', $row->id)->update([
                'gallery_images' => json_encode($normalized, JSON_UNESCAPED_UNICODE),
            ]);
        }
    }
};
