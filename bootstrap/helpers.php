<?php

/**
 * 按照逗号分割数组
 */
function split_tags($tags)
{
    // 逻辑
    // 如果含有逗号
    $tag_arr = [];
    if (strpos($tags, ',') !== false) {
        $tag_arr = explode(',', $tags);
    } else {
        $tag_arr[] = $tags;
    }
    // 返回
    return $tag_arr;
}

/**
 * 文件自动添加版本号
 * @param string $file 文件绝对路径
 * 调用规则：<link rel="stylesheet" href="<?=AutoVersion('/assets/css/style.css')?>" type="text/css" />
 * 如果存在，那么就是如下的形式：
 * <link rel="stylesheet" href="/assets/css/style.css?v=1367936144322" type="text/css" />
 * @return string
 */
function AutoVersion($file)
{
    // 如果文件存在
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $file)) {
        $ver = filemtime($_SERVER['DOCUMENT_ROOT'] . $file);
    } else {
        $ver = 1;
    }
    return $file . '?v=' . $ver;
}

/**
 * 判断是否为微信内部浏览器访问
 */
function is_weixin()
{
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    }
    return false;
}

/**
 * curl模拟http发送get或post接口测试
 * $url 请求的url
 * $type 请求类型
 * $res 返回数据类型
 * $arr post请求参数
 */
function http_curl($url, $type = 'get', $res = 'json', $arr = '')
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    if ($type == 'post') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
    }
    $output = curl_exec($ch);
    curl_close($ch);
    if ($res == 'json') {
        return json_decode($output, true);
    }
}

/**
 * PHP 获取客户端ip地址
 */
function getIP()
{
    // strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
    if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $res = preg_match('/[\d\.]{7,15}/', $ip, $matches) ? $matches [0] : '';
    // 返回真实ip地址
    return $res;
}

/**
 * 手机号隐藏后四位
 * @param string $phone
 * @return mixed
 */
function hidephone($phone)
{
    return substr_replace($phone, '****', 3, 4);
}

/**
 * 只保留字符串首尾字符，隐藏中间用*代替（两个字符时只显示第一个）
 * @param string $user_name 姓名
 * @return string 格式化后的姓名
 */
function substr_cutname($user_name)
{
    $strlen   = mb_strlen($user_name, 'utf-8');
    $firstStr = mb_substr($user_name, 0, 1, 'utf-8');
    $lastStr  = mb_substr($user_name, -1, 1, 'utf-8');
    return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
}

/**
 * 多维数组按照某一个字段去重
 * @param array $arr 传入数组
 * @param string $key 判断的key值
 * @return array 返回一个去重的数组
 */
function second_array_unique($arr, $key)
{
    //建立一个目标数组
    $res = array();
    foreach ($arr as $value) {
        //查看有没有重复项
        if (isset($res[$value[$key]])) {
            unset($value[$key]);  //有：销毁
        } else {
            $res[$value[$key]] = $value;
        }
    }
    return $res;
}

/**
 * 生成0-1的随机数
 * @param int $min
 * @param int $max
 * @return float
 */
function randomFloat($min = 0, $max = 1)
{
    return $min + mt_rand() / mt_getrandmax() * ($max - $min);
}

/**
 * 评论分层展示，格式化数据
 * @param $result
 * @param int $pid
 * @param int $level
 * @return array
 */
function formatTreeForComments($result, $pid = 0, $level = 0)
{
    // 初始化一个空数组
    $tree = [];
    // 逻辑
    foreach ($result as $v) {
        if ($v['pid'] === $pid) {
            $v['level'] = $level;
            $tree[]     = $v;
            // 接下来寻找自己分类
            $tree = array_merge($tree, formatTreeForComments($result, $v['id'], $level + 1));
        }
    }
    // 返回结果
    return $tree;
}

/**
 * 判断是否可以转成array
 * @param $value
 * @return mixed
 */
function changeToArray($value)
{
    return is_null($value) ? $value : $value->toArray();
}

/**
 * 记录日志，Shell终端和本地都显示
 * @param $content
 */
function writeLogForShellAndLocal($content)
{
    // 逻辑
    // 首先添加换行符
    $content .= PHP_EOL;
    Illuminate\Support\Facades\Log::info($content);
    // 终端输出
    echo $content;
}

/**
 * 优化三元运算符
 * @param $value
 * @param null $thirdPart
 * @return null
 */
function checkIssetVar($value, $thirdPart = null)
{
    // 逻辑
    return isset($value) ? $value : $thirdPart;
}
