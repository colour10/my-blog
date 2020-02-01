<?php

namespace App\Http\Controllers;

use App\Common\Err\ApiErrors;
use App\Http\Requests\GuestbookRequest;
use App\Models\Guestbook;
use App\Traits\ResponseJson;
use Illuminate\Http\Response;

/**
 * 留言板控制器
 * Class InfosController
 * @package App\Http\Controllers
 */
class GuestbooksController extends Controller
{

    use ResponseJson;

    /**
     * 留言板列表
     *
     * @return Response
     */
    public function index()
    {
        // 渲染
        $title       = '留言板';
        $keywords    = $title;
        $description = $title;
        return view('guestbook', compact('title', 'keywords', 'description'));
    }

    /**
     * 留言板提交
     * @param GuestbookRequest $request
     * @return array
     */
    public function store(GuestbookRequest $request)
    {
        // 逻辑
        $user_id = $request->user()->id;
        $title   = $request->input('title');
        $content = $request->input('content');
        // 提交
        if (!Guestbook::query()->create(compact('user_id', 'title', 'content'))) {
            return $this->jsonFail(ApiErrors::ERROR_GUESTBOOKS_SUBMIT_FAILED[0], ApiErrors::ERROR_GUESTBOOKS_SUBMIT_FAILED[1]);
        }
        return $this->jsonSuccess([], '留言提交成功');
    }
}
