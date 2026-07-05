<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name', 'position', 'text', 'avatar', 'rating', 'sort_order', 'published'];

    protected $casts = [
        'rating'    => 'integer',
        'published' => 'boolean',
    ];
}
