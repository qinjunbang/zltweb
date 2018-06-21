<?php

namespace App\Http\Controllers\test;
use App\Http\Controllers\Controller;
//use App\Models\Address;
use App\Repositories\AddressRepository;

class TestController extends Controller
{
    protected $addressRepository;
    /**
     * AddressController constructor.
     * @param $AddressRepository
     */
    public function __construct(AddressRepository $addressRepository) {
        $this->addressRepository = $addressRepository;
    }
    /**
     * 获取所有省份信息
     * @return mixed
     */
    public function getProvince() {

        return $this->addressRepository->allProvince();

    }
}
