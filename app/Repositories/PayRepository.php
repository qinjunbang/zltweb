<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/6/28
 * Time: 下午11:50
 */

namespace App\Repositories;


use App\Models\Pay;

class PayRepository {

    protected $pay;

    /**
     * PayRepository constructor.
     */
    public function __construct(Pay $pay) {
        $this->pay = $pay;
    }


    /**
     * 创建支付订单
     * @param array $attributes
     */
    public function create(array $attributes){

        return $this->pay->create($attributes);
    }

    /**
     * 根据微信的openid 查询是否已有该条记录
     * @param $openid
     * @return bool
     */
    public function hasOpenidNote($openid) {

        return count($this->pay->where('openid',$openid)->first())?true:false;
    }

    /**
     * 根据用户ID查询未付款订单
     * @param $uid
     * @return mixed
     */
    public function byUidWithNotPaid($uid) {

        return $this->pay->where('uid',$uid)->where('paid', 0)->first();
    }

    /**
     * 根据订单号设置支付为成功
     * @param $orderNo
     * @return mixed
     */
    public function byOrderNoSetPaidTrue($orderNo, $transactionId){
        $res = false;
        $pay = $this->pay->where('order_no', $orderNo)->first();
        if($pay){
            $pay->transaction_id = $transactionId;
            $pay->paid = 1;
            $pay->save();
            $res = $pay->uid;
        }

        return $res;
    }
}