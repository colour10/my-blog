<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 频道类型表
 * Class Channeltype
 *
 * @package App\Models
 * @property int $id 主键ID
 * @property string $name 名称
 * @property string|null $description 简介
 * @property string|null $link 外部链接地址
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property \Illuminate\Support\Carbon|null $deleted_at 删除时间
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Channel[] $channels
 * @property-read int|null $channels_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channeltype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channeltype newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channeltype onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channeltype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channeltype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channeltype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channeltype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channeltype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channeltype whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channeltype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channeltype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channeltype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Channeltype withoutTrashed()
 * @mixin \Eloquent
 */
class Channeltype extends Model
{
    // 引入软删除
    use SoftDeletes;

    // 字段映射
    public static $Map = [
        'id'          => '编号',
        'name'        => '名称',
        'link'        => '外部链接地址',
        'description' => '简介',
        'created_at'  => '创建时间',
        'updated_at'  => '更新时间',
        'deleted_at'  => '删除时间',
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
     * 获取频道类型列表
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
     * 频道类型-频道，一对多
     * @return HasMany
     */
    public function channels()
    {
        return $this->hasMany(Channel::class);
    }

}
