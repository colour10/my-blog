<?php

namespace App\Admin\Actions\Info;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class BatchProtected extends BatchAction
{
    public $name = '批量受保护';

    public function dialog()
    {
        $this->confirm('批量受保护？');
    }

    public function handle(Collection $collection)
    {
        foreach ($collection as $model) {
            $model->update(['is_protected' => true]);
        }

        return $this->response()->success('批量受保护设置成功')->refresh();
    }

}
