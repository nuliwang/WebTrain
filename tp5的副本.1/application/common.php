<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件





/**
 * get array
 */
function getCodeArray($code = 1, $msg = '', $data = array()) {
    $code = intval($code);
    if (!isset($code)) {
        $msg = '操作失败';
    } else if ($code == 0 && empty($msg)) {
        $msg = '操作失败';
    } else if ($code == 1 && empty($msg)) {
        $msg = '操作成功';
    }
    return array('code' => $code, 'msg' => $msg, 'data' => $data);
}

/**
 * get json
 */
function getCodeJson($code = 1, $msg = '', $data = array()) {
    return json_encode(getCodeArray($code, $msg, $data));
}

//打印数组或字符串，并终止程序
function P($arr) {
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
    exit;
}
//打印数组或字符串，不终止程序
function W($arr) {
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}
//打印json兼容智障插件
function PJ($arr) {
    header("Content-type: application/json; charset=utf-8");
    echo json_encode($arr);
    exit;
}
