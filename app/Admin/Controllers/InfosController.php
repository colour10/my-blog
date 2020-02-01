<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Info\BatchCancleProtected;
use App\Admin\Actions\Info\BatchDisabled;
use App\Admin\Actions\Info\BatchEnabled;
use App\Admin\Actions\Info\BatchMove;
use App\Admin\Actions\Info\BatchProtected;
use App\Models\Channel;
use App\Models\Info;
use App\Models\Tag;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Grid\Filter;

class InfosController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '信息管理';

    /**
     * 原始图片地址
     * @var string
     */
    private $cover = '';

    /**
     * 用来记录用户状态变化
     */
    private $beforeKeywords;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Info);

        // 引入与频道的关系
        $grid->model()->with(['channel']);

        // 默认按sort倒序排序
        $grid->model()->orderBy('sort', 'desc');

        $grid->column('title', __(Info::$Map['title']))->editable();
        $grid->column('channel.name', __(Info::$Map['channel_id']));
        $grid->column('keywords', __(Info::$Map['keywords']));

        $grid->column('click', __(Info::$Map['click']))->editable();
        $grid->column('sort', __(Info::$Map['sort']))->editable();
        $grid->column('crontab_at', __(Info::$Map['crontab_at']))->editable('datetime');
        $grid->column('created_at', __(Info::$Map['created_at']));
        $grid->column('updated_at', __(Info::$Map['updated_at']));

        // 筛选
        // 定义过滤条件
        $grid->filter(function (Filter $filter) {
            // 频道
            $filter->equal('channel_id', Info::$Map['channel_id'])->radio(Channel::list());
        });

        // 加入自定义批量操作按钮
        $grid->batchActions(function ($batch) {
            $batch->add(new BatchProtected());
            $batch->add(new BatchCancleProtected());
            $batch->add(new BatchEnabled());
            $batch->add(new BatchDisabled());
            $batch->add(new BatchMove());
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
        $show = new Show(Info::query()->findOrFail($id));

        $show->field('title', __(Info::$Map['title']));
        $show->field('channel_id', __(Info::$Map['channel_id']));
        $show->field('scontent', __(Info::$Map['scontent']));
        $show->field('content', __(Info::$Map['content']));
        $show->field('keywords', __(Info::$Map['keywords']));
        $show->field('description', __(Info::$Map['description']));
        $show->field('cover', __(Info::$Map['cover']));
        $show->field('click', __(Info::$Map['click']));
        $show->field('sort', __(Info::$Map['sort']));
        $show->field('crontab_at', __(Info::$Map['crontab_at']));
        $show->field('created_at', __(Info::$Map['created_at']));
        $show->field('updated_at', __(Info::$Map['updated_at']));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Info);

        $form->text('title', __(Info::$Map['title']))->rules('required');

        $form->select('channel_id', __(Info::$Map['channel_id']))->options(Channel::list())->rules('required');

        $form->ckeditor('scontent', __(Info::$Map['scontent']));
        $form->ckeditor('content', __(Info::$Map['content']))->rules('required');
        $form->tags('keywords', __(Info::$Map['keywords']));
        $form->text('description', __(Info::$Map['description']));
        $form->image('cover', __(Info::$Map['cover']));
        $form->number('click', __(Info::$Map['click']))->default(1);
        $form->number('sort', __(Info::$Map['sort']));
        $form->datetime('crontab_at', __(Info::$Map['crontab_at']))->default(date('Y-m-d H:i:s'));

        // 定义事件回调，当模型即将保存时会触发这个回调
        // 如果sort为null，那么就设置为0
        $form->saving(function ($model) {
            if (is_null($model->sort)) {
                $model->sort = 0;
            }
            // 保存修改前的tag标签
            $this->beforeKeywords = $model->keywords;

            // 如果是修改, 则保存图片地址
            if ($model->id) {
                $this->cover = $model->cover;
            }
        });

        // 数据保存后，如果是新增，那么就把sort按照id*10也保存进去
        $form->saved(function (Form $form) {

            // 模型
            $info = $form->model();

            // 新增则添加sort值
            if (empty($info->sort)) {
                $id = $info->id;
                $info->update([
                    'sort' => $id * 10,
                ]);
            }
            // 判断tag标签是否有修改，如果有修改就重新info_tag表
            if ($this->beforeKeywords != $info->keywords) {
                // 处理标签逻辑
                // 把标签转成数组
                $tags = split_tags($info->keywords);

                // 首先删除文章关联的所有标签
                $info->tags()->detach();
                // 遍历标签，如果标签存在就添加关联，如果标签不存在就先创建该标签再添加关联
                foreach ($tags as $tag) {
                    // 如果是英文标签，统一改成小写
                    $tag = strtolower($tag);
                    // 如果标签存在，直接关联
                    if ($tagModel = Tag::query()->where('name', $tag)->first()) {
                        $info->tags()->attach($tagModel->id);
                    } else {
                        // 否则就先创建标签，然后再关联
                        $tagModel = Tag::create([
                            'name' => $tag,
                        ]);
                        $info->tags()->attach($tagModel->id);
                    }
                }

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
