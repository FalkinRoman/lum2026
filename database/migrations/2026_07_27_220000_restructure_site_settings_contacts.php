<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('phone_personal')->nullable()->after('phone_href');
            $table->string('phone_personal_href')->nullable()->after('phone_personal');
            $table->boolean('use_booking_page')->default(true)->after('book_url');
        });

        // Seed personal phone from existing legal "Phone" rows when present.
        $settings = DB::table('site_settings')->first();

        if ($settings && empty($settings->phone_personal) && ! empty($settings->legal)) {
            $legal = json_decode($settings->legal, true);

            foreach (['en', 'ru'] as $locale) {
                foreach ($legal[$locale] ?? [] as $row) {
                    $label = mb_strtolower((string) ($row['label'] ?? ''));

                    if (in_array($label, ['phone', 'телефон'], true) && ! empty($row['value'])) {
                        DB::table('site_settings')->where('id', $settings->id)->update([
                            'phone_personal' => $row['value'],
                            'phone_personal_href' => 'tel:'.preg_replace('/[^\d+]/', '', $row['value']),
                        ]);
                        break 2;
                    }
                }
            }
        }
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['phone_personal', 'phone_personal_href', 'use_booking_page']);
        });
    }
};
