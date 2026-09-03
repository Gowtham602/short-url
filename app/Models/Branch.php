<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [

        'branch_name',

        'branch_code',

        'status'

    ];

    public function smsCredits()
    {
        return $this->hasMany(SmsCredit::class);
    }
}