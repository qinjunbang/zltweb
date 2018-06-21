<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = true;  //使用create_at和update_at字段
    protected $guarded = ['id'];    //受保护的字段-这个字段不可写入

    /**
     * Get all of the owning favorable models.
     */
    public function favorable()
    {
        return $this->morphTo();
    }
}
