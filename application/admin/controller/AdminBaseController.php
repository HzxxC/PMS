<?php
// +----------------------------------------------------------------------
// | Login.php [ 后端通用 模块 ]
// +----------------------------------------------------------------------
// | Author: Pengchu <1054115632@qq.com>
// +----------------------------------------------------------------------
// | Time: 2017-01-03
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\View;

class AdminBaseController extends Controller {


	/**
	 * 初始化函数
	 */
	public function _initialize() {

		parent::_initialize();

		$admin_id = session('ADMIN.ID');
		if (!empty($admin_id)) {
			// 登陆账户信息 用户名 + 最后登陆时间
			$admin_info = pms_get_admin_info_single($admin_id, "nikename, last_login_time");
			// var_dump($admin_info);
			View::share("admin_info", $admin_info);
		} else {
			header("Location:" . url("admin/login/index"));
			exit();
		}
	}

}