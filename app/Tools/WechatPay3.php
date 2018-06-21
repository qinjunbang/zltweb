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


class WechatPay3 {

    protected $payNotifyUrl;
    protected $agentWechatPay;
    protected $payRepository;

    /**
     * WechatPay constructor.
     */
    public function __construct($payRepository,$money) {
        $this->payRepository = $payRepository;
        $this->payNotifyUrl = "http://www.menmenjia.com/mobile/wechat/pay";
        $this->agentWechatPay = floor($money*100);
    }

    /**
     * 统一下单
     * @return array
     */
    public function order($uid,$num) {
        $logHandler= new \CLogFileHandler(storage_path('logs/'.date('Y-m-d').'.log'));
        $log = \Log::Init($logHandler, 15);

        $tools = new \JsApiPay();
        $openId = $tools->GetOpenid();

        //②、统一下单
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("门门佳-成为经纪人付款");
        $input->SetAttach("门门佳-成为经纪人付款");
        $input->SetOut_trade_no($num);
        $input->SetTotal_fee( $this->agentWechatPay);
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