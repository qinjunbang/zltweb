<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    //

    public function properties()
    {
        return $this->hasMany('App\Models\ProductProperties','product_id');
    }

    public function prices()
    {
        return $this->hasMany('App\Models\ProductPrices','product_id');
    }

    /**
     * Get all of the Apartment's images.
     */
    public function images()
    {
        $builder = $this->morphMany('App\Models\Image', 'imageable');
        !empty($this->displayKey) && $builder->where($this->displayKey,1);
        !empty($this->orderKey) && $builder->orderBy($this->orderKey, 'DESC');
        return $builder->select('imageable_type','imageable_id','file');
    }



}
