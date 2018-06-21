<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
class SystemCache extends Model
{

    /*
    |--------------------------------------------------------------------------
    | 缓存 model
    |--------------------------------------------------------------------------
    |
    | 这个模型里集合了设置所有系统参数缓存的方法
    |
    */

    /**
     * 获取检索条件
     *
     * @return mixed
     */
    public function getSearchParam() {
//        $this->forgetAllCache();
        if (!Cache::has('search_params')) {
            $this->setSearchParamsCache();
        }
        return Cache::get('search_params');
    }

    /**
     * 设置所有SystemCache
     *
     */
    public function setAllCache()
    {
        if (!Cache::has('search_params')) {
            $this->setSearchParamsCache();
        }
    }

    /**
     * 删除所有SystemCache
     *
     */
    public function forgetAllCache()
    {
        $this->forgetSearchParamsCache();
    }

    /**
     * 强制设置检索参数
     *
     */
    public function setSearchParamsCache()
    {
        $SearchParam = new SearchParam();
        Cache::forever('search_params', $SearchParam->getSearchParams()->toArray());
    }

    /**
     * 删除检索参数
     *
     */
    public function forgetSearchParamsCache()
    {
        if (Cache::has('search_params')) {
            Cache::forget('search_params');
        }
    }
}
