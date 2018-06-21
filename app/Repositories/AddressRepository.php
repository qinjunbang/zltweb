<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/5/31
 * Time: 下午1:15
 */

namespace App\Repositories;


use App\Models\Address;
use Illuminate\Support\Facades\Cache;

class AddressRepository {

    /**
     * 获取所有的省份
     * @return mixed
     */
    public function allProvince() {

        return Address::where('level',0)->get();
    }

    /**
     * 根据省份获取城市
     * @param $pid
     * @return mixed
     */
    public function byPidWithCity($pid) {

        return Address::where('parentid', $pid)->where('level', 1)->get();
    }

    /**
     * 根据城市获取区域
     * @param $pid
     * @return mixed
     */
    public function byPidWithArea($pid){

        return Address::where('parentid', $pid)->where('level', 2)->get();
    }


    /**
     * 根据城市获取街道
     * @param $pid
     * @return mixed
     */
    public function byPidWithStreet($pid){

        return Address::where('parentid', $pid)->where('level', 4)->get();
    }



    /**
     * 根据id获取地址名
     * @param $attributes
     * @return mixed
     */
    public function byIdWidthZoneName($attributes){
        if(is_array($attributes)){
            $data = null;
            $addresses = Address::whereIn('id', $attributes)->get()->toArray();
            foreach ($addresses as $address){
                $data .= $address['zonename'];
            }
            return $data;
        }
        return Address::findOrFail($attributes)->zonename;
    }


    /**
     * 根据id获取地址名
     * @param $attributes
     * @return mixed
     */
    public function byparentidWidthdata($area){
            $addresses = Address::where('id', $area)->get()->toArray();
            return $addresses;
    }



    /**
     * 得到默认的地址(浙江省-宁波市)
     *
     * @return mixed
     */
    public function getDefaultAddress()
    {

        //$value = Cache::rememberForever('default_address', function() {
            $data['province'] = $this->allProvince()->toArray();
            $data['city'] = $this->byPidWithCity('330000')->toArray();
            $data['area'] = $this->byPidWithArea('330200')->toArray();
            $data['street_address'] = $this->byPidWithStreet('330206')->toArray();
            return $data;
        //});

       // return $value;
    }

    public function getAllProvince()
    {
        $data['province'] = $this->allProvince()->toArray();
        return $data;
    }
    public function getActiveCitys($id) {
        $data = $this->byPidWithCity($id)->toArray();
        return $data;
    }
    public function getActiveArea($id) {
        $data = $this->byPidWithArea($id)->toArray();
        return $data;  
    }
    /**
     * 通过省份城市id获取整个address数组
     *
     * @param $province
     * @param $city
     * @param $area
     * @return array
     */
    public function getAddress($province, $city , $area ,$street_address) {
       // $value = Cache::rememberForever('address_array_'.$area, function() use($province, $city) {
            $data['province'] = $this->allProvince()->toArray();
            $data['city'] = $this->byPidWithCity($province)->toArray();
            $data['area'] = $this->byPidWithArea($city)->toArray();
            $data['street_address'] = $this->byPidWithStreet($area)->toArray();
            return $data;
       // });
      //  return $value;
    }

    /**
     * 把address id 替换成 zonename
     *
     * @param $builder
     * @return mixed
     */
    public function replaceAddress($builder)
    {
        if($builder['area']) {
            //dd($builder['province']);
            //Cache::forget('address_'.$builder['area']);
            $value = Cache::rememberForever('address_' . $builder['area'], function () use ($builder) {
                $data['province'] = $this->byIdWidthZoneName($builder['province']);
                $data['city'] = $this->byIdWidthZoneName($builder['city']);
                $data['area'] = $this->byIdWidthZoneName($builder['area']);

                return $data;
            });
            $builder['province'] = $value['province'];
            $builder['city'] = $value['city'];
            $builder['area'] = $value['area'];
        }
        return $builder;
    }
    public function getAddressName($province, $city , $area )
    {
        if($province){
            $data['province']=Address::where('id',$province)->select('zonename')->first()->toArray();
        }else{
            $data['province']['zonename']='';
        }
        if($city){
           $data['city']=Address::where('id',$city)->select('zonename')->first()->toArray();
        }else{
            $data['city']['zonename']='';
        }
        if($area){
            $data['area']=Address::where('id',$area)->select('zonename')->first()->toArray();
        }else{
            $data['area']['zonename']='';
        }
        return $data;
    }
}
