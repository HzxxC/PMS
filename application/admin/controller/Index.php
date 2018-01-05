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


	public function index() {

		return $this->fetch();	
	}



	public function test() {
		return exit(json_encode(['code'=>200, 'message'=>'测试接口', 'data'=>session('ADMIN')]));
	}

}