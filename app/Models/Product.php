<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'cat', 'price', 'unit', 'stock', 'views', 'emoji', 'image', 'images', 'desc'];

    protected $casts = [
        'images' => 'array',
        'stock'  => 'integer',
        'views'  => 'integer',
    ];
}
