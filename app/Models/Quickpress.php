<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quickpress extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User')->select('id', 'mobile', 'name');
    }

    public function court()
    {
        return $this->belongsTo('App\Models\Court')->select('id','province','city','area','name','pp');
    }
}
