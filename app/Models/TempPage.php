<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempPage extends Model
{
    use HasFactory;
     protected $fillable = [
        'session_id',
        'image_path',
        'sort_order'
    ];
}
