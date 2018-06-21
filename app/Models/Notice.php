<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'uid',
        'is_read',
        'title',
        'content',
    ];


}
