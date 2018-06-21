<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkshopLand extends Model
{
    public $timestamps = true;  //使用create_at和update_at字段
    protected $guarded = ['id'];    //受保护的字段-这个字段不可写入

    public $orderKey = 'order'; //无需此字段请设置NULL   MySQL需加索引
    public $displayKey = 'display'; //无需此字段请设置NULL   MySQL需加索引

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

    public function favorites()
    {
        return $this->morphMany('App\Models\Favorite', 'favorable');
    }

    public function court()
    {
        return $this->belongsTo('App\Models\Court')->select('id','province','city','area','name','pp');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User')->select('id', 'mobile', 'name','is_agent');
    }

    public function agent()
    {
        return $this->belongsTo('App\Models\User','agent_id')->select('id', 'mobile', 'name');
    }

    public function userBeAppointed() {
        return $this->morphToMany('App\Models\User', 'appointmentable', 'appointments');
    }
}
