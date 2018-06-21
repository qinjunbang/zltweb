<?php
//个人中心
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\Repository;
use Illuminate\Http\Request;
//use App\Repositories\AddressRepository;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{
    protected $addressRepository;
    /**
     * AddressController constructor.
     * @param $AddressRepository
     */
    public function __construct() {
//    public function __construct(AddressRepository $addressRepository) {
        $this->middleware('auth');
//        $this->addressRepository = $addressRepository;
    }
    /**
     * 获取用户信息
     * @return mixed
     */
    protected function user(Request $request){
        // 获取当前认证用户...
        $user = Auth::user();
        // 获取当前认证用户的ID
        //$id = Auth::id();
        return $user;
    }
    //as a buyer
    public function indexB(){
        return '视图';
    }
    public function address(){
         return '获取地址';
    }
    public function updateAdesses(){
         return '更新地址';
    }
    public function chooseAddress(){
         return "默认地址";
    }
    public function cash(){
         return "提现";
    }
    public function myCart(){
         return "购物车";
    }
    public function myCouponCard(){
         return "优惠卡";
    }
    public function myOrder(){
         return "我的订单";
    }
    public function Change(){
         return "5846321321";
    }
    //as a shoper
    public function indexS(){
         return "155";
    }




}




