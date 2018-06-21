<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OederProducts extends Model
{
    protected $table = 'order_products';


    public function order()
    {
        return $this->hasMany('App\Models\Orders','id');
    }

}
