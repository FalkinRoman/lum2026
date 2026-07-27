<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->json('privacy_title')->nullable()->after('copyright');
            $table->json('privacy_body')->nullable()->after('privacy_title');
            $table->json('terms_title')->nullable()->after('privacy_body');
            $table->json('terms_body')->nullable()->after('terms_title');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['privacy_title', 'privacy_body', 'terms_title', 'terms_body']);
        });
    }
};
