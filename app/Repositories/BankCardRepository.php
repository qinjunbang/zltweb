<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/6/22
 * Time: 下午1:26
 */

namespace App\Repositories;


use App\Models\BankCard;

class BankCardRepository {

    /**
     * 获取用户银行卡信息
     * @param $mobile  手机号
     * @return mixed
     */
    public function GetUserBankCardList($mobile){
        $banklist = BankCard::where('mobile', $mobile)->orderBy('updated_at', 'DESC');

        return $banklist->get();
    }


    /**
     * 获取用户银行卡信息
     * @param $id  id
     * @return mixed
     */
    public function GetUserBankCardListid($id){
        //查询银行卡数据
        $banklist = BankCard::where('id', $id);
        
        

        return $banklist->get();
    }


    /**
     * 添加银行卡信息
     * @param array $bankdata
     */
    public function postbankcard(array $bankdata){


        return BankCard::create($bankdata);
    }




}