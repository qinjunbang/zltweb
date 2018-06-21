<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/5/31
 * Time: 下午1:15
 */

namespace App\Repositories;

use App\Models\Financial; 
use App\Models\User;
use Auth;

class FinancialRepository {

    /**
     * 添加
     *
     * @array $data 数据
     * @array $arr 允许插入的数据
     * @return mixed
     */
    public function add($data) {
        $data['user_id']=Auth::user()->id;
        unset($data['_token']);
        return Financial::create($data);
    }

    public function getList($type) {
        return Financial::where('type',$type)->where('is_del','0')->select('id','name','mobile','created_at')->orderby('created_at','desc');
    }

    public function delete($id) {
        return Financial::where('id',$id)->update(['is_del'=>'1']);
    }

}