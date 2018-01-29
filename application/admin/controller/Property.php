<?php
// +----------------------------------------------------------------------
// | Corp.php [ 后端物业管理 模块 ]
// +----------------------------------------------------------------------
// | Author: Pengchu <1054115632@qq.com>
// +----------------------------------------------------------------------
// | Time: 2017-01-29
// +----------------------------------------------------------------------

namespace app\admin\controller;


class Property extends AdminBaseController 
{

	/**
	 * 物业管理模块首页
	 */
	public function index() {

		// 入驻公司 计数

		//公司信息列表

		return $this->fetch();	
	}

	/**
	 * 物业管理 缴费提交
	 */
	public function payment() {

		return $this->fetch();
	}


	public function test() {
		return exit(json_encode(['code'=>200, 'message'=>'测试接口', 'data'=>session('ADMIN')]));
	}

}