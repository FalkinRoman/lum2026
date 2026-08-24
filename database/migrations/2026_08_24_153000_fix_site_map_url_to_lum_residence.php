<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const MAP_URL = 'https://maps.app.goo.gl/LahetBJYtE8oXsci8';

    public function up(): void
    {
        // Old seeder used a text query Google geocodes ~2km off Lum Residence.
        DB::table('site_settings')->update([
            'map_url' => self::MAP_URL,
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Intentionally no-op: do not restore the wrong geocode query.
    }
};
