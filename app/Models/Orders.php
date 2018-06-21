<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    protected $table = 'orders';
    protected $dates = ['deleted_at'];


    public function OrderProducts()
    {
        return $this->hasMany('App\Models\OederProducts','order_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\DeliveryAddress','delivery_address_id');
    }

}
