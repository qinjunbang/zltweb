<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatOrder extends Model
{
    protected $fillable = [
        'appid',            //微信分配的公众账号ID
        'cash_fee',         //订单总金额，单位为分
        'total_fee',        //订单现金支付金额
        'result_code',      //业务结果SUCCESS/FAIL
        'transaction_id',   //微信支付订单号
        'out_trade_no',     //商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
        'attach',           //商家数据包，原样返回
        'bank_type',        //付款银行
        'fee_type',         //货币种类
        'is_subscribe',     //用户是否关注公众账号，Y-关注，N-未关注
        'mch_id',           //微信支付分配的商户号
        'nonce_str',        //随机字符串，不长于32位
        'openid',           //用户在商户appid下的唯一标识
        'time_end',         //支付完成时间
        'sign',             //签名
        'trade_type'        //交易类型JSAPI、NATIVE、APP
    ];

}
