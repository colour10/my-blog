<?php

namespace App\Http\Controllers;

use App\Common\Err\ApiErrors;
use App\Models\Channel;
use App\Models\Info;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;

/**
 * 信息控制器
 * Class InfosController
 * @package App\Http\Controllers
 */
class InfosController extends Controller
{
    /**
     * 信息列表
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return Info::query()->paginate(7);
    }

    /**
     * 信息详情
     * @param $uri
     * @param $id
     * @return Factory|View
     * @throws Exception
     */
    public function show($uri, $id)
    {
        // 频道不存在，则报404
        if (
            !$channel = Cache::remember('channel_' . $uri, 120, function () use ($uri) {
                return Channel::query()->select(['id'])->where('uri', $uri)->first();
            })
        ) {
            abort(ApiErrors::ERROR_NOTFOUND[0], ApiErrors::ERROR_NOTFOUND[1]);
        }

        // 如果信息不存在，则报404
        if (
            !$info = Cache::remember('info_' . $id, 120, function () use ($id) {
                return Info::query()
                    ->with(['channel:id,name,uri', 'tags:tags.id,tags.name'])
                    ->select([
                        'id',
                        'channel_id',
                        'title',
                        'keywords',
                        'description',
                        'content',
                        'click',
                        'sort',
                        'created_at',
                    ])
                    ->find($id);
            })
        ) {
            abort(ApiErrors::ERROR_NOTFOUND[0], ApiErrors::ERROR_NOTFOUND[1]);
        }

        // 如果信息和频道不匹配，则报404
        if ($info->channel_id != $channel->id) {
            abort(ApiErrors::ERROR_NOTFOUND[0], ApiErrors::ERROR_NOTFOUND[1]);
        }

        // 用户模型
        if (Session::has('user')) {
            $avatar = Gravatar::src(Session::get('user')['email']);
        } else {
            $avatar = '/static/images/ff4afbed206e455aa4b2561dc5f6344b.gif';
        }

        // 开始处理数据
        // 点击加1
        $info->update([
            'click' => $info->click + 1,
        ]);

        // 标签，并且筛选出关联文章
        $tagInfos     = [];
        $tempTagInfos = Cache::remember('tempTagInfos', 120, function () use ($info) {
            return $info->tags()->with(['infos:infos.id,infos.title,infos.channel_id'])->get()->pluck('infos')->toArray();
        });
        $tagInfos = Cache::remember('tagInfos', 120, function () use ($tempTagInfos, $id, $tagInfos) {
            foreach ($tempTagInfos as $tempTagInfo) {
                foreach ($tempTagInfo as $taginfo) {
                    // 同时也要把当前文章进行过滤
                    if (!isset($tagInfos[$taginfo['id']]) && $taginfo['id'] != $id) {
                        $taginfo['uri']           = Channel::query()->find($taginfo['channel_id'])->uri;
                        $tagInfos[$taginfo['id']] = $taginfo;
                    }
                }
            }
            // 返回
            return $tagInfos;
        });

        // 评论列表
        $comments = Cache::remember('comments', 120, function () use ($id) {
            return formatTreeForComments(Info::query()->find($id)->comments()->with(['user:id,username,avatar', 'parent:id,info_id,pid,user_id'])->select(['id', 'info_id', 'pid', 'user_id', 'content', 'created_at'])->get()->each(function ($comment) {
                // 时间格式化
                $comment->created_at_forhuman = Carbon::parse($comment->created_at)->diffForHumans();
                // 上级节点信息
                $parent                = $comment->parent;
                $comment->pid_username = $parent ? User::query()->select(['username'])->find($parent->user_id)->username : '';
            })->toArray());
        });

        // 变成数组，进行后续的操作
        $info = $info->toArray();
        // 三要素
        $title       = $info['title'];
        $keywords    = $info['keywords'];
        $description = $info['description'];
        // 标签
        $tags = Cache::remember('info_' . $info['id'] . '_tags', 120, function () use ($info) {
            return $info['tags'];
        });
        // 导航
        $breakcrumb = Cache::remember('info_' . $info['id'] . '_breakcrumb', 120, function () use ($info) {
            return '<a href="/">首页</a> > <a href="' . route('channels.show', ['uri' => $info['channel']['uri']]) . '">' . $info['channel']['name'] . '</a> > ';
        });

        // 上一篇
        $prev = Cache::remember('info_' . $info['id'] . '_prev', 120, function () use ($info) {
            return changeToArray(Info::query()
                ->with(['channel:id,name,uri'])
                ->where('channel_id', $info['channel_id'])
                ->where('sort', '<', $info['sort'])
                ->select(['id', 'channel_id', 'title'])
                ->first());
        });

        // 下一篇
        $next = Cache::remember('info_' . $info['id'] . '_next', 120, function () use ($info) {
            return changeToArray(Info::query()
                ->with(['channel:id,name,uri'])
                ->where('channel_id', $info['channel_id'])
                ->where('sort', '>', $info['sort'])
                ->select(['id', 'channel_id', 'title'])
                ->first());
        });

        // info_id也放进去
        $info_id = $id;

        // 渲染模版
        return view('info', compact('info', 'title', 'keywords', 'description', 'breakcrumb', 'tags', 'prev', 'next', 'tagInfos', 'comments', 'info_id', 'avatar'));
    }
}
