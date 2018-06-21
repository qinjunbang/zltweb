<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/6/12
 * Time: 下午4:56
 */

namespace App\Repositories;


use App\Models\Coupon;
use App\Models\CouponType;

class CouponTypeRepository {
    protected $couponType;


    /**
     * CouponTypeRepository constructor.
     */
    public function __construct(CouponType $couponType) {
        $this->couponType = $couponType;
    }

    public function byPidWithCouponTypeList($pid, $page = null) {
        $couponType =  $this->couponType->where('pid', $pid);
        $couponType->orderBy('updated_at', 'DESC');

        return is_null($page)?$couponType->get():$couponType->paginate($page);
    }

    /**
     * 根据id查找优惠券信息
     * @param $id
     * @return mixed
     */
    public function find($id) {

        return $this->couponType->findOrFail($id);
    }

    /**
     * 商家添加优惠券模版
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes){

        return $this->couponType->create($attributes);
    }

    /**
     * 删除优惠券模版
     * @param $id
     * @return mixed
     */
    public function destroy($id){

        return $this->couponType->destroy($id);
    }
}