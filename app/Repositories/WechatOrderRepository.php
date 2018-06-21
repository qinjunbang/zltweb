<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/6/29
 * Time: 上午8:53
 */

namespace App\Repositories;


use App\Models\WechatOrder;

class WechatOrderRepository {

    protected $wechatOrder;

    /**
     * WechatPayRepository constructor.
     * @param $wechatPay
     */
    public function __construct(WechatOrder $wechatOrder) {
        $this->wechatOrder = $wechatOrder;
    }

    /**
     * 创建微信支付回调订单
     * @param array $attributes
     */
    public function create(array $attributes){

        return $this->wechatOrder->create($attributes);
    }

    /**
     * 根据微信订单号查询订单是否已存在
     * @param $transactionId
     * @return bool
     */
    public function hasOrderWithTransactionId($transactionId) {

        return count($this->wechatOrder->where('transaction_id', $transactionId)->first())?true:false;
    }
}