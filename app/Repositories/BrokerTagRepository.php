<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/7/8
 * Time: 下午1:43
 */

namespace App\Repositories;


use App\Models\BrokerTag;

class BrokerTagRepository {

    protected $brokerTag;

    /**
     * BrokerTagRepository constructor.
     */
    public function __construct(BrokerTag $brokerTag) {
        $this->brokerTag = $brokerTag;
    }

    /**
     * 经纪人标签列表
     * @param $page
     * @return mixed
     */
    public function getBrokerList($page = null) {

        return is_null($page)?$this->brokerTag->get():$this->brokerTag->where('is_show','1')->paginate($page);
    }

    /**
     * 添加经纪人标签
     * @param array $attributes
     */
    public function create(array $attributes){

        return $this->brokerTag->create($attributes);
    }

    /**
     * 更具Id查找经纪人标签
     * @param $id
     * @return mixed
     */
    public function byIdWithBrokerTag($id) {

        return $this->brokerTag->findOrFail($id);
    }

    /**
     * 更新经纪人标签
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes) {
        $brokerTag = $this->brokerTag->findOrFail($id);

        return $brokerTag->update($attributes);
    }

    /**
     * 删除经纪人标签
     * @param $id
     * @return mixed
     */
    public function destroy($id){

        return $this->brokerTag->destroy($id);
    }
}