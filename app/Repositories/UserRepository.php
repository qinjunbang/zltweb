<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/6/12
 * Time: 下午9:14
 */

namespace App\Repositories;

use Auth;
use Carbon\Carbon;
use App\Models\User;

class UserRepository {

    protected $user;

    /**
     * UserRepository constructor.
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * 根据ID修改用户积分
     * @param $id
     * @param $score
     */
    public function byIdChangeUserScore($id, $score) {
        $user = $this->user->findOrFail($id);
        $user->score = $user->score + $score;

        return $user->save();
    }

    /**
     * 根据ID设置用户为经纪人
     * @param $id
     * @return mixed
     */
    public function byIdSetUserAgentTrue($id) {
        $user = $this->user->findOrFail($id);
        $user->is_agent = 1;

        return $user->save();
    }

    /**
     * 使用积分
     * @param $score
     * @return mixed
     */
    public function useScore($score) {
        $user = $this->user->findOrFail(Auth::user()->id);
        $user->score = $user->score - $score;

        return $user->save();
    }

    /**
     * 使用余额
     * @param $score
     * @return mixed
     */
    public function useBalance($balance) {
        $user = $this->user->findOrFail(Auth::user()->id);
        $user->balance = $user->balance - $balance;

        return $user->save();
    }

    /**
     * 获取我邀请的用户
     * @param $id
     * @return mixed
     */
    public function byIdWithMyUsers($id){
        $users = $this->user->where('pid', $id)
            ->select('avatar', 'mobile', 'is_agent', 'created_at')
            ->orderBy('created_at', 'DESC');

        return $users->get();
    }

    /**
     * 获取今天我邀请的用户
     * @param $id
     * @return mixed
     */
    public function byIdWithMyTodayUsers($id){
        $users = $this->user->where('pid', $id)
            ->select('avatar', 'mobile', 'is_agent', 'created_at')
            ->whereBetween('created_at', [Carbon::today(), Carbon::now()]);

        return $users->get();
    }

    /**
     * 根据邀请码获取该该邀请码所属的用户ID
     * @param $InvitationCode
     * @return mixed
     */
    public function byInvitationCodeWithId($InvitationCode) {

        return $this->user->where('invitation_code', $InvitationCode)->select('id')->first();
    }


    /**
     * 生成随机编码
     * @param $length
     * @return string
     */
    public function makeInvitationCode($length) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        for ( $i = 0; $i < $length; $i++ ){
            $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }

        return $password;
    }

    /**
     * 根据id修改用户名
     * @param $id
     * @param $name
     * @return mixed
     */
    public function byIdChangeUsername($id, $name) {
        $user = $this->user->findOrFail($id);
        $user->name = $name;

        return $user->save();
    }

    /**
     * 根据身份证
     * @param $id
     * @param $name
     * @return mixed
     */
    public function byIdChangeIdcard($id, $id_card) {
        $user = $this->user->findOrFail($id);
        $user->id_card = $id_card;

        return $user->save();
    }

    /**
     * 保存经纪人归属街道
     * @param $id
     * @param $name
     * @return mixed
     */
    public function byIdChangeStreet($id, $street) {
        $user = $this->user->findOrFail($id);
        $user->street = $street;

        return $user->save();
    }

    /**
     * 根据id修改用头像
     * @param $id
     * @param $avatar
     * @return mixed
     *
     *
     */
    public function byIdChangeUserAvatar($id, $avatar) {
        $user = $this->user->findOrFail($id);
        $user->avatar = $avatar;

        return $user->save();
    }

    /**
     * 经纪人电话号码
     *
     * @param $builder
     * @return mixed
     */
    public function agentMobile($builder)
    {
        if($builder){
            $mobile = $this->user->where('id', $builder)
                ->select('mobile')
                ->first();
            $data = $mobile->mobile;

        }else{$data = null;}

        return $data;
    }


    /**
     * 发布者电话号码
     *
     * @param $builder
     * @return mixed
     */
    public function userMobile($builder)
    {
        if($builder){
            $mobile = $this->user->where('id', $builder)
                ->select('mobile')
                ->first();
            $data = $mobile->mobile;

        }else{$data = null;}

        return $data;
    }

    /**
     * UID替换成手机号
     *
     * @param $builder
     * @return mixed
     */
    public function replaceMobile($v)
    {
        if($v){
            $mobile = $this->user->where('id', $v)
                ->select('mobile')
                ->first();
            $data = $mobile->mobile;

        }else{$data = null;}

        return $data;
    }

}