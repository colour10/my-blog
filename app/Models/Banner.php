<?php

namespace App\Models;

/**
 * 幻灯片模型
 * Class Banner
 *
 * @package App\Models
 * @property int $id 主键ID
 * @property string|null $name 名称
 * @property string|null $url 上传路径
 * @property int $sort 排序
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereUrl($value)
 * @mixin \Eloquent
 */
class Banner extends AllowEnableProtectModel
{
    // 字段映射
    public static $Map = [
        'id'         => '编号',
        'name'       => '名称',
        'url'        => '链接地址',
        'sort'       => '排序',
        'created_at' => '创建时间',
        'updated_at' => '更新时间',
    ];
}
