<?php
// +----------------------------------------------------------------------
// | Corp.php [ 后端公司入驻信息管理 模块 ]
// +----------------------------------------------------------------------
// | Author: Pengchu <1054115632@qq.com>
// +----------------------------------------------------------------------
// | Time: 2017-01-29
// +----------------------------------------------------------------------

namespace app\admin\controller;


class Settled extends AdminBaseController 
{

	public function add() {
		$this->get_unleased_rooms();
		$this->get_normal_corps();
		return $this->fetch();
	}

	/**
	 * 公司管理 信息添加提交
	 */
	public function add_post() {

		if ($this->request->isPost()) {
			$data = $this->request->param();

			$data['rids'] = implode(',', $data['rids']);
			
			$result = $this->validate($data, 'Settled');

			if ($result !== true) {
				exit(json_encode([ 'code'=>400, 'message'=>$result ]));
			} else {
				$res = pms_insert_settled($data);
				if ($res) {
					// 入驻成功后操作
					pms_settled_success($data);
					exit(json_encode([ 'code'=>200, 'message'=>'入驻信息添加成功' ]));
				}
			}
			
		}
	}

	/**
	 * 公司管理 信息编辑提交
	 */
	public function edit_post() {
		// update 公司信息
		// update 入驻房间信息
	}

	public function settled_post() {
		
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
			'c.corp_status' => ['eq', 1]
		];
		$param['order'] = "c.corp_name DESC";

		$this->assign('normal_corps', pms_get_corp_list($param));
	}

	public function test($message = "测试接口", $data = array()) {
		return exit(json_encode(['code'=>200, 'message'=>$message, 'data'=>$data ]));
	}

}