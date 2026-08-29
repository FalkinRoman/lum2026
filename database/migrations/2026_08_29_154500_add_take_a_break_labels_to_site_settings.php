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
            $table->json('take_a_break_label')->nullable()->after('take_a_break_url');
            $table->json('take_a_break_label_mobile')->nullable()->after('take_a_break_label');
        });

        $defaults = [
            'take_a_break_label' => json_encode([
                'en' => 'take a break',
                'ru' => 'сделать паузу',
                'zh' => '稍作休息',
            ], JSON_UNESCAPED_UNICODE),
            'take_a_break_label_mobile' => json_encode([
                'en' => 'break',
                'ru' => 'пауза',
                'zh' => '小憩',
            ], JSON_UNESCAPED_UNICODE),
        ];

        DB::table('site_settings')->update($defaults);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['take_a_break_label', 'take_a_break_label_mobile']);
        });
    }
};
