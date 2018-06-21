<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'uid', 'order_id', 'balance', 'content', 'type'
    ];

}
