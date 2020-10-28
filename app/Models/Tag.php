<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * 标签表
 * Class Tag
 *
 * @package App\Models
 * @property int $id 主键ID
 * @property string $name 标签名称
 * @property \Illuminate\Support\Carbon $created_at 创建时间
 * @property \Illuminate\Support\Carbon $updated_at 更新时间
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Info[] $infos
 * @property-read int|null $infos_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereUpdatedAt($value)
 * @mixin \Eloquent
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
