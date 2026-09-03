<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'district_id',
        'image_name',
        'original_url',
        'file_path',
        'short_code',
        'click_count',
    ];

    /*
    |--------------------------------------------------------------------------
    | User Relationship
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | District Relationship
    |--------------------------------------------------------------------------
    */

    public function district()
    {
        return $this->belongsTo(
            District::class,
            'district_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Click Analytics
    |--------------------------------------------------------------------------
    */

    public function clicks()
    {
        return $this->hasMany(
            ImageClick::class,
            'image_id'
        );
    }
}