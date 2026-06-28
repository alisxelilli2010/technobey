<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('cat', 40)->index();
            $table->string('price', 40);
            $table->string('unit', 20)->default('ədəd');
            $table->string('emoji', 16)->default('📦');
            $table->text('desc')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
