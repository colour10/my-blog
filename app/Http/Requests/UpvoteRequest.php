<?php

namespace App\Http\Requests;

/**
 * 点赞验证
 * Class UpvoteRequest
 * @package App\Http\Requests
 */
class UpvoteRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uid' => 'required|integer|exists:users,id',
            'pid' => 'required|integer|exists:infos,id',
        ];
    }

    public function attributes()
    {
        return [
            'uid' => '用户',
            'pid' => '信息',
        ];
    }
}
