<?php
namespace App\Repositories;

use App\Http\Requests\ManagerRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: cth
 */
class ManagerRepository
{
    private $post;
    private $get;
    private $page = 10;

    /**
     * 类外部获取管理员
     *
     * @param null $id
     *
     * @return array
     */
    public function getManager($id = NULL)
    {
        return !is_null($id) ? $this -> getOneManager($id) : $this -> getAllManager();
    }

    /**
     * 添加管理员
     *
     * @param $data
     * @return mixed
     */
    public function addManager($data)
    {
        return Admin::create($data);
    }

    /**
     * 修改管理员
     *
     * @param $data
     * @return bool
     */
    public function editManager($data)
    {
        //return Admin::where('id',$data['id'])->update(array_only($data,['title','content']));
    }

    /**
     * 通过id删除,可以传数组
     *
     * @param $id
     * @return int
     */
    public function delManager($id)
    {
        if(Auth::guard('admin')->user()->super == 1 && $id != 1) {
            return Admin::destroy($id);
        }else{
            return false;
        }
    }

    /**
     * 通过id获取单条管理员
     *
     * @param $id
     *
     * @return mixed
     */
    private function getOneManager($id)
    {
        return Admin::select('id','account','name')->findOrFail($id);
    }

    /**
     * 获取所有的管理
     *
     * @return array
     */
    private function getAllManager()
    {
        $builder = Admin::select('id','account','name','created_at')->orderBy('created_at','desc')->where('super',0);
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
            /*'uri' => ['edit' => url('admin/manager/edit'), 'del' => url('admin/manager/del')],*/
        ];
        if(Auth::guard('admin')->user()->super == 1){
            $builder = $builder + array( 'uri' => array('删除' => url('admin/manager/del'))) ;
        }
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