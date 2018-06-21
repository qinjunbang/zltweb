<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/6/30
 * Time: 上午10:02
 */

namespace App\Repositories;


use App\Models\Help;

class HelpRepository {

    protected $help;

    /**
     * HelpRepository constructor.
     * @param $help
     */
    public function __construct(Help $help) {
        $this->help = $help;
    }

    /**
     * 查询帮助内容
     * @param null $page
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function select($page = null) {
        $help = $this->help->orderBy('created_at', 'DESC');

        return is_null($page)? $help->get():$help->paginate($page);
    }

    /**
     * 添加帮助内容
     * @param array $attributes
     */
    public function create(array $attributes){

        return $this->help->create($attributes);
    }

    /**
     * 根据id查询帮助信息
     * @param $id
     * @return mixed
     */
    public function byIdWithHelp($id) {

        return $this->help->findOrFail($id);
    }

    /**
     * 更新帮助内容
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes) {
        $help = $this->help->findOrFail($id);

        return $help->update($attributes);
    }

    /**
     * 通过帮助ID删除帮助
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        $help = $this->help->findOrFail($id);

        return $help->delete();
    }
}