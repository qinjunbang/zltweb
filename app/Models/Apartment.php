<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    public $timestamps = true;  //使用create_at和update_at字段
    protected $guarded = ['id'];    //受保护的字段-这个字段不可写入 上线需加上status

    public $orderKey = 'order'; //无需此字段请设置NULL   MySQL需加索引
    public $displayKey = 'display'; //无需此字段请设置NULL   MySQL需加索引
    public $type = NULL; //1st or 2nd , default is NULL
    public $saleOrRental = NULL; //sale or rental , default is NULL

    private $post; //post的参数 检索条件或者是数据写入

    /*public function __construct()
    {
        !empty($_POST) && $this -> post = $_POST;
    }*/
    /**
     * Get all of the Apartment's images.
     */
    public function images()
    {
        $builder = $this->morphMany('App\Models\Image', 'imageable');
        !empty($this->displayKey) && $builder->where($this->displayKey,1);
        !empty($this->orderKey) && $builder->orderBy($this->orderKey, 'DESC');
        return $builder->select('file');
    }

    /**
     * Get all of the Apartment's favorites.
     */
    public function favorites()
    {
        return $this->morphMany('App\Models\Favorite', 'favorable');
    }


    /**
     * 得到房源信息
     *
     * @param null $id
     * @return mixed
     */
    public function getApartment($id = NULL)
    {
        if(!empty($id)){
            return $this->getOne($id);
        }else{
            return $this->getAll();
        }
    }

    /**
     * 获取某一个id的apartment
     *
     * @param $id
     * @return mixed
     */
    private function getOne($id)
    {
        return $this -> select() -> find($id)->toArray();
    }


    /**
     * 获取所有的apartment
     *
     * @return mixed
     */
    private function getAll() {
        $builder = $this -> where('type', $this->type);
        (!empty($this->saleOrRental) and $this->type == '2nd') && $builder->where('sale_or_rental', $this->saleOrRental);
        !empty($this->post) && $builder = $this->setSearchParam($builder);
        return $builder->get()->toArray();
    }

    /**
     * 写入房源信息
     *
     * @return bool
     */
    public function insertApartment()
    {
        if(!empty($this->post)){
            $post = $this->post;
        }else{
            return false;
        }
    }

    /**
     * 设置检索参数
     *
     * @param $builder
     */
    private function setSearchParam($builder)
    {
        $search = $this->post;
        $config = config('');
    }

    /**
     * 设置类型
     *
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * 设置saleOrRental
     *
     */
    public function setSaleOrRental($saleOrRental)
    {
        $this->saleOrRental = $saleOrRental;
    }



    public function getOrderKey()
    {
        return $this->{$this->orderKey};
    }
    public function getOrderKeyName()
    {
        return $this->orderKey;
    }
    public function getDisplayKey()
    {
        return $this->{$this->displayKey};
    }
    public function getDisplayKeyName()
    {
        return $this->displayKey;
    }
}
