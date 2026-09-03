<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\District;

class UrlShortener extends Model
{
    protected $fillable = [
        'user_id',
        'district_id',
        'original_url',
        'short_code',
        'click_count',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}