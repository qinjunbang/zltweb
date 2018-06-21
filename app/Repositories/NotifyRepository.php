<?php
namespace App\Repositories;

use App\Http\Requests\NotifyRequest;
use App\Models\Notify;

/**
 * Created by PhpStorm.
 * User: cth
 */
class NotifyRepository
{
    private $post;
    private $get;
    private $page = 10;

    /**
     * @return int
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage($page) {
        $this->page = $page;
    }

    /**
     * 类外部获取通知
     *
     * @param null $id
     *
     * @return array
     */
    public function getNotify($id = NULL)
    {
        return !is_null($id) ? $this -> getOneNotify($id) : $this -> getAllNotify();
    }

    /**
     * 获取标题通知
     * @param $title
     * @return mixed
     */
    public function getTitleInNotify() {

        return Notify::select('title')->where('type','1')->OrderBy('created_at', 'DESC')->get(10);
    }

    /**
     *
     * @return mixed
     */
    public function getNotifyWithTen($type) {
        return Notify::where('type',$type)->OrderBy('created_at', 'DESC')->get();
    }

    /**
     * 添加通知
     *
     * @param $data
     * @return mixed
     */
    public function addNotify($data)
    {
        return Notify::create($data);
    }

    /**
     * 修改通知
     *
     * @param $data
     * @return bool
     */
    public function editNotify($data)
    {
        return Notify::where('id',$data['id'])->update(array_only($data,['type','title', 'image', 'content', 'description']));
    }

    /**
     * 通过id删除,可以传数组
     *
     * @param $id
     * @return int
     */
    public function delNotify($id)
    {
        return Notify::destroy($id);
    }

    /**
     * 通过id获取单条通知
     *
     * @param $id
     *
     * @return mixed
     */
    private function getOneNotify($id)
    {
        return Notify::select('id','title','image', 'content', 'description')->findOrFail($id);
    }

    /**
     * 获取所有的通知
     *
     * @return array
     */
    private function getAllNotify()
    {
        $builder = Notify::select('id','title','type','created_at')->orderBy('created_at','desc');
        !empty($_GET['param']) && $builder = $this->setParam($builder,$_GET['param']);
        !empty($this->page) && $builder = $this->returnDataAndPage($builder->paginate($this->page));
        return is_null($this->page)?$builder->get():$builder;
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
            'uri' => ['修改' => url('admin/notify/edit'), '删除' => url('admin/notify/del')],
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