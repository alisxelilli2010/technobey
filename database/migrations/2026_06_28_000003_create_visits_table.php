<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->string('path', 191)->nullable();
            $table->timestamps();
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
