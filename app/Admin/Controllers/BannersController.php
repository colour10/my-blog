<?php

namespace App\Admin\Controllers;

use App\Models\Banner;
use App\Models\Channel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BannersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '幻灯管理';

    /**
     * 原始图片地址
     * @var string
     */
    private $url = '';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Banner);

        // 默认按sort倒序排序
        $grid->model()->orderBy('sort', 'desc');

        $grid->column('name', __(Banner::$Map['name']));
        $grid->column('url', __(Banner::$Map['url']));
        $grid->column('sort', __(Banner::$Map['sort']))->editable();
        $grid->column('created_at', __(Banner::$Map['created_at']));
        $grid->column('updated_at', __(Banner::$Map['updated_at']));

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
        $show = new Show(Banner::query()->findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __(Banner::$Map['name']));
        $show->field('url', __(Banner::$Map['url']));
        $show->field('sort', __(Banner::$Map['sort']));
        $show->field('created_at', __(Banner::$Map['created_at']));
        $show->field('updated_at', __(Banner::$Map['updated_at']));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Banner);

        $form->text('name', __(Banner::$Map['name']));
        $form->file('url', __(Banner::$Map['url']))->uniqueName();
        $form->number('sort', __(Banner::$Map['sort']));

        // 定义事件回调，当模型即将保存时会触发这个回调
        // 如果sort为null，那么就设置为0
        $form->saving(function ($model) {
            if (is_null($model->sort)) {
                $model->sort = 0;
            }
            // 如果是修改, 则保存图片地址
            if ($model->id) {
                $this->url = $model->url;
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
            if ($this->url != $form->model()->url) {
                // 如果变化了，则删除之前的图片
                @unlink(public_path('uploads/' . $this->url));
            }
        });

        return $form;
    }
}
