<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * 标签表
 * Class Tag
 * @package App\Models
 */
class Tag extends Model
{
    /**
     * 信息-标签，多对多，需要筛选出已发布的文章，未发布的文章不显示
     * @return BelongsToMany
     */
    public function infos()
    {
        return $this->belongsToMany(Info::class)->where('crontab_at', '<', Carbon::now());
    }
}
