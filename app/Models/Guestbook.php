<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 留言模型
 * Class Guestbook
 *
 * @package App\Models
 * @property int $id 主键ID
 * @property int|null $user_id 用户ID
 * @property string|null $title 标题
 * @property string $content 内容
 * @property string|null $answer 管理员回复
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property \Illuminate\Support\Carbon|null $deleted_at 删除时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Guestbook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Guestbook newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Guestbook onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Guestbook query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Guestbook whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Guestbook whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Guestbook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Guestbook whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Guestbook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Guestbook whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Guestbook whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Guestbook whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Guestbook withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Guestbook withoutTrashed()
 * @mixin \Eloquent
 */
class Guestbook extends Model
{
    // 引入软删除
    use SoftDeletes;

    // 字段映射
    public static $Map = [
        'id'         => '编号',
        'title'      => '留言标题',
        'user_id'    => '留言者',
        'content'    => '留言内容',
        'answer'     => '管理员回复内容',
        'created_at' => '创建时间',
        'updated_at' => '更新时间',
        'deleted_at' => '删除时间',
    ];

    /**
     * 应被转换成日期的属性
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
