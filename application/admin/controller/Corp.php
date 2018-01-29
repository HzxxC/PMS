<?php
// +----------------------------------------------------------------------
// | Corp.php [ 后端公司信息管理 模块 ]
// +----------------------------------------------------------------------
// | Author: Pengchu <1054115632@qq.com>
// +----------------------------------------------------------------------
// | Time: 2017-01-29
// +----------------------------------------------------------------------

namespace app\admin\controller;


class Corp extends AdminBaseController 
{

	/**
	 * 公司管理模块首页
	 */
	public function index() {

		// 入驻公司 计数

		//公司信息列表

		return $this->fetch();	
	}

	/**
	 * 公司管理 信息添加页面
	 */
	public function add() {

		return $this->fetch();
	}

	/**
	 * 公司管理 信息添加提交
	 */
	public function add_post() {

		// insert 公司信息
		// insert 入驻房间信息
	}

	/**
	 * 公司管理 信息编辑页面
	 */
	public function edit() {

		// 获取公司信息 + 入驻房间信息

		$this->fetch();
	}

	/**
	 * 公司管理 信息编辑提交
	 */
	public function edit_post() {
		// update 公司信息
		// update 入驻房间信息
	}

	public function test() {
		return exit(json_encode(['code'=>200, 'message'=>'测试接口', 'data'=>session('ADMIN')]));
	}

}