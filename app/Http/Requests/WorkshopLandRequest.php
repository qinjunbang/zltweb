<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkshopLandRequest extends FormRequest
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


    //储存数据
    public function adddata(array $data)
    {

         $model = new static($data);

        $model->save();

        return $model;
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
            /*'contact_number' => 'numeric',*/
            'owner_id'=>'required',
            'image_file'=>'required',
            'total_area' => 'numeric',
            'district' => 'required',
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
            'title.required' => '标题不能为空',
            'owner_id.required'=>'请填写房东电话',
            'image_file.required'=>'图片不能为空',
            'contact_number.numeric' => '电话格式不正确',
            'total_area.numeric' => '面积格式不正确',
            'district.required' => '区域不能为空',
            'owner_note.required' => '描述不能为空',
            /*'video.required' => '请上传视频',*/
        ];
    }
}
