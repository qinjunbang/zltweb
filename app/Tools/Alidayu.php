<?php
namespace App\Tools;

include 'Alidayu/aliyun-php-sdk-core/Config.php';

use App\Tools\Alidayu\Dysmsapi\Request\V20170525\QuerySendDetailsRequest;
use App\Tools\Alidayu\Dysmsapi\Request\V20170525\SendSmsRequest;

class Alidayu{
    protected $accessKeyId;
    protected $accessKeySecret;
    protected $product = 'Dysmsapi';    //短信API产品名
    protected $domain = 'dysmsapi.aliyuncs.com';    //短信API产品域名
    protected $region = 'cn-hangzhou';  //暂时不支持多Region

    /**
     * Alidayu constructor.
     * @param $accessKeyId
     * @param $accessKeySecret
     * @param $product
     * @param $domain
     * @param $region
     */
    public function __construct() {
        $this->accessKeyId = config('alidayu.code.accessKeyId');
        $this->accessKeySecret = config('alidayu.code.accessKeySecret');
    }

    /**
     * 发送短信
     * @param $number 短信接收号码
     * @param $signName 短信签名
     * @param $templateCode 短信模板Code
     * @param $templateParam JSON格式模版内容
     * @return mixed
     */
    public function sendSms($number, $signName, $templateCode, $templateParam){
        //初始化访问的acsCleint
        $profile = \DefaultProfile::getProfile($this->region, $this->accessKeyId, $this->accessKeySecret);
        \DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $this->product, $this->domain);
        $acsClient= new \DefaultAcsClient($profile);

        $request = new SendSmsRequest();
        //必填-短信接收号码
        $request->setPhoneNumbers($number);
        //必填-短信签名
        $request->setSignName($signName);
        //必填-短信模板Code
        $request->setTemplateCode($templateCode);
        //选填-假如模板中存在变量需要替换则为必填(JSON格式)
        //$request->setTemplateParam("{\"code\":\"12345\",\"product\":\"阿里大于\"}");
        $request->setTemplateParam($templateParam);
        //选填-发送短信流水号
        //$request->setOutId("1234");

        //发起访问请求
        $acsResponse = $acsClient->getAcsResponse($request);
        return $acsResponse;
    }

    public function querySendDetails() {

        //此处需要替换成自己的AK信息
        $accessKeyId = "yourAccessKeyId";
        $accessKeySecret = "yourAccessKeySecret";
        //短信API产品名
        $product = "Dysmsapi";
        //短信API产品域名
        $domain = "dysmsapi.aliyuncs.com";
        //暂时不支持多Region
        $region = "cn-hangzhou";

        //初始化访问的acsCleint
        $profile = \DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
        \DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
        $acsClient= new \DefaultAcsClient($profile);

        $request = new QuerySendDetailsRequest();
        //必填-短信接收号码
        $request->setPhoneNumber("15000000000");
        //选填-短信发送流水号
        $request->setBizId("abcdefgh");
        //必填-短信发送日期，支持近30天记录查询，格式yyyyMMdd
        $request->setSendDate("20170525");
        //必填-分页大小
        $request->setPageSize(10);
        //必填-当前页码
        $request->setContent(1);

        //发起访问请求
        $acsResponse = $acsClient->getAcsResponse($request);
        var_dump($acsResponse);

    }
}