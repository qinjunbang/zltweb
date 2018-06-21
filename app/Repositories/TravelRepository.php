<?php
/**
 * Created by PhpStorm.
 * User: cth
 * Date: 2017/6/13
 * Time: 上午10:13
 */

namespace App\Repositories;

use Auth;
use App\Models\Travel;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class TravelRepository {


    /**
     * 添加旅游信息
     *
     * @param $data
     * @return mixed
     */
    public function add($id,$data)
    {
        $data['pid']=$id;
        $image=$data['image_file'];
        unset($data['_token']);
        unset($data['image_file']);

        DB::beginTransaction();
        try{
            $result_1 = Travel::create($data);

            if (!$result_1) {
                throw new \Exception("1");
            }
            

            /**
             * 创建image数据
             */
            if(!empty($image)) { //实现图片选填
                foreach ($image as $k => $v) {
                    $imageData[$k + 1] = array(
                        'imageable_id' => $result_1['id'],
                        'imageable_type' => 'App\Models\\' . 'travel',
                        'file' => "{$v}",
                    );
                }
                $result2 = DB::table('images')->insert($imageData);
                if (!$result2) {
                    throw new \Exception("2");
                }
            }
            DB::commit();
            return $result_1['id'];
        } catch (\Exception $e){
            DB::rollback();//事务回滚
            echo $e->getMessage();
            echo $e->getCode();
            return false;
        }
        
    }

    /**
     * 查找旅游信息
     *
     * @param $data
     * @return mixed
     */
    public function findall($id)
    {
       return Travel::where('pid',$id)->select('id','title','district','area','city','province','name','min_price','max_price','created_at');
    }
    public function list()
    {
       return Travel::select('id','title','district','area','city','province','name','min_price','max_price','created_at')->get()->toArray();
    }
    /**
     * 旅游信息详情
     *
     * @param $data
     * @return mixed
     */
    public function detail($id)
    {
       return Travel::where('id',$id)->select('id','title','district','area','city','province','name','min_price','max_price','detail','created_at','number')->first()->toArray();
    }
    public function getImg($id)
    {
       return Image::where('imageable_id',$id)->where('imageable_type','App\Models\travel')->select('id','file')->get()->toArray();
    }
    public function addNumber($id)
    {
        Travel::where('id',$id)->increment('number', 1);
    }
    /**
     * 查找旅游信息
     *
     * @param $data
     * @return mixed
     */
    public function del($id)
    {
       return Travel::where('id',$id)->delete();
    }
    /**
     * 修改旅游信息
     *
     * @param $data
     * @return mixed
     */
    public function edit($data)
    {

        DB::beginTransaction();
        try{
            $result_1 = Travel::where('id',$data['id'])
                        ->update([
                            'title'=>$data['title'],
                            'province'=>$data['province'],
                            'city'=>$data['city'],
                            'area'=>$data['area'],
                            'district'=>$data['district'],
                            'name'=>$data['name'],
                            'min_price'=>$data['min_price'],
                            'max_price'=>$data['max_price'],
                            'detail'=>$data['detail'],
                        ]);

            if (!$result_1) {
                throw new \Exception("1");
            }
            

            /**
             * 创建image数据
             */
            if(!empty($data['image_file'])) { //实现图片选填
                foreach ($data['image_file'] as $k => $v) {
                    $imageData[$k + 1] = array(
                        'imageable_id' => $data['id'],
                        'imageable_type' => 'App\Models\\' . 'travel',
                        'file' => "{$v}",
                    );
                }
                $result2 = DB::table('images')->insert($imageData);
                if (!$result2) {
                    throw new \Exception("2");
                }
            }
            DB::commit();
            return $data['id'];
        } catch (\Exception $e){
            DB::rollback();//事务回滚
            echo $e->getMessage();
            echo $e->getCode();
            return false;
        }
                    
    }
   
}