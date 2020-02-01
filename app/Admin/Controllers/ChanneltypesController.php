<?php

namespace App\Admin\Controllers;

use App\Models\Channeltype;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ChanneltypesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '频道类型管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Channeltype);

        $grid->column('id', __(Channeltype::$Map['id']));
        $grid->column('name', __(Channeltype::$Map['name']));
        $grid->column('description', __(Channeltype::$Map['description']));
        $grid->column('link', __(Channeltype::$Map['link']));
        $grid->column('created_at', __(Channeltype::$Map['created_at']));
        $grid->column('updated_at', __(Channeltype::$Map['updated_at']));

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
        $show = new Show(Channeltype::query()->findOrFail($id));

        $show->field('id', __(Channeltype::$Map['id']));
        $show->field('name', __(Channeltype::$Map['name']));
        $show->field('description', __(Channeltype::$Map['description']));
        $show->field('link', __(Channeltype::$Map['link']));
        $show->field('created_at', __(Channeltype::$Map['created_at']));
        $show->field('updated_at', __(Channeltype::$Map['updated_at']));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Channeltype);

        $form->text('name', __(Channeltype::$Map['name']));
        $form->text('description', __(Channeltype::$Map['description']));
        $form->url('link', __(Channeltype::$Map['link']));

        return $form;
    }
}
