<?php

namespace App\Http\Requests;

/**找回密码
 * Class ResetPasswordRequest
 * @package App\Http\Requests
 */
class ResetPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nameemail' => 'required|string|min:2',
        ];
    }

    public function attributes()
    {
        return [
            'nameemail' => '用户名或邮箱',
        ];
    }
}
