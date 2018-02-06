<?php
// +----------------------------------------------------------------------
// | Corp.php [ 后端房间信息管理 模块 ]
// +----------------------------------------------------------------------
// | Author: Pengchu <1054115632@qq.com>
// +----------------------------------------------------------------------
// | Time: 2017-01-29
// +----------------------------------------------------------------------

namespace app\admin\controller;


class Room extends AdminBaseController 
{

	public function _initialize() {
		parent::_initialize();

		// 缴费状态
		$pay_status = [
			["name" => "未租出", "status" => 0],
			["name" => "已缴费", "status" => 1],
			["name" => "未缴费", "status" => 2]
		];
		$this->assign('pay_status', $pay_status);

	}


	/**
	 * 房间管理 模块首页
	 */
	public function index() {

		// 搜索
		if ($this->request->isPost()) {
			$data = $this->request->param();
			$this->assign("search_info", $data);
		}
		$param['limit'] = 5;
		$param['page'] = 2;
		// 房间列表
		$this->assign("room_list", pms_get_room_list($param));
		
		return $this->fetch();	
	}


	/**
	 * 房间信息管理 信息添加提交
	 */
	public function add_post() {
		if ($this->request->isPost()) {
			$data = $this->request->param();
			$result = $this->validate($data, 'Room');
			if ($result !== true) {
				exit(json_encode([ 'code'=>400, 'message'=>$result ]));
			} else {
				$res = insert_rooms($data);
				if ($res) {
					exit(json_encode([ 'code'=>200, 'message'=>'房间添加成功' ]));
				}
			}
		}
		// insert 房间信息信息
	}


	/**
	 * 房间信息管理 信息编辑提交
	 */
	public function edit_post() {
		// update 房间信息信息
	}

	public function test($message = "测试接口", $data = array()) {
		return exit(json_encode(['code'=>200, 'message'=>$message, 'data'=>$data ]));
	}

}