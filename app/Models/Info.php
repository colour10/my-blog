<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Info
 *
 * @property int $id 主键ID
 * @property string $title 标题
 * @property int|null $channel_id 所属频道ID
 * @property string|null $scontent 简介
 * @property string $content 完整介绍
 * @property string|null $keywords SEO关键字
 * @property string|null $description SEO描述
 * @property string|null $cover 封面图片地址
 * @property int|null $click 读取次数
 * @property int|null $sort 排序
 * @property \Illuminate\Support\Carbon|null $crontab_at 定时发布时间
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property \Illuminate\Support\Carbon|null $deleted_at 删除时间
 * @property-read \App\Models\Channel|null $channel
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Upvote[] $upvotes
 * @property-read int|null $upvotes_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Info onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info whereClick($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info whereCrontabAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info whereScontent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Info whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Info withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Info withoutTrashed()
 * @mixin \Eloquent
 */
class Info extends AllowEnableProtectModel
{
    // 引入软删除
    use SoftDeletes;

    // 统计次数
    protected $withCount = ['comments', 'tags', 'upvotes'];

    // 字段映射
    public static $Map = [
        'id'          => '编号',
        'title'       => '名称',
        'channel_id'  => '所属频道',
        'scontent'    => '简介',
        'content'     => '完整介绍',
        'keywords'    => 'SEO关键字',
        'description' => 'SEO描述',
        'cover'       => '封面图片',
        'click'       => '点击次数',
        'sort'        => '排序',
        'crontab_at'  => '定时发布时间',
        'created_at'  => '创建时间',
        'updated_at'  => '更新时间',
        'deleted_at'  => '删除时间',
    ];

    /**
     * 应被转换成日期的属性
     * @var array
     */
    protected $dates = [
        'crontab_at',
    ];

    /**
     * 信息-频道，一对多反向
     * @return BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * 信息-标签，多对多
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * 信息-评论，一对多
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * 信息-赞，一对多
     * @return HasMany
     */
    public function upvotes()
    {
        return $this->hasMany(Upvote::class);
    }

    /**
     * 信息-赞，针对一个用户，一对一
     * @param $user_id -用户id
     * @return HasOne
     */
    public function upvote($user_id)
    {
        return $this->hasOne(Upvote::class)->where('user_id', $user_id);
    }
}
