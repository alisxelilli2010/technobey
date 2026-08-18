<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'icon', 'cat', 'image', 'excerpt', 'body', 'faq',
        'meta_title', 'meta_desc', 'read_min', 'views', 'sort_order',
        'published', 'published_at',
    ];

    protected $casts = [
        'faq'          => 'array',
        'published'    => 'boolean',
        'published_at' => 'datetime',
        'views'        => 'integer',
        'read_min'     => 'integer',
        'sort_order'   => 'integer',
    ];

    /** Kateqoriya açarları -> göstərilən ad */
    public const CATS = [
        'temir' => 'Təmir və servis',
        'satis' => 'Seçim və alış',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeLive(Builder $q): Builder
    {
        return $q->where('published', true)
            ->where(fn ($w) => $w->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function getCatNameAttribute(): string
    {
        return self::CATS[$this->cat] ?? $this->cat;
    }

    protected static function booted(): void
    {
        static::saving(function (Post $p) {
            // Slug yalnız boş olduqda qurulur. Başlıq dəyişəndə slug-a toxunmuruq:
            // dərc olunmuş URL indeksdədir və dəyişməsi keçidləri sındırır.
            if (empty($p->slug)) {
                $p->slug = self::makeSlug($p->title, $p->id);
            }
            if (empty($p->published_at) && $p->published) {
                $p->published_at = now();
            }
            // Oxuma müddəti mətnin uzunluğundan hesablanır (~200 söz/dəq)
            if ($p->isDirty('body') || empty($p->read_min)) {
                $words = str_word_count(strip_tags((string) $p->body));
                $p->read_min = max(2, (int) ceil($words / 200));
            }
        });
    }

    public static function makeSlug(?string $title, ?int $ignoreId = null): string
    {
        $az = ['ə' => 'e', 'Ə' => 'e', 'ı' => 'i', 'İ' => 'i', 'ö' => 'o', 'Ö' => 'o',
               'ü' => 'u', 'Ü' => 'u', 'ğ' => 'g', 'Ğ' => 'g', 'ş' => 's', 'Ş' => 's',
               'ç' => 'c', 'Ç' => 'c'];
        $base = Str::limit(Str::slug(strtr((string) $title, $az)) ?: 'bloq', 170, '');

        $slug = $base;
        $i = 2;
        while (self::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
