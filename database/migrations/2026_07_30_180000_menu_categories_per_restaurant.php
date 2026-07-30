<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('menu_categories', 'restaurant_id')) {
            Schema::table('menu_categories', function (Blueprint $table) {
                $table->foreignId('restaurant_id')
                    ->nullable()
                    ->after('id')
                    ->constrained()
                    ->cascadeOnDelete();
            });
        }

        // Drop global unique on key (SQLite keeps name menu_categories_key_unique)
        $this->dropKeyUniqueIfExists();

        $this->copyGlobalMenusToRestaurants();

        DB::table('menu_categories')->whereNull('restaurant_id')->delete();

        Schema::table('menu_categories', function (Blueprint $table) {
            $table->foreignId('restaurant_id')->nullable(false)->change();
        });

        Schema::table('menu_categories', function (Blueprint $table) {
            $table->unique(['restaurant_id', 'key']);
        });
    }

    public function down(): void
    {
        Schema::table('menu_categories', function (Blueprint $table) {
            $table->dropUnique(['restaurant_id', 'key']);
        });

        Schema::table('menu_categories', function (Blueprint $table) {
            $table->dropConstrainedForeignId('restaurant_id');
            $table->unique('key');
        });
    }

    private function dropKeyUniqueIfExists(): void
    {
        try {
            Schema::table('menu_categories', function (Blueprint $table) {
                $table->dropUnique(['key']);
            });
        } catch (\Throwable) {
            // Already dropped or named differently
            try {
                DB::statement('DROP INDEX IF EXISTS menu_categories_key_unique');
            } catch (\Throwable) {
                // ignore
            }
        }
    }

    private function copyGlobalMenusToRestaurants(): void
    {
        $globals = DB::table('menu_categories')->whereNull('restaurant_id')->orderBy('sort_order')->get();
        if ($globals->isEmpty()) {
            return;
        }

        $restaurants = DB::table('restaurants')->orderBy('id')->get(['id']);
        if ($restaurants->isEmpty()) {
            return;
        }

        $now = now();

        foreach ($restaurants as $restaurant) {
            foreach ($globals as $category) {
                $exists = DB::table('menu_categories')
                    ->where('restaurant_id', $restaurant->id)
                    ->where('key', $category->key)
                    ->exists();
                if ($exists) {
                    continue;
                }

                $newCategoryId = DB::table('menu_categories')->insertGetId([
                    'restaurant_id' => $restaurant->id,
                    'key' => $category->key,
                    'sort_order' => $category->sort_order,
                    'label' => $category->label,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                $items = DB::table('menu_items')
                    ->where('menu_category_id', $category->id)
                    ->orderBy('sort_order')
                    ->get();

                foreach ($items as $item) {
                    DB::table('menu_items')->insert([
                        'menu_category_id' => $newCategoryId,
                        'sort_order' => $item->sort_order,
                        'image' => $item->image,
                        'name' => $item->name,
                        'description' => $item->description,
                        'price' => $item->price,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        }
    }
};
