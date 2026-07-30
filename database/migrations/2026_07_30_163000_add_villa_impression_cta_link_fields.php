<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('villas', function (Blueprint $table) {
            $table->string('impression_cta_mode')->default('villa')->after('impression_cta');
            $table->string('impression_cta_url')->nullable()->after('impression_cta_mode');
        });
    }

    public function down(): void
    {
        Schema::table('villas', function (Blueprint $table) {
            $table->dropColumn(['impression_cta_mode', 'impression_cta_url']);
        });
    }
};
