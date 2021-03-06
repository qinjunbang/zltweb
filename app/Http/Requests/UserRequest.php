<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'mobile' => 'required|unique:users',
            /*'id_card' => 'required',*/
            'password' => 'required|alpha_dash|between:6,11',
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
            'name.required' => '请填写用户姓名',
            'mobile.required' => '请填写用户账号',
            'id_card.required' => '请填写身份证号码',
            'mobile.unique' => '该账号已存在',
            'password.required'  => '密码不能为空',
            'password.alpha_dash'  => '密码不能有除字母、数字、-以及_以外的字符',
            'password.between'  => '密码不能小于6位或者大于11位',
        ];
    }
}
