<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/6/12
 * Time: 下午9:14
 */

namespace App\Repositories;

use App\Models\Banner;
use App\Models\Image;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BannerRepository {

    public function getBanner() {
        return Banner::orderBy('order','asc')->orderBy('created_at','asc')->get()->toArray();
    }

    public function saveImg($file) {
        return Banner::create(['order' => 999, 'file' => $file]);
    }

    public function moveImg($data) {
        $is = false;
        foreach($data['order'] as $k => $v){
            if($k == 0){ continue; }
            if($v == null){ continue; }
            $is = Banner::findOrFail($k)->update(['order' => $v]);

        }
        return $is;
    }

    public function del($id) {
        return Banner::destroy($id);
    }
}