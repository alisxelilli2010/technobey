<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name_en', 200)->nullable()->after('name');
            $table->string('name_ru', 200)->nullable()->after('name_en');
            $table->text('desc_en')->nullable()->after('desc');
            $table->text('desc_ru')->nullable()->after('desc_en');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->text('text_en')->nullable()->after('text');
            $table->text('text_ru')->nullable()->after('text_en');
            $table->string('position_en', 160)->nullable()->after('position');
            $table->string('position_ru', 160)->nullable()->after('position_en');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'name_ru', 'desc_en', 'desc_ru']);
        });
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['text_en', 'text_ru', 'position_en', 'position_ru']);
        });
    }
};
