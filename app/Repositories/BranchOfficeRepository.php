<?php
/**
 * Created by PhpStorm.
 * User: jinjialei
 * Date: 2017/5/31
 * Time: 下午1:15
 */

namespace App\Repositories;


use App\Models\BranchOffice;
use App\Models\Image;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BranchOfficeRepository {

    public function getList() {
        return BranchOffice::all();
    }

    //搜索列表
    public function selList($title) {
        $data = BranchOffice::where('name', 'like', '%'.$title.'%')->get();
        if(!isset($data)){
            $data = BranchOffice::where('address', 'like', '%'.$title.'%')->get();
        }
        return $data;
    }



    public function add($data) {

        DB::beginTransaction();
        try{
            $result_1 = BranchOffice::create(array_only($data,['name', 'image', 'content', 'address', 'contact_number']));
            if (!$result_1) {

                /**
                 * Exception类接收的参数
                 * $message = "", $code = 0, Exception $previous = null
                 */
                throw new \Exception("1");
            }

            /**
             * 创建image数据
             */
            foreach($data['image_file'] as $k => $v){
                $imageData[$k+1] = array(
                    'imageable_id' => $result_1['id'],
                    'imageable_type' => 'App\Models\BranchOffice',
                    'file' => "{$v}",
                );
            }
            $result2 = DB::table('images')->insert($imageData);
            if (!$result2) {
                throw new \Exception("2");
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

    public function edit($data)
    {
        DB::beginTransaction();
        try{
            $result_1 = BranchOffice::where('id',$data['id'])->update(array_only($data,['name', 'image', 'content', 'address', 'contact_number']));
            if (!$result_1) {

                /**
                 * Exception类接收的参数
                 * $message = "", $code = 0, Exception $previous = null
                 */
                throw new \Exception("1");
            }

            /**
             * 修改image数据
             */
            $result_2 = (Image::where('imageable_id', $data['id'])->where('imageable_type','App\Models\BranchOffice')->count() == 0 ? true : Image::where('imageable_id', $data['id'])->where('imageable_type','App\Models\BranchOffice')->delete());
            if (!$result_2) {
                throw new \Exception("2");
            }

            foreach($data['image_file'] as $k => $v){
                $imageData[$k+1] = array(
                    'imageable_id' => $data['id'],
                    'imageable_type' => 'App\Models\BranchOffice',
                    'file' => "{$v}",
                );
            }
            $result_3 = DB::table('images')->insert($imageData);
            if (!$result_3) {
                throw new \Exception("3");
            }
            DB::commit();
            return true;
        } catch (\Exception $e){
            DB::rollback();//事务回滚
            echo $e->getMessage();
            echo $e->getCode();
            return false;
        }
    }

    public function getOne($id) {
        return BranchOffice::with('images')->findOrfail($id);
    }

    public function del($id) {
        return BranchOffice::destroy($id);
    }
}