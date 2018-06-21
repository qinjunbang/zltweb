<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    public $table = 'travel';
    protected $fillable = ['title','province','city','area','district', 'name','mobile','pid','detail','min_price','max_price'];
}
