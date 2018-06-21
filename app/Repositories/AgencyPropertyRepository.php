<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/5/31
 * Time: 下午1:15
 */

namespace App\Repositories;

use App\Models\AgencyProperty;

class AgencyPropertyRepository {

    /**
     * 添加
     *
     * @array $data 数据
     * @array $arr 允许插入的数据
     * @return mixed
     */
    public function add($data, $arr) {
        return AgencyProperty::create(array_only($data, $arr));
    }

    public function getList() {
        return AgencyProperty::get()->toArray();
    }

    public function delete($id) {
        return AgencyProperty::destroy($id);
    }
}