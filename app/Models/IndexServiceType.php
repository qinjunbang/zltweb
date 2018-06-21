<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndexServiceType extends Model
{
    public $table = 'index_service';
    protected $fillable = ['name','is_show','image','title'];
}
