<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeServiceType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'color', 'image', 'order', 'is_show','pid'
    ];

    protected $dates = ['deleted_at'];
}
