<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    protected $fillable = ['province','city','area','name','pp','ave_price'];
    public $timestamps = true;

    public function secondApartments() {
        return $this->hasMany('App\Models\SecondApartment');
    }

    public function shops() {
        return $this->hasMany('App\Models\Shop');
    }

    public function businessTransfers() {
        return $this->hasMany('App\Models\BusinessTransfer');
    }
}
