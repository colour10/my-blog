<?php

namespace App\Http\Controllers;

use App\Models\Tag;

/**
 * 标签控制器
 * Class InfosController
 * @package App\Http\Controllers
 */
class TagsController extends Controller
{
    /**
     * 标签详情
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
