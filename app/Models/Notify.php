<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    protected $fillable = ['type','title','content','image','description'];
    public $timestamps = true;
}
