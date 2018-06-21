<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public $table = 'job';
	protected $fillable = [ 'mobile','business','province','city','area','district','pid','job_name','detail','min_price','max_price'];
    public function business()
    {
        return $this->belongsTo('App\Models\HomeService','pid','id')->where('is_show','1')->select('id','name');
    }
}
