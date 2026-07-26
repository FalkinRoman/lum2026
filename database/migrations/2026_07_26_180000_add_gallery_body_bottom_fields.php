<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->json('gallery_body_bottom')->nullable()->after('gallery_body');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->json('gallery_body_bottom')->nullable()->after('gallery_body');
        });

        Schema::table('excursions', function (Blueprint $table) {
            $table->json('gallery_body')->nullable()->after('gallery_title_italic');
            $table->json('gallery_body_bottom')->nullable()->after('gallery_body');
        });
    }

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('gallery_body_bottom');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('gallery_body_bottom');
        });

        Schema::table('excursions', function (Blueprint $table) {
            $table->dropColumn(['gallery_body', 'gallery_body_bottom']);
        });
    }
};
