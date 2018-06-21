<?php
namespace App\Repositories;

use App\Models\Address;
use App\Models\Image;
use App\Models\User;
use App\Models\WorkshopLand;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Models\Court;


/**
 * 所有的房源信息方法
 * Created by PhpStorm.
 * User: cth
 */
class DataRepository
{
    private $post;
    private $get;
    private $page = 10;
    private $numArray = array('1st-apartment' => '11', '2nd-apartment-sale' => '21', '2nd-apartment-rental' => '22', 'shop-sale' => '31', 'shop-rental' => '32', 'business-transfer-sale' => '41', 'workshop-land-sale' => '51', 'workshop-land-rent' => '52');
    private $numType;
    private $model;
    private $addFieldArray;
    private $editFieldArray;
    private $getOneFieldArray;
    private $getAllFieldArray;
    private $type;
    private $uriMiddle;
    private $hasCourt = false;
    private $saleOrRental = false;
    private $way = 'user';
    private $searchParam;


    /**
     * 后台获取数据
     *
     * @param null $id
     * @return array
     */
    public function getDataAdmin($id = null) {
        $this -> way = 'admin';
        return $this->getData($id);
    }
    public function getDataAdmin1($id = null) {
        $this -> way = 'admin';
        return $this->getData1($id);
    }
    /**
     * 前台筛选数据
     *
     * @param null $id
     * @return array
     */
    public function getDatascreen($title) {
        $this -> way = 'user';
        return $this->getDatasss($title);
    }

    /**
     * 手机号筛选数据
     *
     * @param null $id
     * @return array
     */
    public function getDataMobile($mobile = null,$user =null) {
        $this -> way = 'admin';
        if($user ==null){
            return $this->AllMobile($mobile);
        }
        return $this->AllMobileuser($mobile);
    }

    /**
     * 后台获取筛选数据
     *
     * @param null $id
     * @return array
     */
    public function selectDataAdmin($select) {
        $this -> way = 'admin';
        return $this->getData($id);
    }

