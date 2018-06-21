<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessTransferRequest extends FormRequest
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
            /*'court_id' => 'required',
            'street' => 'required',
            'no' => 'required',*/
            'owner_id'=>'required',
            'image_file'=>'required',
            'rent_price' => 'numeric',
            'total_area' => 'numeric',
            'transfer_fee' => 'numeric',
            'company_type' => 'required',
            'owner_note' => 'required',
            'district' => 'required',
            /*'video' => 'required',*/
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
            'title.required' => '请填写标题',
            'image_file.required'=>'图片不能为空',
            /*'court_id.required' => '请选择小区',
            'street.required' => '路不能为空',
            'no.required' => '号不能为空',*/
            'owner_id.required'=>'请填写房东电话',
            'rent_price.numeric' => '月租格式不正确',
            'total_area.numeric' => '面积格式不正确',
            'transfer_fee.numeric' => '转让费格式不正确',
            'company_type.required' => '经营类型不能为空',
            'owner_note.required' => '描述不能为空',
            'district.required' => '区域不能为空',
            /*'video.required' => '请上传视频',*/
        ];
    }
}
