<?php

namespace App\Http\Controllers;

use App\Common\Err\ApiErrors;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Jobs\SendEmailJob;
use App\Models\User;
use App\Traits\ResponseJson;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;

/**
 * 用户控制器
 * Class InfosController
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{

    use ResponseJson;

    /**
     * 用户注册&&登陆
     * @param UserRequest $request
     * @return array
     */
    public function store(UserRequest $request)
    {
        // 判断是注册还是登陆
        $action = $request->input('action');
        switch ($action) {
                // 注册
            case 'signup':
                // 开始写入
                $user = User::query()->create([
                    'username' => $request->input('username'),
                    'email'    => $request->input('email'),
                    'password' => $request->input('password'),
                    'avatar'   => Gravatar::src($request->input('email')),
                ]);
                /**
                 * 延迟发送邮件
                 * @param string $message 发信参数组成的数组 array
                 * @param string $template 发信模版
                 * @param int $timeout 重试间隔时间，单位是秒
                 * @param int $attempt 最大重试次数
                 * delay 延迟多少秒进入队列
                 */
                $message = [
                    // 邮件标题
                    'title'            => '刘宗阳博客新用户注册通知',
                    // 收件人
                    'to'               => $request->input('email'),
                    // 昵称
                    'name'             => $request->input('username'),
                    // 初始密码
                    'password'         => $request->input('password'),
                    // 验证token
                    'activation_token' => $user->activation_token,
                    // 跳转URL
                    'url'              => route('users.confirmEmail', ['token' => $user->activation_token]),
                    // 邮件正文内容
                    // 'content' => $content,
                    // 附件地址
                    // 'attachment' => storage_path('app/1.doc.txt'),
                    // 附件在邮件中的别名
                    // 'attachment_filename' => '最新测试文档',
                ];
                $job     = new SendEmailJob($message, 'emails.reg');
                if (!$this->dispatch($job)) {
                    return $this->jsonFail(ApiErrors::ERROR_SEND_EMAIL_FAILED[0], ApiErrors::ERROR_SEND_EMAIL_FAILED[1]);
                }
                // 返回一个注册成功，但是邮箱未认证的状态码
                return $this->jsonFail(ApiErrors::ERROR_USER_NOT_ACTIVE[0], '恭喜您，注册成功，请登陆邮箱完成激活认证。');
                break;
            default:
                // 逻辑
                $nameemail   = $request->input('nameemail');
                $password    = $request->input('password');
                $is_remember = $request->input('is_remember');
                if (Auth::guard('web')->attempt(['username' => $nameemail, 'password' => $password], $is_remember) || Auth::guard('web')->attempt(['email' => $nameemail, 'password' => $password], $is_remember)) {
                    // 取出用户id
                    $id = Auth::guard('web')->id();
                    if (!$user = User::query()->find($id)) {
                        return $this->jsonFail(ApiErrors::ERROR_USER_NOT_EXIST[0], ApiErrors::ERROR_USER_NOT_EXIST[1]);
                    }

                    // 验证是否激活
                    if (!$user->is_active) {
                        return $this->jsonFail(ApiErrors::ERROR_USER_NOT_ACTIVE[0], ApiErrors::ERROR_USER_NOT_ACTIVE[1]);
                    }

                    // 写入最后登录时间
                    $user->update([
                        'lastlogin_at' => Carbon::now(),
                        'avatar'       => $user->avatar ?? Gravatar::src($user->avatar),
                    ]);
                    // 写入session
                    Session::put('user', new UserResource($user));

                    // 成功返回
                    return $this->jsonSuccess(Session::get('user'), '恭喜您，登录成功！');
                } else {
                    // 失败返回
                    return $this->jsonFail(ApiErrors::ERROR_WRONG_USERNAME_OR_PASSWORD[0], ApiErrors::ERROR_WRONG_USERNAME_OR_PASSWORD[1]);
                }
        }
    }

    /**
     * 激活帐号
     * @param string $token
     * @return array
     */
    public function confirmEmail($token)
    {
        // 必须存在
        if (!$user = User::query()->where('activation_token', $token)->first()) {
            return view('pages.notice', [
                'title'   => '非法请求',
                'content' => '非法请求',
            ]);
        }
        // 开始激活
        $user->update([
            'activation_token'  => null,
            'is_active'         => true,
            'email_verified_at' => Carbon::now(),
        ]);
        return view('pages.notice', [
            'title'   => '帐号激活成功',
            'content' => '帐号激活成功',
        ]);
    }

    /**
     * 密码修改成功
     * @return Factory|View
     */
    public function passwordResetSuccess()
    {
        return view('auth.passwords.success');
    }
}
