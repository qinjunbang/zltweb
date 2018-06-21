<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class HomeService extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    protected $fillable = [
        'pid',
        'name',
        'password',
        'title',
        'province',
        'city',
        'area',
        'address',
        'mobile',
        'image',
        'title',
        'detail',
        'order',
        'is_show',
        'video',
        'balance',
        'hid',
        'act'
    ];
    protected $dates = ['delete_at'];

    public function images(){
        return $this->morphMany('App\Models\Image', 'imageable');
    }
    /**
     * 获取居家服务信息列表
     * @param $id
     * @return mixed
     */
    public function getHomeServiceLists($id) {

        return $this->where('type_id', $id)->orderBy('order', 'DESC');
    }
    public function getType()
    {
        return $this->belongsTo('App\Models\HomeServiceType','pid');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}
