<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/6/22
 * Time: 下午1:26
 */

namespace App\Repositories;


use App\Models\Bill;

class BillRepository {

    /**
     * 获取用户收益收支详情
     * @param $uid
     * @param null $page
     * @return mixed
     */
    public function byUserIdWithBillList($uid, $page = null){
        $bill = Bill::where('uid', $uid)->orderBy('updated_at', 'DESC');

        return is_null($page)?$bill->get():$bill->paginate($page);
    }

    /**
     * 添加余额使用记录
     * @param array $attributes
     */
    public function create(array $attributes){

        return Bill::create($attributes);
    }


    /**
     * 获取后台添加数据
     * @param array $attributes
     */
    public function selbill(){

        return Bill::where('type', '系统后台')->Paginate(10);
    }
}