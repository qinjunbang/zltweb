<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'content' => 'required',
            'property_key' => 'required',
            'param' => 'required',
            'image_file'=>'required',
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
            'name.required' => '请填写商品标题',
            'description.required' => '请填写产品描述',
            'content.required' => '请填写产品内容',
            'property_key.required' => '请填写属性列表',
            'param.required' => '请填写商品规格信息',
            'image_file.required' => '请添加图片',
        ];
    }
}
