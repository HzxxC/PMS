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

	public function _initialize() {
		parent::_initialize();
		$this->assign('action', 'corp');
	}

	/**
	 * 公司管理模块首页
	 */
	public function index() {

		//公司信息列表
		$param['page'] = 8;
		// 房间列表
		$corp_list = pms_get_corp_list($param);
		$this->assign("corp_list", $corp_list);
		$this->assign('corp_settled_count', pms_get_settled_corp_count());

		return $this->fetch();	
	}

	public function add() {
		return $this->fetch();
	}

	/**
	 * 公司管理 信息添加提交
	 */
	public function add_post() {

		if ($this->request->isPost()) {
			$data = $this->request->param();

			$result = $this->validate($data, 'Corp.add');

			if ($result !== true) {
				exit(json_encode([ 'code'=>400, 'message'=>$result ]));
			} else {
				$data['papers'] = json_encode($data['papers']);
				$res = pms_insert_corp($data);
				if ($res) {
					exit(json_encode([ 'code'=>200, 'message'=>'公司信息添加成功' ]));
				}
			}
			
		}
	}

	public function edit() {
		$id = input('id');
		if ($id) {
			$corp_info = pms_get_corp($id);
			$corp_info['papers'] = json_decode($corp_info['papers'], true);
			$this->assign('corp', $corp_info);
		}
		return $this->fetch();
	}

	/**
	 * 公司管理 信息编辑提交
	 */
	public function edit_post() {
		
		if ($this->request->isPost()) {
			$data = $this->request->param();

			$result = $this->validate($data, 'Corp.edit');

			if ($result !== true) {
				exit(json_encode([ 'code'=>400, 'message'=>$result ]));
			} else {
				$data['papers'] = json_encode($data['papers']);
				$res = pms_update_corp($data);
				if ($res) {
					exit(json_encode([ 'code'=>200, 'message'=>'公司信息编辑成功' ]));
				}
			}
			
		}
	}

	public function del() {
		$id = input('id');
		if ($id) {
			$result = pms_del_corp($id);
			if ($result) {
				exit(json_encode([ 'code'=>200, 'message'=>'公司信息删除成功' ]));
			}
		}
	}

	public function info() {
		$id = input('id');
		if ($id) {
			// 公司信息
			$corp = pms_get_corp($id);
			$corp['papers'] = json_decode($corp['papers'], true);
			$this->assign('corp', $corp);
			// 入驻信息
			$param['where'] = [
				'cid' => $id
			];
			$this->assign('settled', pms_get_settled($param));
		}
		return $this->fetch();
	}

	/**
	 * 公司管理 获得未租房间列表
	 */
	public function get_unleased_rooms() {
		$param['where'] = [
			'room_status' => 0
		];
		$param['order'] = "r.room_no ASC";

		$this->assign('unleased_rooms', pms_get_room_list($param));
	}


	public function get_normal_corps() {
		$param['where'] = [
			'c.corp_status' => ['neq', 0]
		];
		$param['order'] = "c.corp_name DESC";

		$this->assign('normal_corps', pms_get_corp_list($param));
	}

	public function test($message = "测试接口", $data = array()) {
		return exit(json_encode(['code'=>200, 'message'=>$message, 'data'=>$data ]));
	}

}