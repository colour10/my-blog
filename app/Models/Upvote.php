<?php

namespace App\Models;

/**
 * 赞关系表
 * Class Upvote
 *
 * @package App\Models
 * @property int $id 主键ID
 * @property int|null $user_id 用户ID
 * @property int|null $info_id 信息ID
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upvote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upvote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upvote query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upvote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upvote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upvote whereInfoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upvote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upvote whereUserId($value)
 * @mixin \Eloquent
 */
class Upvote extends Model
{
}
