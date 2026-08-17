<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug', 190)->nullable()->unique()->after('name');
        });

        // Mövcud məhsullara slug yaz
        Product::whereNull('slug')->orWhere('slug', '')->get()->each(function (Product $p) {
            $p->slug = Product::makeSlug($p->name, $p->id);
            $p->saveQuietly();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
