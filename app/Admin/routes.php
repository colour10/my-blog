<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Encore\Admin\Facades\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    // 首页
    $router->get('/', 'HomeController@index')->name('admin.home');

    // 用户管理
    $router->resource('users', 'UsersController');

    // 频道管理
    $router->resource('channels', 'ChannelsController');

    // 图片上传
    $router->post('upload', 'ToolsController@upload')->name('admin.upload');

    // 信息管理
    $router->resource('infos', 'InfosController');

    // 友情链接管理
    $router->resource('links', 'LinksController');

    // 幻灯片管理
    $router->resource('banners', 'BannersController');

    // 频道类型管理
    $router->resource('channeltypes', 'ChanneltypesController');

    // 评论管理
    $router->resource('comments', 'CommentsController');

    // 留言板
    $router->resource('guestbooks', 'GuestbooksController');
});
