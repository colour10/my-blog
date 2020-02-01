<?php

namespace App\Traits;

/**
 * json输出
 * Trait ResponseJson
 * @package App\Traits
 */
trait ResponseJson
{
    /**
     * 返回json格式
     * @param int $code 状态码
     * @param string $msg 提示信息
     * @param array $data 其他数据
     * @return array
     */
    public function json($code, $msg, $data = [])
    {
        return response()->json([
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
        ]);
    }

    /**
     * 响应成功
     * @param array $data
     * @param string $msg
     * @return array
     */
    public function jsonSuccess($data = [], $msg = 'Success')
    {
        return $this->json(0, $msg, $data);
    }

    /**
     * 响应失败
     * @param $code
     * @param $msg
     * @param array $data
     * @return array
     */
    public function jsonFail($code, $msg, $data = [])
    {
        return $this->json($code, $msg, $data);
    }
}
