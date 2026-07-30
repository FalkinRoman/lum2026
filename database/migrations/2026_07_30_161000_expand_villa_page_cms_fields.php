<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('villas', function (Blueprint $table) {
            $table->json('facilities_eyebrow')->nullable()->after('gallery_body_bottom');
            $table->json('facilities_title_normal')->nullable()->after('facilities_eyebrow');
            $table->json('facilities_title_italic')->nullable()->after('facilities_title_normal');
            $table->string('facilities_image_left')->nullable()->after('facilities_right');
            $table->string('facilities_image_right')->nullable()->after('facilities_image_left');

            $table->json('impression_title_normal')->nullable()->after('facilities_image_right');
            $table->json('impression_title_caps')->nullable()->after('impression_title_normal');
            $table->json('impression_tabs')->nullable()->after('impression_title_caps');
            $table->json('impression_slides')->nullable()->after('impression_tabs');
            $table->json('impression_cta')->nullable()->after('impression_slides');

            $table->json('shop_eyebrow')->nullable()->after('impression_cta');
            $table->json('shop_title_normal')->nullable()->after('shop_eyebrow');
            $table->json('shop_title_italic')->nullable()->after('shop_title_normal');
            $table->json('shop_cta')->nullable()->after('shop_title_italic');
            $table->string('shop_background_image')->nullable()->after('shop_cta');
        });

        $this->normalizeGalleryImages();
    }

    public function down(): void
    {
        Schema::table('villas', function (Blueprint $table) {
            $table->dropColumn([
                'facilities_eyebrow',
                'facilities_title_normal',
                'facilities_title_italic',
                'facilities_image_left',
                'facilities_image_right',
                'impression_title_normal',
                'impression_title_caps',
                'impression_tabs',
                'impression_slides',
                'impression_cta',
                'shop_eyebrow',
                'shop_title_normal',
                'shop_title_italic',
                'shop_cta',
                'shop_background_image',
            ]);
        });
    }

    private function normalizeGalleryImages(): void
    {
        $defaultDates = ['06.08.2023', '06.01.2024', '07.03.2023'];

        foreach (DB::table('villas')->select(['id', 'gallery_images'])->get() as $row) {
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

            DB::table('villas')->where('id', $row->id)->update([
                'gallery_images' => json_encode($normalized, JSON_UNESCAPED_UNICODE),
            ]);
        }
    }
};
