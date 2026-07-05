<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'service', 'notes', 'status', 'track_code'];

    public const STATUSES = ['new', 'processing', 'shipped', 'delivered', 'cancelled'];

    public const STATUS_LABELS = [
        'new'        => 'Yeni',
        'processing' => 'Hazırlanır',
        'shipped'    => 'Yoldadır',
        'delivered'  => 'Çatdırıldı',
        'cancelled'  => 'Ləğv edildi',
    ];

    public static function generateTrackCode(): string
    {
        do {
            $code = 'TB' . strtoupper(bin2hex(random_bytes(4))); // TB + 8 hex chars
        } while (self::where('track_code', $code)->exists());
        return $code;
    }
}
