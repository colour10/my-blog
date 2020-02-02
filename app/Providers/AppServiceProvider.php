<?php

namespace App\Providers;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Comment;
use App\Models\Info;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Carbon::setLocale('zh');

        // 视图Composer共享数据-前台
        view()->composer('*', function ($view) {
            // 作者
            $author = '刘宗阳-liuzongyang';
            // 总标题
            $webname = '-【刘宗阳博客】';
            // 路由信息
            $routeInfo = Controller::getRouteInfo();
            // 导航
            $navs = Cache::remember('navs', 120, function () {
                return Channel::frontList();
            });

            // 生成每个栏目下面的子分类个数
            $subsnav_counts = Cache::remember('subsnav_counts', 120, function () use ($navs) {
                foreach ($navs as $k => $nav) {
                    $subsnav_counts[$nav['id']] = $nav->subs($nav['id'])->count();
                }
                return $subsnav_counts;
            });

            // 转成数组
            $navs = $navs->toArray();
            // 热门文章，默认2小时过期
            $hotInfos = Cache::remember('hotInfos', 120, function () {
                return Info::query()
                    ->with(['channel:id,uri'])
                    ->select(
                        [
                            'id',
                            'channel_id',
                            'crontab_at',
                            'title',
                            'click',
                        ]
                    )
                    ->orderByDesc('click')
                    ->take(5)
                    ->get()
                    ->toArray();
            });
            // 最新评论
            $recentComments = Cache::remember('recentComments', 120, function () {
                return Comment::query()
                    ->with(
                        [
                            'user:id,username,email',
                            'info:id,channel_id,title',
                        ]
                    )
                    ->select(
                        [
                            'id',
                            'info_id',
                            'user_id',
                            'content',
                            'created_at',
                        ]
                    )
                    ->take(5)
                    ->get()
                    ->each(function ($comment) {
                        // 频道
                        $comment->channel = $comment->info->channel()->select(['id', 'uri'])->first()->toArray();
                        // 头像
                        $comment->avatar              = Gravatar::src($comment->user->email);
                        $comment->created_at_forhuman = Carbon::parse($comment->created_at)->diffForHumans();
                    })
                    ->toArray();
            });
            // tag标签列表，并且记录文章数
            $allTags = Cache::remember('allTags', 120, function () {
                return Tag::query()
                    ->select(['id', 'name'])
                    ->orderBy('id', 'asc')
                    ->withCount(['infos'])
                    ->get()
                    ->toArray();
            });
            // 赋值
            $view->with(compact('author', 'webname', 'routeInfo', 'navs', 'subsnav_counts', 'hotInfos', 'recentComments', 'allTags'));
        });
    }
}
