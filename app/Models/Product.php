<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'cat', 'price', 'unit', 'emoji', 'image', 'desc'];
}
