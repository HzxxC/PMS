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

use think\Config;
use think\Db;
use think\Request;

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return string
 */
function get_client_ip($type = 0, $adv = false) {

    return request()->ip($type, $adv);
}

/**
 * 获取网站根目录
 * @param  string $value 
 * @param  string $id    
 * @return bool        验证码是否正确
 */
function pms_get_root() {
	
    $root    = request()->root();
    $root    = str_replace('/index.php', '', $root);
    if (defined('APP_NAMESPACE') && APP_NAMESPACE == 'api') {
        $root = preg_replace('/\/api$/', '', $root);
        $root = rtrim($root, '/');
    }

    return $root;
}

/**
 * 校验验证码
 * @param  string $value 
 * @param  string $id    
 * @return bool        验证码是否正确
 */
function pms_captcha_check($value, $id = "") {
	
	$captcha = new \think\captcha\Captcha();
    return $captcha->check($value, $id);
}


