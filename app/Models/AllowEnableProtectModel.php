<?php

namespace App\Models;

/**
 * 需要做启用和保护的模型
 * Class Channel
 *
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AllowEnableProtectModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AllowEnableProtectModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AllowEnableProtectModel query()
 * @mixin \Eloquent
 */
class AllowEnableProtectModel extends Model
{
    /**
     * 设定启用状态列表
     * @return array
     */
    public static function getEnableSwitchStates()
    {
        return [
            'on'  => ['value' => 1, 'text' => '启用', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '禁用', 'color' => 'default'],
        ];
    }

    /**
     * 设定受保护状态列表
     * @return array
     */
    public static function getProtectedSwitchStates()
    {
        return [
            'on'  => ['value' => 1, 'text' => '受保护', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '非保护', 'color' => 'default'],
        ];
    }
}
