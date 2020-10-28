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
 *
 * @package App\Models
 * @property int $id 主键ID
 * @property string $username 用户名
 * @property string $password 用户密码
 * @property string|null $remember_token 验证登录状态凭证
 * @property string|null $mobile 用户手机号
 * @property string|null $email 用户邮箱
 * @property \Illuminate\Support\Carbon|null $email_verified_at 邮箱验证时间
 * @property int $is_active 用户状态：1-启用；0-禁用
 * @property string|null $activation_token 激活令牌
 * @property string|null $avatar 用户头像
 * @property string|null $weixin_openid 微信openid
 * @property string|null $weixin_unionid 微信unionid
 * @property string|null $qq 用户QQ
 * @property \Illuminate\Support\Carbon|null $lastlogin_at 用户最后登录时间
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property \Illuminate\Support\Carbon|null $deleted_at 删除时间
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereActivationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastloginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereQq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereWeixinOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereWeixinUnionid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @mixin \Eloquent
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
