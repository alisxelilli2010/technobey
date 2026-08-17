<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'cat', 'price', 'unit', 'stock', 'views', 'emoji', 'image', 'images', 'desc'];

    protected $casts = [
        'images' => 'array',
        'stock'  => 'integer',
        'views'  => 'integer',
    ];

    /** URL-lərdə id yerinə slug istifadə olunur: /mehsul/{slug} */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        // Məhsul yaradılanda/adı dəyişəndə slug avtomatik qurulur —
        // beləcə yeni məhsul dərhal öz səhifəsini və sitemap sətrini alır.
        static::saving(function (Product $p) {
            if (empty($p->slug) || $p->isDirty('name')) {
                $p->slug = self::makeSlug($p->name, $p->id);
            }
        });
    }

    /** Azərbaycan hərflərini nəzərə alan, təkrarlanmayan slug qaytarır. */
    public static function makeSlug(?string $name, ?int $ignoreId = null): string
    {
        $az = ['ə' => 'e', 'Ə' => 'e', 'ı' => 'i', 'İ' => 'i', 'ö' => 'o', 'Ö' => 'o',
               'ü' => 'u', 'Ü' => 'u', 'ğ' => 'g', 'Ğ' => 'g', 'ş' => 's', 'Ş' => 's',
               'ç' => 'c', 'Ç' => 'c'];
        $base = Str::slug(strtr((string) $name, $az));
        if ($base === '') {
            $base = 'mehsul';
        }
        $base = Str::limit($base, 170, '');

        $slug = $base;
        $i = 2;
        while (self::slugTaken($slug, $ignoreId)) {
            $slug = $base . '-' . $i;
            $i++;
        }
        return $slug;
    }

    private static function slugTaken(string $slug, ?int $ignoreId): bool
    {
        return self::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists();
    }
}
