<?php
namespace App\Repositories;

use App\Models\IndexServiceType;
use App\Models\HomeServiceType;
use App\Models\HomeService;

/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/5/28
 * Time: 下午2:05
 */
class IndexServiceRepository {

/**
     * 根据id查询居家服务分类
     * @param $id
     * @return mixed
     */
    public function byIdWithHomeServiceType($id) {

        return IndexServiceType::findOrFail($id);
    }
    
    public function getIndexServiceTypeList()
    {
        return IndexServiceType::select('id','name','is_show','created_at')->orderBy('created_at','desc');
    }
    public function getIndexServiceList()
    {
        return IndexServiceType::where('is_show','1')->select('id','name','is_show','title','image','created_at')->orderBy('created_at','desc');
    }       
    public function getIndexServiceTypeList1($id)
    {
        return HomeService::where('hid',$id)->select('id','name','is_show','image','created_at')->orderBy('created_at','desc');
    }
    public function getIndexServiceType1name($id)
    {
        return IndexServiceType::where('id',$id)->select('name')->first()->toArray();
    }
    public function getDetail($id)
    {
        return IndexServiceType::where('id',$id)->first()->toArray();
    }
    public function getHomeServiceList($id)
    {
        return HomeService::where('pid',$id);
    }
    /**
     * 添加居家服务
     * @param array $attributes
     * @return mixed
     */
    public function addSave($data){
        unset($data['_token']);
        return IndexServiceType::create($data);
    }

    public function update($id, array $attributes, array $imgs=[]) {
        $indexService = IndexServiceType::findOrFail($id);
        $data = $indexService->update($attributes);
        return $data;
    }

}