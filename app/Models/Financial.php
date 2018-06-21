<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{     
    public $table = 'financial';
	protected $fillable = ['name', 'type','mobile','user_id'];
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id')->select('id', 'name');
    }
}
