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

	public function _initialize() {
		parent::_initialize();
		$this->assign('action', 'property');
	}

	/**
	 * 物业管理模块首页
	 */
	public function index() {

		// 入驻公司 计数

		//公司信息列表

		return $this->fetch();	
	}

	public function paypage() {

		$this->get_normal_corps();

		$type = input('type');

		if ($type === '1') {
			$template = 'property_fee';
		} else {
			$template = 'property_rent';
		}

		return $this->fetch($template);
	}

	/**
	 * 物业管理 缴费提交
	 */
	public function payment() {

		
	}

	public function get_normal_corps() {
		$param['where'] = [
			'c.corp_status' => ['neq', 0]
		];
		$param['field'] = "c.corp_name, c.id, s.rids, s.room_area";
		$param['order'] = "c.corp_name DESC";

		$this->assign('normal_corps', pms_get_corp_list($param));
	}


	public function test() {
		return exit(json_encode(['code'=>200, 'message'=>'测试接口', 'data'=>session('ADMIN')]));
	}

}