<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    protected $fillable = [
        'uid',              //用户id
        'transaction_id',   //微信支付订单号
        'order_no',         //商家订单编号
        'paid',             //是否已付款
        'amount',           //订单总金额
        'openid'            //用户在商户appid下的唯一标识
    ];

}
