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

class Corp extends Validate {

	protected $rule = [
        'corp_name'  	      =>  'checkCorpNo',
        'papers'              =>  'require|checkPapers'
    ];

    protected $message = [
        'corp_name'	          =>  '公司名称也存在，请重新输入',
        'pagers'              =>  '身份证件与营业执照为必传'
    ];

    protected $scene = [
        'edit'  =>  ['pagers'],
        'add'   =>  ['corp_name', 'pagers'],
    ];

    // 自定义验证
    protected function checkCorpNo($value) {

    	$find = Db::name('corp') -> where( ['corp_name' => $value] ) -> count();

    	if ($find) return false;

    	return true;
    }

    protected function checkPapers($value) {
        $msg = '';
        if (empty($value['front'])) {
            $msg = '身份证件正面图片缺失';
        }
        if (empty($value['reverse'])) {
            $msg = '身份证件反面图片缺失';
        }
        if (empty($value['license'])) {
            $msg = '营业执照图片缺失';
        }

        if (empty($msg))
            return true;

        return $msg;
    }

}