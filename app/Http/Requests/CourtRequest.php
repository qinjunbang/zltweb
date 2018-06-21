<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourtRequest extends FormRequest
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
            'province' => 'required',
            'city' => 'required',
            'area' => 'required',
            'pp' => 'required|unique:courts'
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
            'name.required' => '请填写小区名',
            'province.required' => '请选择省份',
            'city.required'  => '请选择城市',
            'area.required'  => '请选择地区',
            'pp.required' => '请在下拉框选择地区',
            'pp.unique' => '该地址已经存在',
        ];
    }
}
