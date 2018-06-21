<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyProperty extends Model
{
    protected $guarded = ['id'];    //受保护的字段-这个字段不可写入 上线需加上status
}
