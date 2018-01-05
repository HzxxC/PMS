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

class AdminBaseController extends Controller {


	/**
	 * 初始化函数
	 */
	public function _initialize() {

		parent::_initialize();

		if (!session('ADMIN.ID')) {
			header("Location:" . url("admin/login/index"));
			exit();
		} 

	}

}