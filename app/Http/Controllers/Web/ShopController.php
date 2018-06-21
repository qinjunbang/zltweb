<?php
//我的商铺
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\AddressRepository;

class ShopController extends Controller
{

    protected $addressRepository;

    public function __construct(AddressRepository $addressRepository) {
        $this->addressRepository = $addressRepository;
    }

    public function buildShop(){

        return "新建商铺";

    }

    public function updateShop(){

        return "修改商铺";

    }

    public function showAllShop(){

        return "我的全部商铺";
    }

    public function  showOneshop(){

        return  "某店铺";
    }






}
