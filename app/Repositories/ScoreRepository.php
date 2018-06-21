<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/6/22
 * Time: 下午1:29
 */

namespace App\Repositories;


use App\Models\Score;

class ScoreRepository {

    /**
     * 获取用户积分收支详情
     * @param $uid
     * @param null $page
     * @return mixed
     */
    public function byUserIdWithScoreList($uid, $page = null){
        $score = Score::where('uid', $uid)->orderBy('updated_at', 'DESC');

        return is_null($page)?$score->get():$score->paginate($page);
    }

    /**
     * 添加积分使用记录
     * @param array $attributes
     */
    public function create(array $attributes){

        return Score::create($attributes);
    }
}