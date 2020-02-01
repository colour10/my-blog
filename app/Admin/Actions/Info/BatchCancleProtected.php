<?php

namespace App\Admin\Actions\Info;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class BatchCancleProtected extends BatchAction
{
    public $name = '批量非保护';

    public function dialog()
    {
        $this->confirm('批量非保护？');
    }

    public function handle(Collection $collection)
    {
        foreach ($collection as $model) {
            $model->update(['is_protected' => false]);
        }

        return $this->response()->success('批量非保护设置成功')->refresh();
    }

}
