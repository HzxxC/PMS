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

		$param['page'] = 8;
		//获得缴费记录列表
		$this->assign('pay_list', pms_get_payment_list($param));

		return $this->fetch();	
	}

	public function paypage() {

		$this->get_settled_corps();

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

		if ($this->request->isPost()) {
			$data = $this->request->param();

			$result = $this->validate($data, 'Property');

			if ($result !== true) {
				exit(json_encode([ 'code'=>400, 'message'=>$result ]));
			} else {
				$res = pms_insert_payment($data['corp_id'], $data['rent'], $data['type'], $data['end_time']);
				
				if ($res) {
					exit(json_encode([ 'code'=>200, 'message'=>'缴费信息添加成功' ]));
				}
			}
			
		}
		
	}

	public function get_settled_corps() {
		$param['where'] = [
			'c.corp_status' => ['eq', 2]
		];
		$param['field'] = "c.corp_name, c.id, s.rids, s.room_area";
		$param['order'] = "c.corp_name DESC";

		$this->assign('normal_corps', pms_get_corp_list($param));
	}


	public function test() {
		return exit(json_encode(['code'=>200, 'message'=>'测试接口', 'data'=>session('ADMIN')]));
	}

}