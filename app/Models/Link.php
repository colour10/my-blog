<?php

namespace App\Models;

/**
 * 友情链接模型
 * Class Link
 * @package App\Models
 */
class Link extends Model
{
    // 字段映射
    public static $Map = [
        'id'         => '编号',
        'name'       => '名称',
        'url'        => '链接地址',
        'created_at' => '创建时间',
        'updated_at' => '更新时间',
    ];
}
