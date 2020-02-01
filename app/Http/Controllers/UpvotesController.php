<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpvoteRequest;
use App\Models\Info;
use App\Models\Upvote;
use App\Traits\ResponseJson;

/**
 * 点赞控制器
 * Class UpvotesController
 * @package App\Http\Controllers
 */
class UpvotesController extends Controller
{
    use ResponseJson;

    /**
     * Store a newly created resource in storage.
     *
     * @param UpvoteRequest $request
     * @return array
     */
    public function store(UpvoteRequest $request)
    {
        // 判断info_id和user_id是否有值
        $user_id = $request->input('uid');
        $info_id = $request->input('pid');
        $info    = Info::query()->find($info_id);
        $upvote  = $info->upvote($user_id);
        // 如果存在赞，则取消
        if ($upvote->exists()) {
            $upvote->delete();
        } else {
            Upvote::query()->create([
                'info_id' => $info_id,
                'user_id' => $user_id,
            ]);
        }
        // 统计赞
        // 返回成功
        return $this->jsonSuccess([
            'upvotes_count' => $info->upvotes_count,
        ]);
    }
}
