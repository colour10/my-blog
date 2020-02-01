<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Info\BatchCancleProtected;
use App\Admin\Actions\Info\BatchDisabled;
use App\Admin\Actions\Info\BatchEnabled;
use App\Admin\Actions\Info\BatchProtected;
use App\Models\Channel;
use App\Models\Channeltype;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ChannelsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '频道管理';

    /**
     * 原始图片地址
     * @var string
     */
    private $cover = '';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Channel);

        // 使用频道类型
        $grid->model()->with(['parent']);
        $grid->model()->with(['channeltype']);
        $grid->column('name', __(Channel::$Map['name']))->editable();
        $grid->column('uri', __(Channel::$Map['uri']))->editable();
        $grid->column('parent.name', __(Channel::$Map['pid']))->display(function ($value) {
            return $value ?: '顶级频道';
        });
        $grid->column('channeltype.name', __(Channel::$Map['channeltype_id']));
        $grid->column('sort', __(Channel::$Map['sort']))->editable();
        $grid->column('cover', __(Channel::$Map['cover']));
        $grid->column('page', __(Channel::$Map['page']))->editable();

        // 加入自定义批量操作按钮
        $grid->batchActions(function ($batch) {
            $batch->add(new BatchProtected());
            $batch->add(new BatchCancleProtected());
            $batch->add(new BatchEnabled());
            $batch->add(new BatchDisabled());
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Channel::query()->findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __(Channel::$Map['name']));
        $show->field('uri', __(Channel::$Map['uri']));
        $show->field('pid', __(Channel::$Map['pid']));
        $show->field('channeltype_id', __(Channel::$Map['channeltype_id']));
        $show->field('sort', __(Channel::$Map['sort']));
        $show->field('scontent', __(Channel::$Map['scontent']));
        $show->field('content', __(Channel::$Map['content']));
        $show->field('link', __(Channel::$Map['link']));
        $show->field('title', __(Channel::$Map['title']));
        $show->field('keywords', __(Channel::$Map['keywords']));
        $show->field('description', __(Channel::$Map['description']));
        $show->field('cover', __(Channel::$Map['cover']));
        $show->field('page', __(Channel::$Map['page']));
        $show->field('created_at', __(Channel::$Map['created_at']));
        $show->field('updated_at', __(Channel::$Map['updated_at']));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Channel);

        $form->text('name', __(Channel::$Map['name']))->rules('required');
        $form->text('uri', __(Channel::$Map['uri']))->rules('required');
        $form->select('pid', __(Channel::$Map['pid']))->options(Channel::alllist())->rules('required|min:0');
        $form->select('channeltype_id', __(Channel::$Map['channeltype_id']))->options(Channeltype::list())->rules('required|min:1');
        $form->number('sort', __(Channel::$Map['sort']));
        $form->ckeditor('scontent', __(Channel::$Map['scontent']));
        $form->ckeditor('content', __(Channel::$Map['content']));
        $form->url('link', __(Channel::$Map['link']));
        $form->text('title', __(Channel::$Map['title']));
        $form->text('keywords', __(Channel::$Map['keywords']));
        $form->text('description', __(Channel::$Map['description']));
        $form->image('cover', __(Channel::$Map['cover']));
        $form->number('page', __(Channel::$Map['page']))->default(10);

        // 定义事件回调，当模型即将保存时会触发这个回调
        $form->saving(function ($model) {
            // 如果sort为null，那么就设置为0
            if (is_null($model->sort)) {
                $model->sort = 0;
            }

            // 如果是修改, 则保存图片地址
            if ($model->id) {
                $this->cover = $model->cover;
            }
        });

        // 数据保存后，把sort按照id*10也保存进去
        $form->saved(function (Form $form) {
            // 新增则添加sort值
            if (empty($form->model()->sort)) {
                $id = $form->model()->id;
                Channel::query()->find($id)->update([
                    'sort' => $id * 10,
                ]);
            }

            // 判断图片地址是否发生了变化
            if ($this->cover != $form->model()->cover) {
                // 如果变化了，则删除之前的图片
                @unlink(public_path('uploads/' . $this->cover));
            }
        });

        return $form;
    }
}
