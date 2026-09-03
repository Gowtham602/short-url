<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UrlShortenerClick extends Model
{
    protected $fillable = [
        'url_shortener_id',
        'ip_address',
        'browser',
        'device_type',
        'country',
        'city',
    ];

    public function urlShortener(): BelongsTo
    {
        return $this->belongsTo(UrlShortener::class);
    }
}