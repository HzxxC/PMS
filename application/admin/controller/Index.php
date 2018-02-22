<?php
// +----------------------------------------------------------------------
// | Login.php [ 后端首页 模块 ]
// +----------------------------------------------------------------------
// | Author: Pengchu <1054115632@qq.com>
// +----------------------------------------------------------------------
// | Time: 2017-01-03
// +----------------------------------------------------------------------

namespace app\admin\controller;


class Index extends AdminBaseController 
{

	public function _initialize() {
		parent::_initialize();
		$this->assign('action', 'index');
	}
	/**
	 * 后端首页页面
	 * @return 页面
	 */
	public function index() {

		// 租金到期企业 计数
		// 未租房间 计数
		// 物业费缴费提醒 计数
		
		
		// 客户预约列表
		// 到期企业列表
		// 未租房间列表
		// 物业费缴费提醒列表

		return $this->fetch();	
	}



	public function test() {
		return exit(json_encode(['code'=>200, 'message'=>'测试接口', 'data'=>session('ADMIN')]));
	}

}