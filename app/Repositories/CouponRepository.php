<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/6/11
 * Time: 下午9:35
 */

namespace App\Repositories;


use App\Models\Coupon;
use App\Models\HomeService;
use App\Models\CouponType;

class CouponRepository {

    /**
     * 获取用户优惠券列表
     * @param $authId
     * @param null $page
     * @return mixed
     */
    public function byIdWithCouponList($authId, $is_used = null, $page = null) {
        $coupon = Coupon::where('uid', $authId);
        !is_null($is_used)?$coupon->where('is_used', $is_used):'';
        $coupon->orderBy('updated_at','DESC');
        return is_null($page)?$coupon->get():$coupon->paginate($page);
    }

    /**
     * 根据id查询优惠券
     * @param $id
     * @return mixed
     */
    public function byIdWithCoupon($id) {

        return Coupon::findOrFail($id);
    }

    /**
     * 查询优惠券信息
     * @param $id
     * @param null $page
     * @return mixed
     */
    public function byPidWithCouponList($id, $page = null) {
        $coupon =  Coupon::where('pid', $id);
        $coupon->orderBy('updated_at', 'DESC');
        return is_null($page)?$coupon->get():$coupon->paginate($page);
    }

    /**
     * 根据优惠券编码查询优惠券信息
     * @param $id
     * @param $code
     * @return mixed
     */
    public function byCodeWithCoupon($id, $code){

        return Coupon::where('pid', $id)->where('code', $code)->first();
    }

    /**
     * 生成优惠码
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function createCouponCode() {
        do {
            //$code = random_int(100000000000, 999999999999);
            $code = rand(10000000, 99999999);
        } while (Coupon::where('code', $code)->first() != null);

       return $code;
    }


    /**
     * 使用优惠码
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function useCouponCode($id,$pid) {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_used = 'T';
        $coupon->pid = $pid;
        return $coupon->save();
    }

    /**
     * 添加优惠券
     * @param array $attributes
     */
    public function create(array $attributes){

        return Coupon::create($attributes);
    }

    public static function getBusniess($pid)
    {
        $data=HomeService::where('id',$pid)->select('title')->first();
        return $data['title'];
    }
    public function is_have($title,$price,$uid)
    {
        return Coupon::where('title',$title)->where('value',$price)->where('uid',$uid)->first();
    }
}