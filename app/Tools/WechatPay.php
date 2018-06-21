<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/6/26
 * Time: 下午8:41
 */

namespace App\Tools;

require_once app_path('Tools/WechatPay/lib/WxPay.Api.php');
require_once app_path('Tools/WechatPay/example/WxPay.JsApiPay.php');
require_once app_path('Tools/WechatPay/example/log.php');


class WechatPay {
    protected $payNotifyUrl;
    protected $agentWechatPay;
    protected $payRepository;
    /**
     * WechatPay constructor.
     */
    public function __construct($payRepository) {
        $this->payRepository = $payRepository;
        $this->payNotifyUrl = config('wechat.info.payNotifyUrl');
        $this->agentWechatPay = config('wechat.info.agentWechatPay');
    }

    /**
     * 统一下单
     * @return array
     */
    public function order($uid) {
        $logHandler= new \CLogFileHandler(storage_path('logs/'.date('Y-m-d').'.log'));
        $log = \Log::Init($logHandler, 15);

        $tools = new \JsApiPay();
        $openId = $tools->GetOpenid();

        $userPay = $this->payRepository->byUidWithNotPaid($uid);

        //dd($userPay);
        if(count($userPay) && $userPay->amount !=10000){
            $data = $userPay->toArray();
        }else{
            $data = [
                'uid' => $uid,  //用户id
                'order_no' => \WxPayConfig::MCHID.date("YmdHis"),   //商家订单编号
                'paid' => 0, //是否已付款
                'amount'=> $this->agentWechatPay,    //订单总金额
                'openid'=> $openId    //订单id
            ];
            $this->payRepository->create($data);
        }

        //②、统一下单
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("门门佳-成为经纪人付款");
        $input->SetAttach("门门佳-成为经纪人付款");
        $input->SetOut_trade_no($data['order_no']);
        $input->SetTotal_fee($data['amount']);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("无优惠");
        $input->SetNotify_url($this->payNotifyUrl);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);

        $order = \WxPayApi::unifiedOrder($input);

        $jsApiParameters = $tools->GetJsApiParameters($order);

        //获取共享收货地址js函数参数
        $editAddress = $tools->GetEditAddressParameters();

        return [
            'jsApiParameters' => $jsApiParameters,
            'editAddress' => $editAddress
        ];
    }
}