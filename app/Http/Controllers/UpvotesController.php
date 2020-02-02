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
        $upvote  = Info::query()->find($info_id)->upvote($user_id);
        // 如果存在赞，则取消
        switch ($upvote->exists()) {
            case true:
                $upvote->delete();
                break;
            default:
                Upvote::query()->create([
                    'info_id' => $info_id,
                    'user_id' => $user_id,
                ]);
        }
        // 返回点赞数
        return $this->jsonSuccess([
            'upvotes_count' => Info::query()->find($info_id)->upvotes_count,
        ]);
    }
}
