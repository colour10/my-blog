<?php

namespace App\Admin\Actions\Channel;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class BatchEnabled extends BatchAction
{
    public $name = '批量启用';

    public function dialog()
    {
        $this->confirm('批量启用？');
    }

    public function handle(Collection $collection)
    {
        foreach ($collection as $model) {
            $model->update(['is_enabled' => true]);
        }

        return $this->response()->success('批量启用设置成功')->refresh();
    }

}
