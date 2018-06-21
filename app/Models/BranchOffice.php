<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchOffice extends Model
{
    protected $fillable = ['name', 'content', 'image', 'address', 'contact_number'];
    public $timestamps = true;

    /**
     * Get all of the BranchOffice's images.
     */
    public function images()
    {
        $builder = $this->morphMany('App\Models\Image', 'imageable');
        !empty($this->displayKey) && $builder->where($this->displayKey,1);
        !empty($this->orderKey) && $builder->orderBy($this->orderKey, 'DESC');
        return $builder->select('imageable_type','imageable_id','file');
    }
}
