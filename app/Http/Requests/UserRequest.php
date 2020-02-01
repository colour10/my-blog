<?php

namespace App\Http\Requests;

/**
 * 用户验证类
 * Class UserRequest
 * @package App\Http\Requests
 */
class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'username'  => 'required_without:nameemail|string|min:2|unique:users,username',
            'nameemail' => 'required_without:username|string',
            'password'  => 'required|min:6',
        ];
        if ($this->email) {
            $rules['email'] = 'required|email|unique:users,email';
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'nameemail' => '用户名或邮箱',
        ];
    }
}
