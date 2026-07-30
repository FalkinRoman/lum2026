<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('excursions', function (Blueprint $table) {
            $table->json('impression_title_normal')->nullable()->after('book_url');
            $table->json('impression_title_caps')->nullable()->after('impression_title_normal');
            $table->json('impression_galleries')->nullable()->after('impression_title_caps');
            $table->json('impression_cta')->nullable()->after('impression_galleries');
            $table->string('impression_cta_mode')->default('excursion')->after('impression_cta');
            $table->string('impression_cta_url')->nullable()->after('impression_cta_mode');
        });

        $this->normalizeGalleryImagesWithPolaroidDates();
    }

    public function down(): void
    {
        Schema::table('excursions', function (Blueprint $table) {
            $table->dropColumn([
                'impression_title_normal',
                'impression_title_caps',
                'impression_galleries',
                'impression_cta',
                'impression_cta_mode',
                'impression_cta_url',
            ]);
        });
    }

    private function normalizeGalleryImagesWithPolaroidDates(): void
    {
        $fallbackDates = ['06.08.2023', '06.01.2024', '07.03.2023'];

        foreach (DB::table('excursions')->select(['id', 'gallery_images', 'polaroid_dates'])->get() as $row) {
            $raw = $row->gallery_images;
            if ($raw === null || $raw === '') {
                continue;
            }

            $items = is_string($raw) ? json_decode($raw, true) : $raw;
            if (! is_array($items)) {
                continue;
            }

            $dates = [];
            if ($row->polaroid_dates) {
                $decoded = is_string($row->polaroid_dates)
                    ? json_decode($row->polaroid_dates, true)
                    : $row->polaroid_dates;
                // Spatie stores {en:[...], ru:[...]} — prefer en
                if (is_array($decoded)) {
                    $dates = is_array($decoded['en'] ?? null)
                        ? array_values($decoded['en'])
                        : (array_is_list($decoded) ? array_values($decoded) : []);
                }
            }

            $normalized = [];
            foreach (array_values($items) as $i => $item) {
                $date = (string) ($dates[$i] ?? $fallbackDates[$i] ?? '');

                if (is_string($item) && trim($item) !== '') {
                    $normalized[] = [
                        'path' => ltrim($item, '/'),
                        'date' => $date,
                    ];

                    continue;
                }

                if (is_array($item) && filled($item['path'] ?? null)) {
                    $normalized[] = [
                        'path' => ltrim((string) $item['path'], '/'),
                        'date' => filled($item['date'] ?? null) ? (string) $item['date'] : $date,
                    ];
                }
            }

            DB::table('excursions')->where('id', $row->id)->update([
                'gallery_images' => json_encode($normalized, JSON_UNESCAPED_UNICODE),
            ]);
        }
    }
};
