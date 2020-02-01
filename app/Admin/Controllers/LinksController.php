<?php

namespace App\Admin\Controllers;

use App\Models\Link;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class LinksController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '友情链接管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Link);

        $grid->column('name', __(Link::$Map['name']));
        $grid->column('url', __(Link::$Map['url']));
        $grid->column('created_at', __(Link::$Map['created_at']));
        $grid->column('updated_at', __(Link::$Map['updated_at']));

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
        $show = new Show(Link::query()->findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __(Link::$Map['name']));
        $show->field('url', __(Link::$Map['url']));
        $show->field('created_at', __(Link::$Map['created_at']));
        $show->field('updated_at', __(Link::$Map['updated_at']));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Link);

        $form->text('name', __(Link::$Map['name']));
        $form->url('url', __(Link::$Map['url']))->creationRules(['required', "unique:links"])->updateRules(['required', "unique:links,url,{{id}}"]);

        return $form;
    }
}
