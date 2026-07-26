<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->string('phone_href')->nullable();
            $table->string('email')->nullable();
            $table->string('map_url')->nullable();
            $table->string('whatsapp_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('telegram_url')->nullable();
            $table->string('take_a_break_url')->nullable();
            $table->string('book_url')->nullable();
            $table->json('address')->nullable();
            $table->json('hours')->nullable();
            $table->json('legal')->nullable();
            $table->json('footer_address')->nullable();
            $table->json('reviews')->nullable();
            $table->json('copyright')->nullable();
            $table->timestamps();
        });

        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->string('theme')->default('cream');
            $table->string('image')->nullable();
            $table->string('hero')->nullable();
            $table->json('title')->nullable();
            $table->json('excerpt')->nullable();
            $table->json('meta_title')->nullable();
            $table->json('tags')->nullable();
            $table->json('categories')->nullable();
            $table->json('body')->nullable();
            $table->timestamps();
        });

        Schema::create('villas', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->string('listing_image')->nullable();
            $table->string('slide_photo')->nullable();
            $table->string('slide_oval')->nullable();
            $table->string('hero_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->json('title_normal')->nullable();
            $table->json('title_italic')->nullable();
            $table->json('title_mobile_normal')->nullable();
            $table->json('title_mobile_italic')->nullable();
            $table->json('subtitle')->nullable();
            $table->json('subtitle_line1')->nullable();
            $table->json('subtitle_line2')->nullable();
            $table->json('meta_title')->nullable();
            $table->json('hero_eyebrow')->nullable();
            $table->json('hero_title_normal')->nullable();
            $table->json('hero_title_italic')->nullable();
            $table->json('gallery_eyebrow')->nullable();
            $table->json('gallery_title_normal')->nullable();
            $table->json('gallery_title_italic')->nullable();
            $table->json('gallery_body')->nullable();
            $table->json('gallery_body_bottom')->nullable();
            $table->json('facilities_left')->nullable();
            $table->json('facilities_right')->nullable();
            $table->timestamps();
        });

        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->boolean('opening_soon')->default(false);
            $table->string('listing_image')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('oval_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->json('eyebrow')->nullable();
            $table->json('subtitle')->nullable();
            $table->json('title_normal')->nullable();
            $table->json('title_italic')->nullable();
            $table->json('meta_title')->nullable();
            $table->json('hero_eyebrow')->nullable();
            $table->json('hero_title_normal')->nullable();
            $table->json('hero_title_italic')->nullable();
            $table->json('gallery_eyebrow')->nullable();
            $table->json('gallery_title_normal')->nullable();
            $table->json('gallery_title_italic')->nullable();
            $table->json('gallery_body')->nullable();
            $table->json('quote_line1')->nullable();
            $table->json('quote_line2')->nullable();
            $table->json('quote_note_line1')->nullable();
            $table->json('quote_note_line2')->nullable();
            $table->string('book_url')->nullable();
            $table->timestamps();
        });

        Schema::create('menu_categories', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->json('label')->nullable();
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_category_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('image')->nullable();
            $table->json('name')->nullable();
            $table->json('description')->nullable();
            $table->json('price')->nullable();
            $table->timestamps();
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->string('listing_image')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('oval_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->json('label_before')->nullable();
            $table->json('label_italic')->nullable();
            $table->json('label_after')->nullable();
            $table->json('name')->nullable();
            $table->json('meta_title')->nullable();
            $table->json('hero_eyebrow')->nullable();
            $table->json('hero_title_normal')->nullable();
            $table->json('hero_title_italic')->nullable();
            $table->json('gallery_eyebrow')->nullable();
            $table->json('gallery_title_normal')->nullable();
            $table->json('gallery_title_italic')->nullable();
            $table->json('gallery_body')->nullable();
            $table->json('quote_line1')->nullable();
            $table->json('quote_line2')->nullable();
            $table->json('quote_note')->nullable();
            $table->json('pricing_eyebrow')->nullable();
            $table->json('pricing_title_normal')->nullable();
            $table->json('pricing_title_italic')->nullable();
            $table->json('pricing_cta')->nullable();
            $table->string('pricing_cta_url')->nullable();
            $table->json('pricing_items')->nullable();
            $table->timestamps();
        });

        Schema::create('excursions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->string('listing_image')->nullable();
            $table->string('oval_image')->nullable();
            $table->string('wellness_hero')->nullable();
            $table->json('gallery_images')->nullable();
            $table->json('package_images')->nullable();
            $table->json('title')->nullable();
            $table->json('region')->nullable();
            $table->json('meta_title')->nullable();
            $table->json('intro_title')->nullable();
            $table->json('intro_body')->nullable();
            $table->json('gallery_eyebrow')->nullable();
            $table->json('gallery_title_normal')->nullable();
            $table->json('gallery_title_italic')->nullable();
            $table->json('polaroid_dates')->nullable();
            $table->json('package_eyebrow')->nullable();
            $table->json('package_title_normal')->nullable();
            $table->json('package_title_italic')->nullable();
            $table->json('package_items')->nullable();
            $table->json('package_cost')->nullable();
            $table->string('book_url')->nullable();
            $table->timestamps();
        });

        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('type')->default('tee');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->string('image')->nullable();
            $table->json('thumbs')->nullable();
            $table->json('colors')->nullable();
            $table->json('sizes')->nullable();
            $table->string('price')->nullable();
            $table->string('cta_label')->nullable();
            $table->json('title')->nullable();
            $table->json('subtitle')->nullable();
            $table->timestamps();
        });

        Schema::create('home_sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_sections');
        Schema::dropIfExists('shop_products');
        Schema::dropIfExists('excursions');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menu_categories');
        Schema::dropIfExists('restaurants');
        Schema::dropIfExists('villas');
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('site_settings');
    }
};
