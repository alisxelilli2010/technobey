<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'name_en')) $table->dropColumn('name_en');
            if (Schema::hasColumn('products', 'name_ru')) $table->dropColumn('name_ru');
            if (Schema::hasColumn('products', 'desc_en')) $table->dropColumn('desc_en');
            if (Schema::hasColumn('products', 'desc_ru')) $table->dropColumn('desc_ru');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            if (Schema::hasColumn('testimonials', 'position_en')) $table->dropColumn('position_en');
            if (Schema::hasColumn('testimonials', 'position_ru')) $table->dropColumn('position_ru');
            if (Schema::hasColumn('testimonials', 'text_en'))     $table->dropColumn('text_en');
            if (Schema::hasColumn('testimonials', 'text_ru'))     $table->dropColumn('text_ru');
        });

        if (Schema::hasColumn('categories', 'name_az')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->renameColumn('name_az', 'name');
            });
        }

        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'name_en')) $table->dropColumn('name_en');
            if (Schema::hasColumn('categories', 'name_ru')) $table->dropColumn('name_ru');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name_en')->nullable();
            $table->string('name_ru')->nullable();
            $table->text('desc_en')->nullable();
            $table->text('desc_ru')->nullable();
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('position_en', 160)->nullable();
            $table->string('position_ru', 160)->nullable();
            $table->text('text_en')->nullable();
            $table->text('text_ru')->nullable();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->renameColumn('name', 'name_az');
            $table->string('name_en', 80)->nullable();
            $table->string('name_ru', 80)->nullable();
        });
    }
};
