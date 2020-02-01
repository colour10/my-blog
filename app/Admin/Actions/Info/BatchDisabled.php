<?php

namespace App\Admin\Actions\Info;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class BatchDisabled extends BatchAction
{
    public $name = '批量禁用';

    public function dialog()
    {
        $this->confirm('批量禁用？');
    }

    public function handle(Collection $collection)
    {
        foreach ($collection as $model) {
            $model->update(['is_enabled' => false]);
        }

        return $this->response()->success('批量禁用设置成功')->refresh();
    }

}
