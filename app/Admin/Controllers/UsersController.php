<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->column('username', __(User::$Map['username']));
        $grid->column('mobile', __(User::$Map['mobile']));
        $grid->column('email', __(User::$Map['email']));
        $grid->column('weixin_openid', __(User::$Map['weixin_openid']));
        $grid->column('qq', __(User::$Map['qq']));
        $grid->column('lastlogin_at', __(User::$Map['lastlogin_at']));
        $grid->column('created_at', __(User::$Map['created_at']));

        // 后台不需要创建用户
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
        $show = new Show(User::query()->findOrFail($id));

        $show->field('username', __(User::$Map['username']));
        $show->field('mobile', __(User::$Map['mobile']));
        $show->field('email', __(User::$Map['email']));
        $show->field('weixin_openid', __(User::$Map['weixin_openid']));
        $show->field('qq', __(User::$Map['qq']));
        $show->field('lastlogin_at', __(User::$Map['lastlogin_at']));
        $show->field('created_at', __(User::$Map['created_at']));
        $show->field('updated_at', __(User::$Map['updated_at']));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->text('username', __(User::$Map['username']));
        $form->mobile('mobile', __(User::$Map['mobile']));
        $form->email('email', __(User::$Map['email']));
        $form->text('weixin_openid', __(User::$Map['weixin_openid']));
        $form->text('qq', __(User::$Map['qq']));
        $form->datetime('lastlogin_at', __(User::$Map['lastlogin_at']))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
