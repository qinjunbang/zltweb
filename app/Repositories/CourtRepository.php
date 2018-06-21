<?php
namespace App\Repositories;

use App\Http\Requests\CourtRequest;
use App\Models\Court;

/**
 * Created by PhpStorm.
 * User: cth
 */
class CourtRepository
{
    private $post;
    private $get;
    private $page = 10;

    /**
     * 类外部获取小区
     *
     * @param null $id
     *
     * @return array
     */
    public function getCourt($id = NULL)
    {
        return !is_null($id) ? $this -> getOneCourt($id) : $this -> getAllCourt();
    }

    /**
     * 添加小区
     *
     * @param $data
     * @return mixed
     */
    public function addCourt($data)
    {
        return Court::create($data);
    }

    /**
     * 修改小区
     *
     * @param $data
     * @return bool
     */
    public function editCourt($data)
    {
        return Court::where('id',$data['id'])->update(array_only($data,['province','city', 'area', 'ave_price']));
    }

    /**
     * 通过id删除,可以传数组
     *
     * @param $id
     * @return int
     */
    public function delCourt($id)
    {
        return Court::destroy($id);
    }

    public function select2($q) {
        $employees = Court::select(['id', 'province', 'city', 'area', 'name', 'ave_price'])
            ->where('name', 'like', '%' . $q . '%')
            ->get();
        return $employees;
    }

    /**
     * 通过id获取单条小区
     *
     * @param $id
     *
     * @return mixed
     */
    private function getOneCourt($id)
    {
        return Court::select('id','province','city','area','name','pp','ave_price')->findOrFail($id);
    }

    /**
     * 通过id获取单条小区
     *
     * @param $id
     *
     * @return mixed
     */
    private function getone($id)
    {
        return Court::select('id','province','city','area','name','pp','ave_price')->findOrFail($id);
    }

    /**
     * 获取所有的小区
     *
     * @return array
     */
    private function getAllCourt()
    {
        $builder = Court::select('id','province','city','area','name','ave_price')
            ->orderBy('created_at','desc');
        !empty($_GET['param']) && $builder = $this->setParam($builder,$_GET['param']);
        !empty($this->page) && $builder = $this->returnDataAndPage($builder->paginate($this->page));
        return $builder;
    }

    /**
     * 设置检索的参数 返回一个object对象
     *
     * @param $obj
     * @param $param
     * @return mixed
     */
    private function setParam($obj,$param) {
        foreach($param as $k => $v){
            $obj = $obj -> where("{$k}",'like','%'.$v.'%');
        }
        return $obj;
    }
    
    /**
     * 输入分页后的object,返回一个array,包含分页后的数据和一个page页
     *
     * @param $obj
     *
     * @return array
     */
    private function returnDataAndPage($obj) {
        $arr = $obj -> toArray();
        $builder = [
            'data' => empty($arr['data']) ? [] : $arr['data'],
            'page' => "{$obj->links('vendor.pagination.bootstrap-4')}",
            'uri' => ['修改' => url('admin/court/edit')],
        ];
        return $builder;
    }





    public function setPostParam($post)
    {
        $this -> post = $post;
    }

    public function getPostParam()
    {
        return $this -> post;
    }

    public function setGetParam($get)
    {
        $this -> get = $get;
    }

    public function getGetParam()
    {
        return $this -> get;
    }
}