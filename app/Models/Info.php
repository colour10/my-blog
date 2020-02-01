<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Info extends AllowEnableProtectModel
{
    // 引入软删除
    use SoftDeletes;

    // 统计计数
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
        'created_at',
        'updated_at',
        'deleted_at',
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
     * @param integer $user_id
     * @return HasOne
     */
    public function upvote($user_id)
    {
        return $this->hasOne(Upvote::class)->where('user_id', $user_id);
    }
}
