<?php
// +----------------------------------------------------------------------
// | Property.php [ 费用缴纳验证器 ]
// +----------------------------------------------------------------------
// | Author: Pengchu <1054115632@qq.com>
// +----------------------------------------------------------------------
// | Time: 2017-02-23
// +----------------------------------------------------------------------

namespace app\admin\validate;

use think\Validate;
use think\Db;

class Property extends Validate {

	protected $rule = [
        // 'end_time'  	      =>  'checkEndTime',
    ];

    protected $message = [
        // 'end_time'	          =>  '请仔细审核到租日期',
    ];

    // 自定义验证
    protected function checkEndTime($value,$rule,$data) {

    	$end_time = Db::name('settled') -> where( ['cid' => $data['corp_id']] ) -> value('end_time');

    	if ($end_time ) return false;

    	return true;
    }

}