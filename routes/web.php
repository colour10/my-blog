<?php

use Illuminate\Support\Facades\Route;

// 必须登陆才能访问的页面
Route::group(['middleware' => 'frontend.auth'], function () {
    // 提交留言
    Route::post('guestbooks', 'GuestbooksController@store');
    // 点赞，取消点赞
    Route::resource('upvotes', 'UpvotesController')->only(['store']);
});

// 首页
Route::get('/', 'HomeController@index')->name('home.index');
// 是否登陆
Route::get('isLogin', 'HomeController@isLogin')->name('home.isLogin');
// 退出登录
Route::get('logout', 'HomeController@logout')->name('home.logout');

// 用户
// 注册
Route::resource('users', 'UsersController')->only(['store']);
Route::get('users/confirm/{token}', 'UsersController@confirmEmail')->name('users.confirmEmail');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('users/passwordResetSuccess', 'UsersController@passwordResetSuccess')->name('users.passwordResetSuccess');

// 标签
Route::resource('tags', 'TagsController')->only(['show']);

// 评论
Route::resource('comments', 'CommentsController')->only(['store']);

// 留言
Route::resource('guestbooks', 'GuestbooksController')->only(['index', 'store']);

// 频道
Route::get('/{uri}', 'ChannelsController@show')->name('channels.show');

// 信息
Route::get('/{uri}/{id}', 'InfosController@show')->name('infos.show');





