<?php

namespace App\Http\Middleware;

use App\Common\Err\ApiErrors;
use App\Traits\ResponseJson;
use Closure;
use Illuminate\Http\Request;

class FrontendAuthMiddleware
{
    use ResponseJson;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 如果未登录
        if (!$request->session()->has('user')) {
            // 判断是否需要json返回
            if ($request->expectsJson()) {
                return $this->jsonFail(ApiErrors::ERROR_NOTLOGIN[0], ApiErrors::ERROR_NOTLOGIN[1]);
            }
            // 否则就通过模版返回
            return redirect(route('home.index'));
        }
        return $next($request);
    }
}
