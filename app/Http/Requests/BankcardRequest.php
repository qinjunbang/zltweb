<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankcardRequest extends FormRequest
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
            'card_name' => 'required',//持卡人
            'card_number' => 'required|digits_between:16,19',//bank
            'mobile_card' => 'required|size:11',
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
            'card_name.required'=> '请填写持卡人',
            'id_card.size'=>'身份证长度错误',
            'card_number.required'=> '请填写银行卡号',
            'card_number.digits_between'=> '请输入正确的银行卡号',
            'mobile_card.required'=> '请填写银行绑定手机号',
            'mobile_card.size'=> '请输入正确的手机号',
        ];
    }
}
