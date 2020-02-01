<?php

namespace App\Http\Controllers;

use App\Common\Err\ApiErrors;
use App\Models\Info;
use App\Traits\ResponseJson;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

/**
 * 首页控制器
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{

    use ResponseJson;

    /**
     * 首页
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        // 获取三要素
        $title       = config('website.title');
        $keywords    = config('website.keywords');
        $description = config('website.description');

        // 信息列表
        $infos = Info::query()
            ->with(['channel:id,name,uri', 'tags', 'comments', 'upvotes'])
            ->where('crontab_at', '<', Carbon::now())
            ->where(function ($query) use ($request) {
                $keyword = $request->input('keyword');
                $query->where('title', 'like binary', '%' . $keyword . '%');
            })
            ->orderBy('crontab_at', 'desc')
            ->paginate(10);

        // 渲染模版
        return view('index', compact('title', 'keywords', 'description', 'infos', 'request'));
    }

    /**
     * 退出登陆
     */
    public function logout()
    {
        Session::forget('user');
        return $this->jsonSuccess();
    }

    /**
     * 判断是否登陆
     */
    public function isLogin()
    {
        if (!Session::has('user')) {
            return $this->jsonFail(ApiErrors::ERROR_NOTLOGIN[0], ApiErrors::ERROR_NOTLOGIN[1]);
        }
        // 否则就是已经登陆了
        return $this->jsonSuccess(Session::get('user'));
    }
}
