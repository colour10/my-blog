<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * 父类模型
 * Class Model
 * @package App\Models
 */
class Model extends BaseModel
{
    // 默认黑名单为空，也就是所有的字段都可以写入
    protected $guarded = [];
}