    /**
     * 前台获取数据
     *
     * @param null $id
     * @return array
     */
    public function getDataUser($id = null) {
        $this -> way = 'user';
        return $this->getData($id);
    }
    public function getDataUser1($id = null) {
        $this -> way = 'user';
        return $this->getData1($id);
    }
    /**
     * 获取数据
     *
     * @param null $id
     *
     * @return array
     */
    private function getData($id = NULL)
    {
        return !is_null($id) ? $this -> getOneData($id) : $this -> getAllData();
    }
    private function getData1($id = NULL)
    {
        return !is_null($id) ? $this -> getOneData($id) : $this -> getAllData1();
    }
    /**
     * 添加房源
     *
     * @param $data
     * @return mixed
     */
    public function addData($data)
    {

        if(in_array('unit_price',$this->addFieldArray)) {
            $data['unit_price'] = ( $data['total_price'] * 10000 ) / $data['total_area'];//计算挂牌单价并且插入data数组
        }
        $data['number'] = $this->numArray["{$this->numType}"] . time();//给一个编号
        if(in_array('label', $this->addFieldArray) && !empty($data['label'])){//如果传入了label 就把label分割成字符串
            $data['label'] = implode(LABEL_SEPARATOR,$data['label']);
        }
        DB::beginTransaction();
        try{
            $result_1 = $this->model->create(array_only($data,$this->addFieldArray));
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
            if(!empty($data['image_file'])) { //实现图片选填
                foreach ($data['image_file'] as $k => $v) {
                    $imageData[$k + 1] = array(
                        'imageable_id' => $result_1['id'],
                        'imageable_type' => 'App\Models\\' . $this->type,
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
     * 添加房源
     *
     * @param $data
     * @return mixed
     */
    public function addData2($data)
    {

        $data['number'] = $this->numArray["{$this->numType}"] . time();//给一个编号

        //$data['user_id'] = Auth::user()->id;//给一个uid
        $data['save_or_output'] = '1';

        if(in_array('label', $this->addFieldArray) && !empty($data['label'])){//如果传入了label 就把label分割成字符串
            $data['label'] = implode(LABEL_SEPARATOR,$data['label']);
        }
       
        DB::beginTransaction();
        try{
            $result_1 = $this->model->create(array_only($data,$this->addFieldArray));
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
            if(!empty($data['image_file'])) { //实现图片选填
                foreach ($data['image_file'] as $k => $v) {
                    $imageData[$k + 1] = array(
                        'imageable_id' => $result_1['id'],
                        'imageable_type' => 'App\Models\\' . $this->type,
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
     * 修改厂房土地
     *
     * @param $data
     * @return bool
     */
    public function editData($data)
    {
      //  if(!$this->model->findOrfail($data['id'])->status == 0){ return false; }//只允许修改status == 0 的记录
        if(in_array('unit_price',$this->editFieldArray)) {
            if(isset($data['total_price'])){
                $data['unit_price'] = ( $data['total_price'] * 10000 ) / $data['total_area'];//计算挂牌单价并且插入data数组
            }
        }
        if(in_array('label', $this->addFieldArray) && !empty($data['label'])){//如果传入了label 就把label分割成字符串
            $data['label'] = implode(LABEL_SEPARATOR,$data['label']);
        }
        DB::beginTransaction();
        try{
            $result_1 = $this->model->where('id',$data['id'])->update(array_only($data,$this->editFieldArray));
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
            $im = Image::where('imageable_id', $data['id'])->where('imageable_type', 'App\Models\\'.$this->type);
            $result_2 = $im -> count() == 0 ? true : $im -> delete();
            if (!$result_2) {
                throw new \Exception("2");
            }
            if(!empty($data['image_file'])) { //实现图片选填
                foreach ($data['image_file'] as $k => $v) {
                    $imageData[$k + 1] = array(
                        'imageable_id' => $data['id'],
                        'imageable_type' => 'App\Models\\' . $this->type,
                        'file' => "{$v}",
                    );
                }
                $result_3 = DB::table('images')->insert($imageData);
                if (!$result_3) {
                    throw new \Exception("3");
                }
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

    /**
     * 通过id删除
     *
     * @param $id
     * @return int
     */
    public function delData($id)
    {
        if(Auth::guard('admin')->user()->super != 1){
            return false;
        }
        return $this->model->destroy($id);
    }


    /**
     * 通过id删除
     *
     * @param $id
     * @return int
     */
    public function deluserData($id)
    {

        return $this->model->destroy($id);
    }
    /**
     * 通过id修改优品质造
     *
     * @param $id
     * @param $status
     * @return mixed
     */
    public function changeGood($id) {
        $data = $this->model->where('id', $id)->select('is_good_build')->first();
        if($data['is_good_build']==0){
            return $this->model->where('id',$id)->update(['is_good_build'=>1]);
        }else{
            return $this->model->where('id',$id)->update(['is_good_build'=>0]);
        }
    }
    /**
     * 通过id审核
     *
     * @param $id
     * @param $status
     * @return mixed
     */
    public function verifyData($id, $status) {
        return $this->setStatus($id, $status);
    }

    /**
     * 通过id成交
     *
     * @param $id
     * @param $status
     * @return mixed
     */
    public function dealData($id, $status) {
        return $this->setStatus($id, $status);
    }

    /**
     * 通过id设置status
     *
     * @param $id
     * @param $status
     * @return mixed
     */
    private function setStatus($id, $status){
        $m = $this->model->where('id', $id);
        return $m->update(['status'=> $status]);
    }

    /**
     * 通过id获取单条数据
     *
     * @param $id
     *
     * @return mixed
     */
    private function getOneData($id)
    {
        $builder = $this->model->select($this->getOneFieldArray);
        ($this->saleOrRental) && $builder -> where('sale_or_rental',$this->saleOrRental);
        return $builder->where('id',$id)->with('user')->with('agent')->with('court')->with('images')->first();
    }



    /**
     * 获取所有的数据
     *
     * @return array|mixed
     */
    private function getAllData()
    {
        $builder = $this->model->select($this->getAllFieldArray);
        $this->way != 'admin' ? $builder->where('status',1)->where('save_or_output',1)->where('temporary','<>',1)->with('images') : $builder->where('temporary','<>',1)->orderBy('status','asc');

        $builder->orderBy('created_at','desc');
       // $this->hasCourt && $builder->with('court');
        $builder->with('court');

        !empty($this->searchParam) && $builder = $this->setParam($builder,$this->searchParam);
        if(!empty($this->page)){
            if($this->way != 'admin'){
                $builder = $builder->paginate($this->page)->toArray();
            }else{
                $builder = $this->returnDataAndPage($builder->paginate($this->page));
            }
        }

        return $builder;
    }
    private function getAllData1()
    {
        $builder = $this->model->select($this->getAllFieldArray);
        $this->way != 'admin' ? $builder->where('status',1)->where('save_or_output',1)->where('temporary','<>',1)->where('is_good_build',1)->with('images') : $builder->where('temporary','<>',1)->orderBy('status','asc');

        $builder->orderBy('created_at','desc');
        // $this->hasCourt && $builder->with('court');
        $builder->with('court');

        !empty($this->searchParam) && $builder = $this->setParam($builder,$this->searchParam);
        if(!empty($this->page)){
            if($this->way != 'admin'){
                $builder = $builder->paginate($this->page)->toArray();
            }else{
                $builder = $this->returnDataAndPage($builder->paginate($this->page));
            }
        }

        return $builder;
    }



    private function getDatasss($title)
    {
        $builder = $this->model->select($this->getAllFieldArray);
        $this->way != 'admin' ? $builder->where('status',1)->where('sale_or_rental',$title)->where('save_or_output',1)->where('temporary','<>',1)->with('images') : $builder->where('temporary','<>',1)->orderBy('status','asc');

        $builder->orderBy('created_at','desc');
        // $this->hasCourt && $builder->with('court');
        $data['data'] = $builder->with('court')->get()->toArray();

        return $data;
    }








    /**
     * 获取手机号检索数据
     *
     * @return array|mixed
     */
    private function AllMobile($mobile)
    {
        //查找有关的手机号(经纪人)/这样写会浪费很多性能
        $userdata = User::where('mobile','like',"%".$mobile."%")->where('is_agent','1')->get()->toArray();
        $data['data'] = array();
        foreach ($userdata as $k=>$v){
            $id = $v['id'];
            $builder = $this->model->select($this->getAllFieldArray);
            $builder->where('status',1)->where('save_or_output',1)->where('temporary','<>',1)->where('agent_id',$id);
            $builder->with('court');
            $no = $builder->get()->toArray();
            foreach ($no as $key=>$val){
                Array_push($data['data'], $val);
            }
        }
        $num = count($data['data']);
        $uri = $this->getAdminOperateUri();
        $data = $data+$uri;
        $data['total'] =$num;
        return $data;
    }


    /**
     * 获取手机号检索数据
     *
     * @return array|mixed
     */
    private function AllMobileuser($mobile)
    {
        //查找有关的手机号(经纪人)/这样写会浪费很多性能
        $userdata = User::where('mobile','like',"%".$mobile."%")->where('is_agent','1')->get()->toArray();
        $data['data'] = array();
        foreach ($userdata as $k=>$v){
            $id = $v['id'];
            $builder = $this->model->select($this->getAllFieldArray);
            $builder->where('status',1)->where('save_or_output',1)->where('temporary','<>',1)->where('user_id',$id);
            $builder->with('court');

            $no = $builder->get()->toArray();
            foreach ($no as $key=>$val){
                Array_push($data['data'], $val);
            }
        }
        $num = count($data['data']);
        $uri = $this->getAdminOperateUri();
        $data = $data+$uri;
        $data['total'] =$num;
        return $data;
    }



    /**
     * 设置检索的参数(多个条件) 返回一个object对象
     *
     * @param $obj
     * @param $param
     * @return mixed
     */
    private function setParam($obj,$param) {
        !empty($param['param']) && $param = $param['param'];
        //dd($param);
        foreach($param as $k => $v){
            if($k == 'sale_or_rental'){ $obj = $obj->where("{$k}", $v); continue;}
            if($k == 'page'){ continue;}
            /*if($k == 'user_mobile'){
                $obj = $obj -> with('users');
                continue;
            }*/
            if($k == 'user_mobile'){
                $obj = $obj-> with('agent');
                continue;
            }
            if($k == 'agent_mobile'){
                $obj = $obj-> with('agent');
                continue;
            }

            if(in_array($k, $GLOBALS['__SEARCH_FIELD__']['DIFF']['INTERVAL'])) { // 条件是区间的字段
                $condition = explode('-', $v);
                $obj = $obj->where($GLOBALS['__SEARCH_FIELD__']["{$k}"], '>=', (int)$condition[0]);
                if(count($condition) > 1){
                    $obj = $obj -> where($GLOBALS['__SEARCH_FIELD__']["{$k}"], '<=', (int)$condition[1]);
                }
            }elseif(in_array($k, $GLOBALS['__SEARCH_FIELD__']['DIFF']['EQUAL'])) {  // 条件是相等的字段
                $obj = $obj->where($GLOBALS['__SEARCH_FIELD__']["{$k}"], array_search($v, $GLOBALS['__SEARCH_PARAM__']["{$k}"]));
            }else if(in_array($k, $GLOBALS['__SEARCH_FIELD__']['DIFF']['COURT'])){  // 条件需要with court的字段
                //$area = Address::where('level', 2)->where('zonename', $v)->first();
                if($v == '北仑区'){    //暂时只做北仑区, 先这样了

                }else{
                    $obj = $obj -> where('id', 0);
                }

            }else {
                $obj = $obj->where("{$k}", 'like', '%' . $v . '%');
            }
        }
        //dd($obj->get()->toArray());
        return $obj;
    }
    
    /**
     * 输入分页后的object,返回一个array,包含分页后的数据和一个page页
     *
     * @param $obj
     *
     * @return array
     */
    private function returnDataAndPage($obj) {
        $arr = $obj -> toArray();
        $builder = [
            'data' => empty($arr['data']) ? [] : $arr['data'],
            'page' => "{$obj->links('vendor.pagination.bootstrap-4')}",
            'total' => $obj->total(),
        ];
        $this->way == 'admin' && $builder = $builder + $this -> getAdminOperateUri();
        return $builder;
    }

    /**
     * 获取后台操作uri
     *
     * @return array
     */
    private function getAdminOperateUri() {
        $uri = array();
        //Auth::guard('admin')->user()->toArray()
        if(Auth::guard('admin')->user()->super == 1){
            $uri['删除'] =  url('admin/'.strtolower($this->uriMiddle).'/del') ;
            $uri['审核'] =  url('admin/'.strtolower($this->uriMiddle).'/verify');
            if($this->type != 'FirstApartment') {
                $uri['成交'] = url('admin/' . strtolower($this->uriMiddle) . '/close-deal');
            }else{
                $uri['优质修改'] =  url('admin/'.strtolower($this->uriMiddle).'/isGoodBuild');
            }

        }
        return [
            'uri' => [
                '修改' => url('admin/'.strtolower($this->uriMiddle).'/edit'),
                '详情' => url('admin/'.strtolower($this->uriMiddle).'/detail'),
                    ] + $uri
        ];
    }



    /**
     * 设置model
     * @param $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * 设置添加时候的字段
     *
     * @param $addFieldArray
     */
    public function setAddFieldArray($addFieldArray)
    {
        $this->addFieldArray = $addFieldArray;
    }

    /**
     * 设置编辑更新数据时的字段
     *
     * @param $editFieldArray
     */
    public function setEditFieldArray($editFieldArray)
    {
        $this->editFieldArray = $editFieldArray;
    }

    /**
     * 设置得到一条数据时的字段
     *
     * @param $getOneField
     */
    public function setGetOneFieldArray($getOneField)
    {
        $this->getOneFieldArray = $getOneField;
    }

    /**
     * 设置得到所有数据时的字段
     *
     * @param $getAllFieldArray
     */
    public function setGetAllFieldArray($getAllFieldArray)
    {
        $this->getAllFieldArray = $getAllFieldArray;
    }

    /**
     * 设置类型比如 'WorkshopLand'
     *
     * @param $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * 设置检索参数
     */
    public function setSearchParam($s) {
        $this->searchParam = $s;
    }

    /**
     * 设置uri中间部分
     *
     * @param $uriMiddle
     */
    public function setUriMiddle($uriMiddle)
    {
        $this->uriMiddle = $uriMiddle;
    }

    /**
     * 设置是否关联court
     * @param $hasCourt
     */
    public function setHasCourt($hasCourt) {
        $this->hasCourt = $hasCourt;
    }

    /**
     * 设置number编号的类型
     * @param $numType
     */
    public function setNumType($numType) {
        $this->numType = $numType;
    }

    /**
     * 设置类型是出售还是出租
     * @param $saleOrRental
     */
    public function setSaleOrRental($saleOrRental) {
        $this->saleOrRental = $saleOrRental;
    }


    public function setPostParam($post)
    {
        $this -> post = $post;
    }

    public function getPostParam()
    {
        return $this -> post;
    }

    public function setGetParam($get)
    {
        $this -> get = $get;
    }

    public function getGetParam()
    {
        return $this -> get;
    }
}