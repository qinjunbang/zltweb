<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

    protected $fillable = [
        'pid', 'uid', 'title', 'code', 'value', 'is_used'
    ];

}
