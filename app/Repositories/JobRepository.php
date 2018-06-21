<?php
/**
 * Created by PhpStorm.
 * User: cth
 * Date: 2017/6/13
 * Time: 上午10:13
 */

namespace App\Repositories;

use Auth;
use App\Models\Job;
use App\Models\HomeService;

class JobRepository {


    /**
     * 添加招聘信息
     *
     * @param $data
     * @return mixed
     */
    public function add($id,$data)
    {
        $data['pid']=$id;
        unset($data['_token']);
        return Job::create($data);
        
    }

    /**
     * 查找招聘信息
     *
     * @param $data
     * @return mixed
     */
    public function findall($id)
    {
       return Job::where('pid',$id)->select('id','business','province','city','area','district','job_name','min_price','max_price','created_at');
    }
    public function list()
    {
       return Job::select('id','business','province','city','area','district','job_name','min_price','max_price','created_at');
    }
    public function getBusiness($id)
    {
        $pid=Job::where('id',$id)->select('pid')->first();
        $pid=HomeService::where('id',$pid['pid'])->first();
        return $pid['title'];
    }
    /**
     * 招聘信息详情
     *
     * @param $data
     * @return mixed
     */
    public function detail($id)
    {
       return Job::where('id',$id)->select('id','business','province','city','area','district','job_name','mobile','min_price','max_price','detail','created_at','number');
    }
    public function addNumber($id)
    {
        Job::where('id',$id)->increment('number', 1);
    }
    /**
     * 查找招聘信息
     *
     * @param $data
     * @return mixed
     */
    public function del($id)
    {
       return Job::where('id',$id)->delete();
    }
    /**
     * 修改招聘信息
     *
     * @param $data
     * @return mixed
     */
    public function edit($data)
    {
        return Job::where('id',$data['id'])
                        ->update([
                            'mobile'=>$data['mobile'],    
                            'business'=>$data['business'],    
                            'province'=>$data['province'],    
                            'city'=>$data['city'],    
                            'area'=>$data['area'],    
                            'district'=>$data['district'],    
                            'job_name'=>$data['job_name'],
                            'min_price'=>$data['min_price'],
                            'max_price'=>$data['max_price'],
                            'detail'=>$data['detail'],
                        ]);
    }
}