<?php
// +----------------------------------------------------------------------
// | config.php [ 后端公共函数文件 ]
// +----------------------------------------------------------------------
// | Author: Pengchu <1054115632@qq.com>
// +----------------------------------------------------------------------
// | Time: 2017-01-04
// +----------------------------------------------------------------------

// 应用公共文件
use think\Config;
use think\Db;
use think\Request;
use think\Session;

/**
 * 校验管理员账户名
 * @param  string $value 	[需要校验的账户名]
 * @return boolean    		[账户名存在，返回 TRUE, 否则返回 FALSE]
 */
function pms_admin_account_check($value) {

	$res = Db::name('users') 
				-> where('account', $value) 
				-> where('type', 'in', [ADMINISTRATOR, MANAGER, DEVELOPER])
				-> find();

	return !$res ? 0 : $res;

}

/**
 * 校验账户密码是否匹配
 * @param  int 	  $id    账户ID
 * @param  string $value 账户密码 ( MD5加密格式 )
 * @return boolean      是否匹配
 */
function pms_admin_password_check($id, $value) {
	
	return Db::name('users') 
				-> where('id', $id) 
				-> where('password', $value)
				-> count();

}

/**
 * 账户登陆成功，登陆状态 记录
 * @param  array $value 账户基本信息数组
 * @return boolean   数据是否更新成功
 */
function pms_admin_login_success($value) {

	session('ADMIN.ID', 		$value['id']);
	session('ADMIN.NIKENAME', 	$value['nikename']);

	$data['last_login_ip'] = get_client_ip(0, false);
	$data['last_login_time'] = date('Y-m-d H:i:s', time());

	return Db::name('users')
				-> where('id', session('ADMIN.ID'))
				-> update($data);

}

/**
 * 管理员账户退出
 * @return true
 */
function pms_admin_logout_success() {
	 
	session('ADMIN', null);
	
	return true;
}

/**
 * 获取单个管理员信息
 * @param  bigint $admin_id 管理员ID
 * @param  string $field    需要获取的信息 SQL
 * @return array            管理员信息数组
 */
function pms_get_admin_info_single($admin_id, $field = '*') {

	$where = [
		'id' => $admin_id,
		'status' => 1
	];

	return Db::name('users') 
				-> field($field)
				-> where($where) -> find();
}