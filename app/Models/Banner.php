<?php

namespace App\Models;

/**
 * 幻灯片模型
 * Class Banner
 * @package App\Models
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
