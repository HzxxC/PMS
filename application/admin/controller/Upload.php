<?php
// +----------------------------------------------------------------------
// | Login.php [ 后端首页 模块 ]
// +----------------------------------------------------------------------
// | Author: Pengchu <1054115632@qq.com>
// +----------------------------------------------------------------------
// | Time: 2017-01-03
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\File;

class Upload extends Controller 
{

	/**
	 * 后端首页页面
	 * @return 页面
	 */
	public function upload() {

		// 获取表单上传文件 例如上传了001.jpg
	    $file = request()->file('file');
	    
	    // 移动到框架应用根目录/public/uploads/ 目录下
	    if($file){
	        $info = $file->move(ROOT_PATH .'uploads');
	        if($info){
	            // 成功上传后 获取上传信息
	            // 输出 jpg
	            exit(json_encode(['code'=>200, 'message'=>'图片上传成功', 'data'=>$info->getSaveName()]));
	        }else{
	            // 上传失败获取错误信息
	            exit(json_encode(['code'=>400, 'message'=>$file->getError()])); ;
	        }
	    }

	}



	public function test() {
		exit(json_encode(['code'=>200, 'message'=>'测试接口', 'data'=>'aaa']));
	}

}