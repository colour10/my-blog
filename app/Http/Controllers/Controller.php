<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 获取当前控制器和方法
     * @return array
     */
    public static function getRouteInfo()
    {
        if (!is_null(Route::current())) {
            $action = Route::current()->getActionName();
            list($class, $method) = explode('@', $action);
            $class = substr(strrchr($class, '\\'), 1);
            return [
                'controller' => $class,
                'action'     => $method,
                'path'       => Request::path(),
            ];
        }
    }
}
