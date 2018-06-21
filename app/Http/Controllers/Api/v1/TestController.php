<?php
//声明
namespace App\Http\Controllers\Api\v1;
//引用
use App\Http\Controllers\Controller;
use App\Repositories\AddressRepository;
//控制器类
class TestController extends Controller
{

   /* protected $addressRepository;*/
    /**
     * AddressController constructor.
     * @param $AddressRepository
     */
    //绑定生产者
    /*public function __construct(AddressRepository $addressRepository) {
        $this->addressRepository = $addressRepository;
    }*/
    /**
     * 获取所有省份信息
     * @return mixed
     */
    public function getProvince() {


    }
}
