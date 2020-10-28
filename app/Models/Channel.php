<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 频道模型
 * Class Channel
 *
 * @package App\Models
 * @property int $id 主键ID
 * @property string $name 名称
 * @property string|null $uri uri路径英文名称
 * @property int|null $pid 父类ID，0为顶级分类
 * @property int|null $channeltype_id 类型
 * @property int|null $sort 排序
 * @property string|null $scontent 简介
 * @property string|null $content 完整介绍
 * @property string|null $link 外部链接地址
 * @property string|null $title SEO标题
 * @property string|null $keywords SEO关键字
 * @property string|null $description SEO描述
 * @property string|null $cover 封面图片地址
 * @property int|null $page 分页
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property \Illuminate\Support\Carbon|null $deleted_at 删除时间
 * @property-read \App\Models\Channeltype|null $channeltype
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Info[] $infos
 * @property-read int|null $infos_count
 * @property-read \App\Models\Channel|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereChanneltypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereScontent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereUri($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channel withoutTrashed()
 * @mixin \Eloquent
 */
class Channel extends AllowEnableProtectModel
{
    // 引入软删除
    use SoftDeletes;

    // 字段映射
    public static $Map = [
        'id'             => '编号',
        'name'           => '名称',
        'uri'            => '英文路径',
        'pid'            => '所属频道',
        'channeltype_id' => '频道类型',
        'sort'           => '排序',
        'scontent'       => '简介',
        'content'        => '完整介绍',
        'link'           => '外部链接地址',
        'title'          => 'SEO标题',
        'keywords'       => 'SEO关键字',
        'description'    => 'SEO描述',
        'cover'          => '封面图片',
        'page'           => '分页',
        'created_at'     => '创建时间',
        'updated_at'     => '更新时间',
        'deleted_at'     => '删除时间',
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
     * 获取频道列表（不包含顶级频道）
     * @return array
     */
    public static function list()
    {
        $options      = self::query()->select(['id', 'name as text'])->get()->toArray();
        $selectOption = [];
        foreach ($options as $option) {
            $selectOption[$option['id']] = $option['text'];
        }
        return $selectOption;
    }

    /**
     * 获取频道列表（包含顶级频道）
     * @return array
     */
    public static function alllist()
    {
        return ['0' => '顶级频道'] + self::list();
    }

    /**
     * 频道-频道类型，一对多反向
     * @return BelongsTo
     */
    public function channeltype()
    {
        return $this->belongsTo(Channeltype::class);
    }

    /**
     * 频道-频道上级，一对多反向
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Channel::class, 'pid');
    }

    /**
     * 前台首页频道列表
     *
     * @return array
     */
    public static function frontList()
    {
        return self::query()
            ->select(['id', 'uri', 'name', 'pid'])
            ->get();
    }

    /**
     * 判断指定的频道是否有子分类，用在频道模型上
     * @param integer 分类的ID号
     * @return HasMany
     */
    public function subs($id)
    {
        return $this->hasMany(Channel::class, 'pid', 'id')->where('pid', $id);
    }

    /**
     * 频道-信息，一对多
     * @return HasMany
     */
    public function infos()
    {
        return $this->hasMany(Info::class);
    }

}
