<?php

namespace App\Common\Err;

/**
 * 自定义错误代码类
 * Class ApiErrors
 * @package App\Common\Err
 */
class ApiErrors
{
    // 请求成功
    const SUCCESS = [0, 'Success'];

    // 路由不存在
    const ERROR_NOTFOUND = [404, '页面不存在'];

    // 用户未登陆
    const ERROR_NOTLOGIN = [1000, '用户未登录'];
    const ERROR_WRONG_USERNAME_OR_PASSWORD = [1001, '用户名或密码错误，登录失败！'];
    const ERROR_USER_NOT_EXIST = [1002, '用户不存在'];
    const ERROR_USER_NOT_ACTIVE = [1002, '用户帐号未激活'];

    // 评论
    const ERROR_COMMENTS_SUBMIT_FAILED = [2000, '评论保存失败'];

    // 留言
    const ERROR_GUESTBOOKS_SUBMIT_FAILED = [3000, '留言提交失败'];

    // 邮件
    const ERROR_SEND_EMAIL_FAILED = [4000, '邮件发送失败'];

    // 非法请求
    const ERROR_BAD_REQUEST = [10000, '非法请求'];

    // 服务器错误
    const ERROR_UNKNOWN = [500, '服务器错误'];
}
