<?php

use App\Models\Villa;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('villas', function (Blueprint $table) {
            $table->json('impression_galleries')->nullable()->after('impression_slides');
        });

        $defaultSlides = [
            'villa/impression/slide-01.webp',
            'villa/impression/slide-02.webp',
            'villa/impression/slide-03.webp',
            'villa/impression/slide-04.webp',
        ];

        Villa::query()->each(function (Villa $villa) use ($defaultSlides): void {
            if (is_array($villa->impression_galleries) && $villa->impression_galleries !== []) {
                return;
            }

            $enTabs = $villa->getTranslation('impression_tabs', 'en', useFallbackLocale: false);
            $ruTabs = $villa->getTranslation('impression_tabs', 'ru', useFallbackLocale: false);
            if (! is_array($enTabs) || $enTabs === []) {
                $enTabs = trans('lum.villa.impression.tabs', [], 'en');
                $enTabs = is_array($enTabs) ? $enTabs : [];
            }
            if (! is_array($ruTabs) || $ruTabs === []) {
                $ruTabs = trans('lum.villa.impression.tabs', [], 'ru');
                $ruTabs = is_array($ruTabs) ? $ruTabs : [];
            }

            $slides = is_array($villa->impression_slides) && $villa->impression_slides !== []
                ? array_values(array_filter($villa->impression_slides, fn ($p) => is_string($p) && $p !== ''))
                : $defaultSlides;

            $count = max(count($enTabs), count($ruTabs), 1);
            $galleries = [];

            for ($i = 0; $i < $count; $i++) {
                $en = is_string($enTabs[$i] ?? null) ? $enTabs[$i] : (string) ($enTabs[0] ?? 'TAB');
                $ru = is_string($ruTabs[$i] ?? null) ? $ruTabs[$i] : (string) ($ruTabs[0] ?? $en);
                $galleries[] = [
                    'label' => ['en' => $en, 'ru' => $ru],
                    'images' => $slides,
                ];
            }

            $villa->forceFill(['impression_galleries' => $galleries])->save();
        });
    }

    public function down(): void
    {
        Schema::table('villas', function (Blueprint $table) {
            $table->dropColumn('impression_galleries');
        });
    }
};
