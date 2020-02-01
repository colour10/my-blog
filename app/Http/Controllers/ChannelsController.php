<?php

namespace App\Http\Controllers;

use App\Common\Err\ApiErrors;
use App\Models\Channel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * 频道控制器
 * Class ChannelsController
 * @package App\Http\Controllers
 */
class ChannelsController extends Controller
{
    /**
     * 频道详情
     *
     * @param $uri
     * @return Builder|Model
     */
    public function show($uri)
    {
        // 频道必须存在
        if (
            !$channel = Cache::remember('channel_' . $uri, 120, function () use ($uri) {
                return Channel::query()->where('uri', $uri)->first();
            })
        ) {
            abort(ApiErrors::ERROR_NOTFOUND[0], ApiErrors::ERROR_NOTFOUND[1]);
        }

        // 根据关联关系查询
        $infos = $channel
            ->infos()
            ->with(['channel:id,name,uri', 'tags', 'comments'])
            ->where('crontab_at', '<', Carbon::now())
            ->paginate(10);

        // 渲染
        $title       = $channel->title;
        $keywords    = $channel->keywords;
        $description = $channel->description;
        return view('channel', compact('channel', 'infos', 'title', 'keywords', 'description'));
    }
}
