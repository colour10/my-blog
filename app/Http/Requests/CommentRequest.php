<?php

namespace App\Http\Requests;

class CommentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment_post_ID' => 'required|integer',
            'comment_parent'  => 'required|integer',
            'user_id'         => 'required|integer',
            'comment'         => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'comment_post_ID' => '信息ID',
            'comment_parent'  => '评论父级ID',
            'user_id'         => '用户ID',
            'comment'         => '评论内容',
        ];
    }
}
