<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('villas', function (Blueprint $table) {
            $table->string('exely_hotel_id')->nullable()->after('is_published');
            $table->string('exely_room_type_id')->nullable()->after('exely_hotel_id');
        });
    }

    public function down(): void
    {
        Schema::table('villas', function (Blueprint $table) {
            $table->dropColumn(['exely_hotel_id', 'exely_room_type_id']);
        });
    }
};
