<?php

namespace App\Http\Requests;

/**
 * 留言板验证类
 * Class GuestbookRequest
 * @package App\Http\Requests
 */
class GuestbookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'   => 'required|string|min:2',
            'content' => 'required|string|min:10',
        ];
    }
}
