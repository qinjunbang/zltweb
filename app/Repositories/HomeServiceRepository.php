<?php
namespace App\Repositories;

use App\Models\HomeService;
use App\Models\HomeServiceType;

/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/5/28
 * Time: 下午2:05
 */
class HomeServiceRepository {

    /**
     * 根据居家服务类别获取居家服务信息列表
     * @param $id
     * @param $all
     * @param null $page
     * @return mixed
     */
    public function byPidWithHomeServiceList($id, $all, $page = null){
        $homeService = HomeService::where('pid', $id);

        !$all?$homeService = $homeService->where('is_show',1):'';
        $homeService = $homeService->orderBy('order', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->select('id', 'name', 'title', 'image', 'mobile', 'address', 'order', 'is_show', 'created_at');

        return is_null($page)?$homeService->get():$homeService->paginate($page);
    }

    /**
     * 根据id查询对应的居家服务信息
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function byIdWithHomeService($id) {

        return HomeService::with('images')->findOrFail($id);
    }

    public function delete($id) {
        return HomeService::destroy($id);
    }

    /**
     * 添加居家服务
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes){

        return HomeService::create($attributes);
    }

    /**
     * 模糊查找
     * @param array $attributes
     * @return mixed
     */
    public function select1($title){

        $homeService = HomeService::where('title','like','%'.$title.'%')->get();
        return $homeService;
    }
    public function select2($title){
        $homeService = HomeService::where('hid','0')->where('is_show','1')->where('title','like','%'.$title.'%')->get();
        return $homeService;
    }

    /**
     * 更新居家服务
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes, array $imgs=[]) {
        $homeService = HomeService::findOrFail($id);
        $data = $homeService->update($attributes);
        if($imgs != []){
            foreach ($imgs as $img){
                $homeService->images()->create(['file' => $img]);
            }
        }

        return $data;
    }
    /**
     * 判断是否为旅游商家
     * @param $id
     * @param array $attributes
     * @return mixed
     */




    public static function is_travel($id)
    {

        $data = HomeService::findOrFail($id);

        $is = HomeServiceType::where('id',$data->pid)->where('name','like','%旅游%')->first();
        if($is){
            return true;
        }
        return false;
    }
    public function setGood($id)
    {
        $count=HomeService::where('is_good','1')->count();
        if($count<3){
            return  HomeService::where('id',$id)->update(['is_good'=>'1']);
        }else{
            return false;
        }
    }
    public function setGood1($id)
    {
        return HomeService::where('id',$id)->update(['is_good'=>'0']);
    }
    public function getHomeServiceList($id)
    {
        return HomeService::where('pid',$id)->where('is_show','1');
    }
    public function getHomeServiceList1($id)
    {
        return HomeService::where('hid',$id)->where('is_show','1');
    }
}