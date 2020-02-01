<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 留言模型
 * Class Guestbook
 * @package App\Models
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
