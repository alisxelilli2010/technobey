<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name', 'position', 'position_en', 'position_ru', 'text', 'text_en', 'text_ru', 'avatar', 'rating', 'sort_order', 'published'];

    protected $casts = [
        'rating'    => 'integer',
        'published' => 'boolean',
    ];
}
