<?php
//首页
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\ShopRepository;

class IndexController extends Controller
{
    protected $shopRepository;
    /**
     * @param $shopRepository
     */
    public function __construct(ShopRepository $shopRepository) {
        $this->shopRepository = $shopRepository;
    }
    /**
     * 获取所有商家信息
     * @return all
     */
    public function index(){
        //return $this->shopRepository->getAllShop();
        //获取轮播
        //获取推广商家
        //获取优惠商家
        //获取距离最近商家
        //商家分页

    }

    public function ShopIndex(){
        //return $this->shopRepository->getAllShop();
        //获取具体商家信息
    }

}
