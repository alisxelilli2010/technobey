<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'name_en', 'name_ru', 'cat', 'price', 'unit', 'stock', 'views', 'emoji', 'image', 'images', 'desc', 'desc_en', 'desc_ru'];

    protected $casts = [
        'images' => 'array',
        'stock'  => 'integer',
        'views'  => 'integer',
    ];
}
