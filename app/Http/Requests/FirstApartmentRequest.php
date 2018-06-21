<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FirstApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'province' => 'required',
            'city' => 'required',
            'image_file' => 'required',
            'area' => 'required',
            'decorate_model' => 'required',
            'unit_price' => 'required',
            'market_opening_time' => 'required',
            'delivery_date_time' => 'required',
            'owner_note' => 'required',
            'district' => 'required',
            //'image_file' => 'required',
            'mobile' => 'required',
        ];
    }

    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required'=> '请填写标题',
            'province.required'=> '请填写省份',
            'image_file.required'=>'图片不能为空',
            'city.required'=> '请填写城市',
            'area.required'=> '请填写区县',
            'decorate_model.required'=> '请填写装修状况',
            'unit_price.required'=> '请填写挂牌单价',
            'market_opening_time.required'=> '请填写开盘时间',
            'delivery_date_time.required'=> '请填写交房时间',
            'owner_note.required'=> '请填写备注',
            'district.required'=> '请填写区域',
            //'image_file.required'=>'请选择图片',
            'mobile.required'=>'请填写电话号码',

        ];
    }
}
