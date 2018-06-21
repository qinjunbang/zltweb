<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/5/28
 * Time: 下午4:07
 */

namespace App\Repositories;


use App\Models\HomeService;
use App\Models\HomeServiceType;

class HomeServiceTypeRepository {

    /**
     * 居家服务分类列表
     * @param $page
     * @return mixed
     */
    public function getHomeServiceTypeList($all, $page = null) {
        $homeServiceType = new HomeServiceType();
        !$all?$homeServiceType = $homeServiceType->where('is_show', true):'';
        $homeServiceType = $homeServiceType->orderBy('order','DESC')
            ->orderBy('created_at','DESC');

        return is_null($page)?$homeServiceType->get():$homeServiceType->paginate($page);
    }

    /**
     * 根据id查询居家服务分类
     * @param $id
     * @return mixed
     */
    public function byIdWithHomeServiceType($id) {

        return HomeServiceType::findOrFail($id);
    }

    /**
     * 根据id查询居家服务分类
     * @param $id
     * @return mixed
     */
    public function byIdWithHomeServiceTypes($id) {

        return HomeService::findOrFail($id)->hid;
    }

    /**
     * 添加居家服务分类
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes){

        return HomeServiceType::create($attributes);
    }

    /**
     * 更新居家服务分类
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes) {
        $homeServiceType = HomeServiceType::findOrFail($id);

        return $homeServiceType->update($attributes);
    }
    public function allList()
    {
        return HomeServiceType::where('is_show','1')->get();
    }
}