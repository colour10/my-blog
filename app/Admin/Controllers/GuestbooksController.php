<?php

namespace App\Admin\Controllers;

use App\Models\Guestbook;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GuestbooksController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '留言板管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Guestbook);

        $grid->column('id', __(Guestbook::$Map['id']));
        $grid->column('user_id', __(Guestbook::$Map['user_id']));
        $grid->column('title', __(Guestbook::$Map['title']));
        $grid->column('content', __(Guestbook::$Map['content']));
        $grid->column('answer', __(Guestbook::$Map['answer']));
        $grid->column('created_at', __(Guestbook::$Map['created_at']));
        $grid->column('updated_at', __(Guestbook::$Map['updated_at']));

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
        $show = new Show(Guestbook::findOrFail($id));

        $show->field('id', __(Guestbook::$Map['id']));
        $show->field('user_id', __(Guestbook::$Map['user_id']));
        $show->field('title', __(Guestbook::$Map['title']));
        $show->field('content', __(Guestbook::$Map['content']));
        $show->field('answer', __(Guestbook::$Map['answer']));
        $show->field('created_at', __(Guestbook::$Map['created_at']));
        $show->field('updated_at', __(Guestbook::$Map['updated_at']));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Guestbook);

        $form->number('user_id', __(Guestbook::$Map['user_id']));
        $form->text('title', __(Guestbook::$Map['title']));
        $form->textarea('content', __(Guestbook::$Map['content']));
        $form->textarea('answer', __(Guestbook::$Map['answer']));

        return $form;
    }
}
