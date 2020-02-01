<?php

namespace App\Http\Controllers;

use App\Common\Err\ApiErrors;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Traits\ResponseJson;

/**
 * 评论控制器
 * Class InfosController
 * @package App\Http\Controllers
 */
class CommentsController extends Controller
{

    use ResponseJson;

    /**
     * 评论列表
     * @param CommentRequest $request
     * @return array
     */
    public function store(CommentRequest $request)
    {
        // 逻辑
        // 验证
        $info_id = $request->input('comment_post_ID');
        $pid     = $request->input('comment_parent');
        $user_id = $request->input('user_id');
        $content = $request->input('comment');

        // 提交
        if ($comment = Comment::query()->create(compact('info_id', 'pid', 'user_id', 'content'))) {
            return $this->jsonSuccess(new CommentResource($comment), '评论提交成功');
        } else {
            return $this->jsonFail(ApiErrors::ERROR_COMMENTS_SUBMIT_FAILED[0], ApiErrors::ERROR_COMMENTS_SUBMIT_FAILED[1]);
        }
    }
}
