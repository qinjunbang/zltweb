<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRentalRequest extends FormRequest
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
            'sale_or_rental' => 'in:sale,rental',
            'title' => 'required',
            /*'court_id' => 'required',
            'street' => 'required',
            'no' => 'required',*/
            'rent_price' => 'numeric',
            'total_area' => 'numeric',
            'orientation_of_house' => 'numeric',
            'share_or_entire' => 'numeric',
/*            'total_floors' => 'numeric',
            'in_floors' => 'numeric',*/
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
            'sale_or_rental.in' => '不要修改表单',
            'title.required' => '标题不能为空',
            /*'court_id.required' => '请选择小区',
            'street.required' => '路不能为空',
            'no.required' => '号不能为空',*/
            'rent_price.numeric' => '月租格式不正确',
            'total_area.numeric' => '面积格式不正确',
            'orientation_of_house.numeric' => '请选择朝向',
            'share_or_entire.numeric' => '请选择租房类型',
            /*'total_floors.numeric' => '总楼层格式不正确',
            'in_floors.numeric' => '所在楼层格式不正确',*/
            'owner_note.required' => '描述不能为空',
            'district.required' => '区域不能为空',
            /*'video.required' => '请上传视频',*/
        ];
    }
}
