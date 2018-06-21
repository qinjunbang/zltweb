<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/6/28
 * Time: 下午3:44
 */

namespace App\Tools;

require_once app_path('Tools/WechatPay/lib/WxPay.Api.php');
require_once app_path('Tools/WechatPay/lib/WxPay.Notify.php');
require_once app_path('Tools/WechatPay/example/log.php');

class WechatPayNotify extends \WxPayNotify {

    protected $wechatOrder;
    protected $pay;
    protected $user;
    protected $notice;

    /**
     * WechatPayNotify constructor.
     */
    public function __construct($wechatOrder, $pay, $user, $notice) {
        $this->wechatOrder = $wechatOrder;
        $this->pay = $pay;
        $this->user = $user;
        $this->notice = $notice;

        ini_set('date.timezone','Asia/Shanghai');
        error_reporting(E_ERROR);
        $logHandler= new \CLogFileHandler(storage_path('logs/'.date('Y-m-d').'.log'));
        $log = \Log::Init($logHandler, 15);
    }

    //查询订单
    public function Queryorder($transaction_id)
    {
        $input = new \WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = \WxPayApi::orderQuery($input);
        \Log::DEBUG("query:" . json_encode($result));
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return true;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg)
    {
        \Log::DEBUG("call back:" . json_encode($data));
        $notfiyOutput = array();

        if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";
            return false;
        }
        //查询订单，判断订单真实性
        if(!$this->Queryorder($data["transaction_id"])){
            $msg = "订单查询失败";
            return false;
        }
        if(!$this->wechatOrder->hasOrderWithTransactionId($data['transaction_id'])){
            $this->wechatOrder->create($data);
            $uid = $this->pay->byOrderNoSetPaidTrue($data['out_trade_no'], $data['transaction_id']);
            if($uid){
                $this->user->byIdSetUserAgentTrue($uid);
                $this->notice->create([
                    'uid' => $uid,
                    'title' => '恭喜您成为门门佳经纪人',
                    'content' => '您已成功开通门门佳经纪人权限！',
                ]);
            }
        }
        return true;
    }
}