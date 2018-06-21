<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/6/29
 * Time: 下午3:48
 */

namespace App\Repositories;


use App\Models\Notice;

class NoticeRepository {

    protected $notice;

    /**
     * NoticeRepository constructor.
     * @param $notice
     */
    public function __construct(Notice $notice) {
        $this->notice = $notice;
    }

    /**
     * 创建通知
     * @param array $attributes
     */
    public function create(array $attributes){
        return $this->notice->create($attributes);
    }

    /**
     * 根据用户ID查询用户通知信息
     * @param $uid
     * @return mixed
     */
    public function byUidWithNoticeList($uid) {

        return $this->notice->where('uid', $uid)->orderBy('is_read', 'ASC')->orderBy('created_at', 'DESC')->get();
    }

    /**
     * 根据用户ID查询用户通知信息
     * @param $uid
     * @return mixed
     */
    public function byUidWithNoticeList2($uid,$title) {

        return $this->notice->where('uid', $uid)->where('content','like', '%'.$title.'%')->orderBy('is_read', 'ASC')->orderBy('created_at', 'DESC')->get();
    }

    /**
     * 根据用户ID查询用户未读通知信息
     *
     * @param $uid
     * @return int
     */
    public function byUidWithNoticeNotReadCount($uid) {
        return $this->notice->where('uid', $uid)->where('is_read', 0)->count();
    }

    /**
     * 根据id获取通知信息
     * @param $id
     * @return mixed
     */
    public function byIdWithNotice($id) {

        return $this->notice->findOrFail($id);
    }

}