<?php
// +----------------------------------------------------------------------
// | Login.php [ 管理员登陆，退出 模块 ]
// +----------------------------------------------------------------------
// | Author: Pengchu <1054115632@qq.com>
// +----------------------------------------------------------------------
// | Time: 2017-01-03
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Login extends AdminBaseController 
{


	public function _initialize() {

	}

	/**
	 * 默认
	 */
	public function index() {

		if (!empty(session('ADMIN.ID'))) {

			$this->redirect(url("admin/index/index"));

		} else {

			return $this->fetch();
		}
	}

	/**
	 * 管理员登陆操作
	 * @return json 登陆信息
	 */
	public function login() {

		if ($this->request->isPost()) {

			if (!$data = $this->request->param()) {
				exit(json(['code'=>400, 'message'=>'请求参数错误']));
			}

			if (!$admin = pms_admin_account_check($data['username'])) {
				exit(json_encode(['code'=>400, 'message'=>'账户名不存在，请重新输入']));
			}

			if (!pms_admin_password_check($admin['id'], $data['password'])) {
				exit(json_encode(['code'=>400, 'message'=>'账户名与密码不匹配，请重新输入']));
			}
			
			// 校验验证码
			// if (!pms_captcha_check($data['captcha'])) {
			// 	exit(json_encode(['code'=>400, 'message'=>'验证码错误']));
			// }

			pms_admin_login_success($admin);            

            exit(json_encode(['code'=>200, 'message'=>'登陆成功', 'url'=>url('admin/index/index')]));

		} else {
			exit(json_encode(['code'=>400, 'message'=>'请求错误']));
		}

	}

	/**
	 * 管理员注销登陆接口
	 * @return [type] [description]
	 */
	public function logout() {

		if (pms_admin_logout_success()) {
			exit(json_encode(['code'=>200, 'message'=>'退出成功', 'url'=>url('admin/index/index')]));
		}

	}

	/**
	 * 测试接口
	 * @return [type] [description]
	 */
	public function test() {

		exit(json_encode(['code'=>200, 'message'=>'测试成功']));
	}

}