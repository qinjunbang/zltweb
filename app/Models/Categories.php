<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';


    public function products()
    {
        return $this->hasMany('App\Models\products','category_id');
    }


    public function images()
    {
        $builder = $this->morphMany('App\Models\Image', 'imageable');
        !empty($this->displayKey) && $builder->where($this->displayKey,1);
        !empty($this->orderKey) && $builder->orderBy($this->orderKey, 'DESC');
        return $builder->select('imageable_type','imageable_id','file');
    }


}
