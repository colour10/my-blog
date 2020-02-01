<?php

namespace App\Admin\Actions\Info;

use Encore\Admin\Actions\BatchAction;
use Encore\Admin\Actions\Response;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Channel;
use Illuminate\Http\Request;

class BatchMove extends BatchAction
{
    public $name = '批量移动';

    /**
     * 弹出一个表单用来接收移动到的频道
     */
    public function form()
    {
        $this->select('channel_id', '所属频道')->options(Channel::list());
    }

    /**
     * 具体处理逻辑
     * @param Collection $collection
     * @param Request $request
     * @return Response
     */
    public function handle(Collection $collection, Request $request)
    {
        foreach ($collection as $model) {
            $model->update(['channel_id' => $request->input('channel_id')]);
        }

        return $this->response()->success('批量移动成功')->refresh();
    }

}
