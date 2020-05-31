<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserRequest extends FormRequest
{
    // authorize() 方法是表单验证自带的另一个功能 —— 权限验证
    public function authorize()
    {
        return true; // 此处我们 return true; ，意味所有权限都通过即可
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9]+$/|unique:users,name,' . Auth::id() . 'id',
            'email' => 'required|email',
            'introducton' => 'max:80',
        ];
    }

    // 自定义错误消息
    public function messages()
    {
        return [
            'name.unique' => '用户名已被占用，请重新填写',
            'name.regex' => '用户名只支持英文、数字、横杠和下划线。',
            'name.between' => '用户名必须介于 3 - 25 个字符之间。',
            'name.required' => '用户名不能为空。',
        ];
    }

    // 自定义验证属性
    // public function attributes()
    // {
    //     return [
    //         'name' => '用户名',
    //     ];
    // }
}
