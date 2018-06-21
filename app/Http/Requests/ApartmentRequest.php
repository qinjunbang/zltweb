<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApartmentRequest extends FormRequest
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
            'image_file'=>'required',
            'title' => 'required',
            'owner_id'=>'required',
            'court_id' => 'required',
            'building' => 'required',
            'unit' => 'required',
            'room' => 'required',
            'rent_price' => 'numeric',
            'total_area' => 'numeric',
            'orientation_of_house' => 'numeric',
            'share_or_entire' => 'numeric',
            'payment_method' => 'numeric',
            'decorate_model' => 'numeric',
            /*'total_floors' => 'numeric',
            'in_floors' => 'numeric',*/
            'chambers' => 'required',
            'halls' => 'required',
            'bathrooms' => 'required',
            'owner_note' => 'required',
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
            'image_file.required'=>'图片不能为空',
            'owner_id.required'=>'请填写房东号码',
            'court_id.required' => '请选择小区',
            'building.required' => '几幢不能为空',
            'unit.required' => '几单元(号)不能为空',
            'room.required' => '几室不能为空',
            'rent_price.numeric' => '月租格式不正确',
            'total_area.numeric' => '面积格式不正确',
            'orientation_of_house.numeric' => '请选择朝向',
            'share_or_entire.numeric' => '请选择租房类型',
            'payment_method.numeric' => '请选择付款方式',
            'decorate_model.numeric' => '请选择装修情况',
            /*'total_floors.numeric' => '总楼层格式不正确',
            'in_floors.numeric' => '所在楼层格式不正确',*/
            'chambers.required' => '室不能为空',
            'halls.required' => '厅不能为空',
            'bathrooms.required' => '卫不能为空',
            'owner_note.required' => '描述不能为空',
            /*'video.required' => '请上传视频',*/
        ];
    }

}
