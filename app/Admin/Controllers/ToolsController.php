<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * 工具类
 * Class ToolsController
 * @package App\Admin\Controllers
 */
class ToolsController extends AdminController
{
    /**
     * 文件上传
     * @param Request $request
     * @return array
     */
    public function upload(Request $request)
    {
        try {
            $file_key = key($request->file());
            if ($request->file($file_key)->isValid()) {

                $file_extension = $request->$file_key->extension();
                $file_name      = md5(uniqid(rand())) . "." . $file_extension;

                $path = $request->$file_key->storeAs('images/' . date('Y-m-d'), $file_name, 'admin');

                $previewname = asset('uploads/' . $path);

                return [
                    "uploaded" => true,
                    "fileName" => $file_name,
                    "url"      => $previewname,
                    "error"    => [
                        "message" => '',
                    ],
                ];

            } else {
                return [
                    "uploaded" => false,
                    "fileName" => '',
                    "url"      => '',
                    "error"    => [
                        "message" => '上传出错！',
                    ],
                ];
            }
        } catch (\Exception $e) {

            // 记录上传失败的错误日志
            $msg = print_r($e, true);
            Log::error($msg);

            return [
                "uploaded" => false,
                "fileName" => '',
                "url"      => '',
                "error"    => [
                    "message" => '上传出错！',
                ],
            ];
        }
    }
}
