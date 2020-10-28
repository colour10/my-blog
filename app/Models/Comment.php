<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;

/**
 * 评论模型
 * Class Comment
 *
 * @package App\Models
 * @property int $id 主键ID
 * @property int|null $info_id 所属信息ID
 * @property int $pid 父节点ID
 * @property int|null $user_id 评论用户ID
 * @property string $content 评论内容
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property \Illuminate\Support\Carbon|null $deleted_at 删除时间
 * @property-read \App\Models\Info|null $info
 * @property-read \App\Models\Comment $parent
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereInfoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment withoutTrashed()
 * @mixin \Eloquent
 */
class Comment extends Model
{
    // 引入软删除
    use SoftDeletes;

    // 字段映射
    public static $Map = [
        'id'         => '编号',
        'info_id'    => '评论新闻',
        'pid'        => '所属父级ID',
        'user_id'    => '评论者',
        'content'    => '评论内容',
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

    /**
     * 评论-信息, 一对多反向
     * @return BelongsTo
     */
    public function info()
    {
        return $this->belongsTo(Info::class)->where('crontab_at', '<', Carbon::now());
    }

    /**
     * 评论-用户, 一对多反向
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 获取评论上级节点信息
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'pid');
    }

    /**
     * 当前文章下所有评论列表 [接口]
     * @param $id
     * @return Collection
     */
    public static function list($id)
    {
        // 逻辑
        $comments = DB::table('comments as c')
            ->select(['c.id', 'c.info_id', 'c.pid', 'c.user_id', 'c.content', 'c.created_at', 'c.updated_at', 'u.username', 'u.email'])
            ->leftJoin('infos as i', 'i.id', '=', 'c.info_id')
            ->leftJoin('users as u', 'u.id', '=', 'c.user_id')
            ->where('c.info_id', $id)
            ->get();
        // 时间人性化处理
        foreach ($comments as $k => $comment) {
            $comments[$k]->created_at_forhuman = Carbon::parse($comment->created_at)->diffForHumans();
            $comments[$k]->avatar              = Gravatar::src($comment->email);
            // 回复人姓名
            // 如果父节点是0，那么就是空
            if ($comment->pid) {
                $comments[$k]->pid_username = User::query()->find(Comment::query()->find($comment->pid)->user_id)->name;
            } else {
                $comments[$k]->pid_username = null;
            }
        }
        // 返回
        return $comments;
    }

    /**
     * 评论分层展示，格式化数据
     * @param $result
     * @param int $pid
     * @param int $level
     * @return array
     */
    public static function formatTree($result, $pid = 0, $level = 0)
    {
        // 初始化一个空数组
        $tree = [];
        // 逻辑
        foreach ($result as $v) {
            if ($v->pid == $pid) {
                $tree[] = [
                    'id'                  => $v->id,
                    'info_id'             => $v->info_id,
                    'pid'                 => $v->pid,
                    'pid_username'        => $v->pid_username,
                    'user_id'             => $v->user_id,
                    'user_name'           => $v->username,
                    'content'             => $v->content,
                    'created_at'          => $v->created_at,
                    'updated_at'          => $v->updated_at,
                    'created_at_forhuman' => $v->created_at_forhuman,
                    'avatar'              => $v->avatar,
                    'level'               => $level,
                ];
                // 接下来寻找自己分类
                $tree = array_merge($tree, self::formatTree($result, $v->id, $level + 1));
            }
        }
        // 返回结果
        return $tree;
    }

    /**
     * 取出格式化后的数组
     * 直接调用即可
     * @param int $id
     * @return array
     */
    public static function getTree($id)
    {
        // 逻辑
        return self::formatTree(self::list($id));
    }

    /**
     * 判断一条评论下面有没有子集分类
     */
    public function secondComments($id)
    {
        // 逻辑
        $comments = Comment::query()->where('pid', $id)->get();
        return $comments;
    }
}
