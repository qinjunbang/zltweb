<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/5/31
 * Time: 下午1:15
 */

namespace App\Repositories;


use App\Models\AgencyProperty;
use Illuminate\Support\Facades\Auth;

class AgencyRepository {

    public function add($data) {
        $data['uid'] = Auth::id();
        return AgencyProperty::create(array_only($data,['uid', 'full_name', 'contact_number', 'address']));
    }

    public function getList() {

    }
}