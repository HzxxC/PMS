<?php
// +----------------------------------------------------------------------
// | Corp.php [ 公司信息验证器 ]
// +----------------------------------------------------------------------
// | Author: Pengchu <1054115632@qq.com>
// +----------------------------------------------------------------------
// | Time: 2017-02-05
// +----------------------------------------------------------------------

namespace app\admin\validate;

use think\Validate;
use think\Db;

class Settled extends Validate {

	protected $rule = [
        'cid'  	=>  'require',
        'rids'  =>  'require',
        'contract'  =>  'require',
        'end_time' => 'checkDate'
    ];

    protected $message = [
        'cid'	=>	'请选择入驻公司',
        'rids'  =>  '请选择申请房间',
        'contract' => '请上传房间入驻签约合同',
        'end_time' => '结束日期不能小于开始日期'
    ];

    // 自定义验证
    protected function checkDate($value, $rule, $data) {

    	return strtotime($value) > strtotime($data['begin_time']) ? true : false;

    }

}