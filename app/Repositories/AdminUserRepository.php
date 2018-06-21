<?php
/**
 * Created by PhpStorm.
 * User: cth
 * Date: 2017/6/13
 * Time: 上午10:13
 */

namespace App\Repositories;

use Auth;
use App\Models\User;

class AdminUserRepository {

    private $post;
    private $get;
    private $page = 10;

    /**
     * 类外部获取用户
     *
     * @param null $id
     *
     * @return array
     */
    public function getUser($id = NULL)
    {
        return !is_null($id) ? $this -> getOneUser($id) : $this -> getAllUser();
    }

    /**
     * 添加用户
     *
     * @param $data
     * @return mixed
     */
    public function addUser($data)
    {
        return User::create($data);
    }

    /**
     * 修改用户
     *
     * @param $data
     * @return bool
     */
    public function editUser($data)
    {
        return User::where('id',$data['id'])->update(array_only($data,['mobile','name','id_card','password']));
    }

    /**
     * 通过id删除,可以传数组
     *
     * @param $id
     * @return int
     */
    public function delUser($id)
    {

        return User::destroy($id);
    }

    /**
     * 通过mobile和type获得user
     *
     * @param $mobile
     * @param string $type
     * @return mixed
     */
    public function getUserByMobile($mobile,$type = 'user') {
        $user = User::where('mobile',$mobile);
        ($type == 'agent') && $user -> where('is_agent', 1);
        return $user->get()->first();
    }

    /**
     * 通过id获取单条用户
     *
     * @param $id
     *
     * @return mixed
     */
    private function getOneUser($id)
    {
        return User::select('id','mobile','name','id_card')->findOrFail($id);
    }

    /**
     * 获取所有的管理
     *
     * @return array
     */
    private function getAllUser()
    {
        $builder = User::select('id','mobile','name','id_card','created_at')->orderBy('created_at','desc');

        !empty($_GET['param']) && $builder = $this->setParam($builder,$_GET['param']);

        $num = $builder->get()->toArray();
        !empty($this->page) && $builder = $this->returnDataAndPage($builder->paginate($this->page));
        $builder['total'] = count($num);


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
        ];
        if(Auth::guard('admin')->user()->super == 1){
            $builder = $builder + array('uri' => [/*'编辑' => url('admin/user/edit'),*/ '删除' => url('admin/user/del')]);
        }else{
            $builder = $builder + array('uri' => [/*'编辑' => url('admin/user/edit'),*/ '无' => '']);
        }
        return $builder;
    }

    
}