<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'consignee' => 'required',
            'mobile' =>'numeric',
            'province' => 'required',
            'city' => 'required',
            'area' => 'required',
            'address' => 'required',
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
            'consignee.required' => '请填写联系人',
            'mobile.numeric' => '联系电话格式不正确',
            'province.required' => '请填写省份',
            'city.required' => '请填写城市',
            'area.required' => '请填写地区',
            'address.required' => '请填写详细地址',
        ];
    }
}
