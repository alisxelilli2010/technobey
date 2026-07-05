<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['slug', 'name_az', 'name_en', 'name_ru', 'icon', 'sort_order'];

    public function localizedName(string $locale): string
    {
        return match ($locale) {
            'en' => $this->name_en ?: $this->name_az,
            'ru' => $this->name_ru ?: $this->name_az,
            default => $this->name_az,
        };
    }
}
