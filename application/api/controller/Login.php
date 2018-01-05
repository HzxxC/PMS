<?php
// +----------------------------------------------------------------------
// | Login.php [ 登陆，退出 接口模块 ]
// +----------------------------------------------------------------------
// | Author: Pengchu <1054115632@qq.com>
// +----------------------------------------------------------------------
// | Time: 2017-01-03
// +----------------------------------------------------------------------

namespace app\api\controller;

class Login
{
	/**
	 * 默认
	 * @return [type] [description]
	 */
	public function index() {
		echo "This is Login Api";
	}

	/**
	 * [管理员登陆接口]
	 * @param  [array]  $data 	[登陆信息]
	 * @return [type]   [description]
	 */
	public function adminLogin($data) {
		
		if ($this->request->isPost()) {

            $data = $this->request->post();
            if (!$validate->check($data)) {
                $this->error($validate->getError());
            }

            if (!cmf_captcha_check($data['captcha'])) {
                $this->error('验证码错误');
            }
        }

	}

	/**
	 * [userLogin 商户登陆接口]
	 * @param  [type] $account  [账户]
	 * @param  [type] $password [密码]
	 * @param  [type] $captcha  [验证码]
	 * @return [type]           [description]
	 */
	public function userLogin($account, $password, $captcha) {

	}


}
