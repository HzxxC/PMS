<?php
// +----------------------------------------------------------------------
// | Corp.php [ 房间信息验证器 ]
// +----------------------------------------------------------------------
// | Author: Pengchu <1054115632@qq.com>
// +----------------------------------------------------------------------
// | Time: 2017-02-05
// +----------------------------------------------------------------------

namespace app\admin\validate;

use think\Validate;
use think\Db;

class Room extends Validate {

	protected $rule = [
        'room_no'  	=>  'checkRoomNo',
    ];

    protected $message = [
        'room_no'	=>	'房价号码也存在，请重新输入',
    ];

    // 自定义验证
    protected function checkRoomNo($value) {

    	$find = Db::name('rooms') -> where( ['room_no' => $value] ) -> count();

    	if ($find) return false;

    	return true;
    }

}