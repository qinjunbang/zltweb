<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/5/31
 * Time: 下午1:15
 */

namespace App\Repositories;

use App\Models\Categories;

class LYJ {

    /**
     * @return
     */
    public function Lyj() {

        return Categories::where('hide',1)->get();

    }

}
