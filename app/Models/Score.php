<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'uid', 'order_id', 'score', 'content', 'type'
    ];
}
