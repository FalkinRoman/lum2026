<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** @var list<string> */
    private array $tables = [
        'blog_posts',
        'villas',
        'restaurants',
        'activities',
        'excursions',
        'shop_products',
        'menu_categories',
        'menu_items',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'sort_order')) {
                continue;
            }

            $min = DB::table($table)->min('sort_order');

            if ($min === null || (int) $min > 0) {
                continue;
            }

            DB::table($table)->update([
                'sort_order' => DB::raw('sort_order + 1'),
            ]);
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'sort_order')) {
                continue;
            }

            $min = DB::table($table)->min('sort_order');

            if ($min === null || (int) $min !== 1) {
                continue;
            }

            DB::table($table)->where('sort_order', '>', 0)->update([
                'sort_order' => DB::raw('sort_order - 1'),
            ]);
        }
    }
};
