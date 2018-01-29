<?php
// +----------------------------------------------------------------------
// | Corp.php [ 后端房间信息管理 模块 ]
// +----------------------------------------------------------------------
// | Author: Pengchu <1054115632@qq.com>
// +----------------------------------------------------------------------
// | Time: 2017-01-29
// +----------------------------------------------------------------------

namespace app\admin\controller;


class Corp extends AdminBaseController 
{

	/**
	 * 房间管理 模块首页
	 */
	public function index() {

		// 房间列表

		return $this->fetch();	
	}

	/**
	 * 房间信息管理 信息添加页面
	 */
	public function add() {

		return $this->fetch();
	}

	/**
	 * 房间信息管理 信息添加提交
	 */
	public function add_post() {
		// insert 房间信息信息
	}

	/**
	 * 房间信息管理 信息编辑页面
	 */
	public function edit() {

		// 获取房间信息信息

		$this->fetch();
	}

	/**
	 * 房间信息管理 信息编辑提交
	 */
	public function edit_post() {
		// update 房间信息信息
	}

	public function test() {
		return exit(json_encode(['code'=>200, 'message'=>'测试接口', 'data'=>session('ADMIN')]));
	}

}