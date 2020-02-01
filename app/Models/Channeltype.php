<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 频道类型表
 * Class Channeltype
 * @package App\Models
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
