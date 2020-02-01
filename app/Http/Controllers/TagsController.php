<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * 标签控制器
 * Class InfosController
 * @package App\Http\Controllers
 */
class TagsController extends Controller
{
    /**
     * 信息列表
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return Tag::query()->paginate(7);
    }

    /**
     * 信息详情
     * @param Tag $tag
     * @return Tag
     */
    public function show(Tag $tag)
    {
        // 逻辑
        $infos = $tag
            ->infos()
            ->with(['channel:id,name,uri', 'comments'])
            ->paginate(10);

        // 渲染
        $name        = $tag->name;
        $title       = '含有' . $name . '的文章列表';
        $keywords    = $title;
        $description = $title;
        return view('tag', compact('infos', 'name', 'title', 'keywords', 'description'));
    }
}
