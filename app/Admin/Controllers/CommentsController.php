<?php

namespace App\Admin\Controllers;

use App\Models\Comment;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CommentsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '评论管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Comment);

        $grid->column('id', __(Comment::$Map['id']));
        $grid->column('info_id', __(Comment::$Map['info_id']));
        $grid->column('pid', __(Comment::$Map['pid']));
        $grid->column('user_id', __(Comment::$Map['user_id']));
        $grid->column('content', __(Comment::$Map['content']));
        $grid->column('created_at', __(Comment::$Map['created_at']));
        $grid->column('updated_at', __(Comment::$Map['updated_at']));

        // 留言不需要新增
        $grid->disableCreateButton();

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
        $show = new Show(Comment::query()->findOrFail($id));

        $show->field('id', __(Comment::$Map['id']));
        $show->field('info_id', __(Comment::$Map['info_id']));
        $show->field('pid', __(Comment::$Map['pid']));
        $show->field('user_id', __(Comment::$Map['user_id']));
        $show->field('content', __(Comment::$Map['content']));
        $show->field('created_at', __(Comment::$Map['created_at']));
        $show->field('updated_at', __(Comment::$Map['updated_at']));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Comment);

        $form->number('info_id', __(Comment::$Map['info_id']));
        $form->number('pid', __(Comment::$Map['pid']));
        $form->number('user_id', __(Comment::$Map['user_id']));
        $form->textarea('content', __(Comment::$Map['content']));

        return $form;
    }
}
