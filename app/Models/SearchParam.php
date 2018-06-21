<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchParam extends Model
{

    //不能批量赋值
    protected $guarded = ['id', 'level', 'name', 'param','p_id']; //这些字段禁止维护

    public $parentKey = 'p_id'; //必要字段              MySQL需加索引
    public $orderKey = 'order'; //无需此字段请设置NULL   MySQL需加索引
    public $levelKey = 'level'; //无需此字段请设置NULL   MySQL需加索引
    public $nameKey = 'name'; //无需此字段请设置NULL   MySQL需加索引
    public $paramKey = 'param'; //无需此字段请设置NULL   MySQL需加索引

    public function children()
    {
        $builder = $this->hasMany(get_class($this),$this->parentKey,$this->getKeyName());
        !empty($this->orderKey) && $builder->orderBy($this->orderKey, 'ASC');
        return $builder->select($this->nameKey,$this->paramKey,$this->parentKey);
    }

    public function parent()
    {
        return $this->hasOne(get_class($this), $this->getKeyName(), $this->parentKey);
    }

    /**
     * 得到search_params的数组
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getSearchParams()
    {
        $arr = $this->select($this->nameKey,$this->paramKey,$this->getKeyName())
            ->where($this->levelKey,'<',2);
        return !empty($this->orderBy) ? $arr -> get() :
            $arr->orderBy($this->orderKey, 'ASC')->get();
    }


    public function getParentKey()
    {
        return $this->{$this->parentKey};
    }
    public function getParentKeyName()
    {
        return $this->parentKey;
    }
    public function getOrderKey()
    {
        return $this->{$this->orderKey};
    }
    public function getOrderKeyName()
    {
        return $this->orderKey;
    }
    public function getLevelKey()
    {
        return $this->{$this->levelKey};
    }
    public function getLevelKeyName()
    {
        return $this->levelKey;
    }
    public function getNameKey()
    {
        return $this->{$this->nameKey};
    }
    public function getNameKeyName()
    {
        return $this->nameKey;
    }
    public function getParamKey()
    {
        return $this->{$this->paramKey};
    }
    public function getParamKeyName()
    {
        return $this->paramKey;
    }
}
