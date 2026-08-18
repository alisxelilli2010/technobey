<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 190);
            $table->string('slug', 190)->unique();
            $table->string('icon', 8)->nullable();          // emoji
            $table->string('cat', 40)->default('temir');    // temir | satis
            $table->string('image', 255)->nullable();
            $table->string('excerpt', 400)->nullable();
            $table->longText('body')->nullable();           // HTML
            $table->json('faq')->nullable();                // [{q, a}] — FAQPage schema üçün
            $table->string('meta_title', 190)->nullable();
            $table->string('meta_desc', 300)->nullable();
            $table->unsignedInteger('read_min')->default(4);
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['published', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
