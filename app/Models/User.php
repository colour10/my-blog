<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * 用户模型
 * Class User
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;
    // 引入软删除
    use SoftDeletes;

    // 默认所有字段都可以写入
    protected $guarded = [];

    /**
     * 监听事件
     */
    protected static function boot()
    {
        parent::boot();
        // 用户创建之前生成activation_token
        static::creating(function ($user) {
            $user->activation_token = Str::random(10);
        });
    }

    /**
     * 隐藏密码字段
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    // 字段映射
    public static $Map = [
        'id'                => '编号',
        'username'          => '用户名',
        'password'          => '密码',
        'remember_token'    => 'Token',
        'mobile'            => '手机号码',
        'email'             => '邮箱',
        'email_verified_at' => '邮箱验证时间',
        'is_active'         => '用户状态',
        'weixin_openid'     => '微信openid',
        'weixin_unionid'    => '微信unionid',
        'qq'                => 'QQ号码',
        'lastlogin_at'      => '最后登陆时间',
        'created_at'        => '创建时间',
        'updated_at'        => '更新时间',
        'deleted_at'        => '删除时间',
    ];

    /**
     * 应被转换成日期的属性
     * @var array
     */
    protected $dates = [
        'lastlogin_at',
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * 密码自动加密
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        if (Hash::needsRehash($value)) {
            $value = bcrypt($value);
        }
        $this->attributes['password'] = $value;
    }
}
