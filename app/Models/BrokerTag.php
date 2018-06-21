<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrokerTag extends Model
{
    protected $fillable = [
        'name', 'image', 'order', 'is_show'
    ];

}
