<?php
// +----------------------------------------------------------------------
// | config.php [ 后端公共函数文件 ]
// +----------------------------------------------------------------------
// | Author: Pengchu <1054115632@qq.com>
// +----------------------------------------------------------------------
// | Time: 2017-01-04
// +----------------------------------------------------------------------

// 应用公共文件
use think\Config;
use think\Db;
use think\Request;
use think\Session;



/**
 * 时间划分函数
 * @return string 当前所属时间段
 */
function pms_get_time_division() {
	
	$hour = date('H', time());
	$hour_str = "";
	if ($hour < 11) $hour_str = "早上好";
	elseif ($hour < 14) $hour_str = "中午好";
	elseif ($hour < 18) $hour_str = "下午好";
	else $hour_str = "晚上好";

	return $hour_str;
}

/**
 * 获取图片预览链接
 * @param string $file 文件路径，相对于upload
 * @param string $style 图片样式,支持各大云存储
 * @return string
 */
function pms_get_image_preview_url($file)
{
	$upload = pms_get_domain() . pms_get_root() . DS . 'uploads' . DS;

    return $upload . $file;
}

/**
 * 校验管理员账户名
 * @param  string $value 	[需要校验的账户名]
 * @return boolean    		[账户名存在，返回 TRUE, 否则返回 FALSE]
 */
function pms_admin_account_check($value) {

	$res = Db::name('users') 
				-> where('account', $value) 
				-> where('type', 'in', [ADMINISTRATOR, MANAGER, DEVELOPER])
				-> find();

	return !$res ? 0 : $res;

}

/**
 * 校验账户密码是否匹配
 * @param  int 	  $id    账户ID
 * @param  string $value 账户密码 ( MD5加密格式 )
 * @return boolean      是否匹配
 */
function pms_admin_password_check($id, $value) {
	
	return Db::name('users') 
				-> where('id', $id) 
				-> where('password', $value)
				-> count();

}

/**
 * 账户登陆成功，登陆状态 记录
 * @param  array $value 账户基本信息数组
 * @return boolean   数据是否更新成功
 */
function pms_admin_login_success($value) {

	session('ADMIN.ID', 		$value['id']);
	session('ADMIN.NIKENAME', 	$value['nikename']);

	$data['last_login_ip'] = get_client_ip(0, false);
	$data['last_login_time'] = date('Y-m-d H:i:s', time());

	return Db::name('users')
				-> where('id', session('ADMIN.ID'))
				-> update($data);

}

/**
 * 管理员账户退出
 * @return true
 */
function pms_admin_logout_success() {
	 
	session('ADMIN', null);
	
	return true;
}

/**
 * 获取单个管理员信息
 * @param  bigint $admin_id 管理员ID
 * @param  string $field    需要获取的信息 SQL
 * @return array            管理员信息数组
 */
function pms_get_admin_info_single($admin_id, $field = '*') {

	$where = [
		'id' => $admin_id,
		'status' => 1
	];

	return Db::name('users') 
				-> field($field)
				-> where($where) -> find();
}

/**
 * 获取网站站点信息
 * @return array 网站数据
 */
function pms_get_site_info() {

	$option_value = Db::name('option') 
						-> where('option_name', 'site_info')
						-> value('option_value');
	
	if (!empty($option_value)) {
		$option_value = json_decode($option_value, true);
	}

	return $option_value;
}

/**
 * 获取网站友情链接列表
 * @return  array  友情链接数组
 */
function pms_get_links() {

	$links = Db::name('link')
					-> where('status', '1')
					-> order('list_order ASC')
					-> select();

	return $links;

}

/**
 * 获取房间信息列表
 * @param  array  $param 条件数组
 * @return array         房间信息数组
 */
function pms_get_room_list($param = array()) {

	$where = isset($param['where']) ? $param['where'] : "";

	$limit = isset($param['limit']) ? $param['limit'] : "";
	$order = empty($param['order']) ? 'r.create_time desc' : $param['order'];
	$page = isset($param['page']) ? $param['page'] : false;

	$rooms = Db::name('rooms') -> alias('r')
					-> where($where)
					-> order($order);
	$return = [];

	if (empty($page)) {
		$rooms = $rooms->limit($limit)->select();
        $return['rooms'] = $rooms;
	
	} else {

        if (is_array($page)) {
            if (empty($page['list_rows'])) {
                $page['list_rows'] = 10;
            }

            $rooms = $rooms->paginate($page);
        } else {
            $rooms = $rooms->paginate(intval($page));
        }

        $rooms->appends(request()->param());

        $return['rooms']    = $rooms->items();
        $return['page']        = $rooms->render();
        $return['total']       = $rooms->total();
        $return['total_pages'] = $rooms->lastPage();
	}

	return $return;

}

/**
 * 添加房间信息
 * @param  array  $data  房间信息
 * @return array         数据库添加状态
 */
function pms_insert_rooms($data) {
	$data['room_status'] = 0;	// 未租
	$data['create_time'] = date('Y-m-d H:i:s', time());
	
	return Db::name('rooms') -> insert($data);
}

/**
 * 更新房间信息
 * @param  array  $param 房间信息
 * @return array         数据库更新状态
 */
function pms_update_rooms($data) {
	return Db::name('rooms') -> update($data);
}

/**
 * 更新房间入驻状态
 * @param  string  $ids 	房间ID
 * @param  int     $status  房间状态 	
 * @return array         	数据库更新状态
 */
function pms_update_room_status($ids, $status) {
	$where = [
		'room_no' => ['in', $ids]
	];
	return Db::name('rooms') -> where($where) -> setField('room_status', $status);
}

/**
 * 获取公司信息
 * @param  int 	  $id 公司ID
 * @return array      公司信息数组
 */
function pms_get_corp($id) {

	$where = [
		'id' => $id
	];

	$corps = Db::name('corp')
				   -> where($where)
				   ->find();

	return $corps;
}

/**
 * 获取公司信息列表
 * @param  array  $param 条件数组
 * @return array         公司信息数组
 */
function pms_get_corp_list($param = array()) {
		
	$where = isset($param['where']) ? $param['where'] : "";

	$limit = isset($param['limit']) ? $param['limit'] : "";
	$order = empty($param['order']) ? 'c.create_time desc' : $param['order'];
	$page = isset($param['page']) ? $param['page'] : false;

	$field = isset($param['field']) ? $param['field'] : "c.*, s.rids, s.end_time";
	// 入驻房间信息
	$join = [
		['pms_settled s', 'c.id = s.cid', 'LEFT']
	];

	$corps = Db::name('corp') -> alias('c')
					-> where(['c.corp_status'=>array('neq', 0)])
					-> where($where)
					-> join($join)
					-> field($field)
					-> order($order);
	$return = [];

	if (empty($page)) {
		$corps = $corps->limit($limit)->select();
        $return['corps'] = $corps;
	} else {

        if (is_array($page)) {
            if (empty($page['list_rows'])) {
                $page['list_rows'] = 10;
            }

            $corps = $corps->paginate($page);
        } else {
            $corps = $corps->paginate(intval($page));
        }

        $corps->appends(request()->param());

        $return['corps']    = $corps->items();
        $return['page']        = $corps->render();
        $return['total']       = $corps->total();
        $return['total_pages'] = $corps->lastPage();
	}

	return $return;
}

/**
 * 添加公司信息
 * @param  array  $data  公司信息
 * @return array         信息添加状态
 */
function pms_insert_corp($data) {
	
	$data['corp_status'] = 1;	// 正常
	$data['create_time'] = date('Y-m-d H:i:s', time());
	$data['update_time'] = date('Y-m-d H:i:s', time());

	return Db::name('corp') -> insert($data);
}

/**
 * 更新公司信息
 * @param  array  $data  公司信息
 * @return array         信息添加状态
 */
function pms_update_corp($data) {
	
	$data['update_time'] = date('Y-m-d H:i:s', time());

	return Db::name('corp') -> where( ['id'=>$data['id']] ) -> update($data);
}

function pms_del_corp($id) {

	// 未入驻，直接删除
	if ($settled = pms_corp_settled($id)) {
		// 如果已入驻，修改入驻状态
		pms_update_settled_status($settled['id'], 0);
		// 修改入驻房间状态	
		pms_update_room_status($settled['rids'], 0);
	}
	// 修改公司状态 为 0
	pms_update_corp_status($id, 0);

	return true;
	
}

function pms_get_settled_corp_count() {
	return Db::name('corp') -> where( ['corp_status'=>2] ) -> count();
}

/**
 * 更新公司状态
 * @param  int $id     公司ID
 * @param  int $status 公司状态
 * @return 
 */
function pms_update_corp_status($id, $status) {
	
	return Db::name('corp') -> where(['id' => $id]) -> setField('corp_status', $status);
}

function pms_corp_settled($id) {
	
	return Db::name('settled') -> where(['cid' => $id]) -> field('id, rids') -> find();
}


function pms_corp_status_to_string($status) {
	$msg = '';
	switch ($status) {
		case 0:
			$msg = '已注销';
			break;
		case 2:
			$msg = '已入驻';
			break;
		case 3:
			$msg = '到期';
			break;

		default:
			$msg = '未入驻';
			break;
	}
	return $msg;
}

/**
 * 添加公司入驻信息
 * @param  array  $data 入驻信息
 * @return array        信息添加状态
 */
function pms_insert_settled($data) {
	
	$data['settled_status'] = 1;	// 正常
	$data['create_time'] = date('Y-m-d H:i:s', time());

	return Db::name('settled') -> insert($data);
}

function pms_update_settled_status($id, $status) {

	return Db::name('settled') -> where(['id' => $id]) -> setField('settled_status', $status);
}

function pms_get_settled($param) {
	
	$condition = [
		'settled_status' => ['neq', 0]
	];
	
	$where = isset($param['where']) ? $param['where'] : "1";

	$field = isset($param['field']) ? $param['field'] : "*";

	$settled = Db::name('settled')
					-> where($condition)
					-> where($where)
					-> field($field) -> find();


    return $settled;
}

/**
 * 入驻成功，更新相关状态
 * @param  array $data 入驻信息数组
 * @return        
 */
function pms_settled_success($data) {

	// 更新房间状态
	if (!empty($data['rids'])) {
		pms_update_room_status($data['rids'], 1);
	}
	// 更新公司状态
	if (!empty($data['cid'])) {
		pms_update_corp_status($data['cid'], 2);
	}
	// 添加支付状态
	pms_insert_payment($data['cid'], $data['rent'], 1, $data['end_time']);
}


/**
 * 添加缴费信息
 * @param  int 	 $id       入驻信息ID
 * @param  float $rent     缴费金额
 * @param  int   $pay_type 缴费类型
 * @return int             数据库添加状态
 */
function pms_insert_payment($id, $rent, $pay_type, $end_time) {
	
	$data['corp_id'] = $id;
	$data['pay_amount'] = $rent;
	$data['pay_type'] = $pay_type;
	$data['pay_status'] = 1;
	$data['end_time'] = $end_time;
	$data['create_time'] = date('Y-m-d H:s:i', time());

	return Db::name('payment') -> insert($data);
}

function pms_get_payment_list($param) {
	
	$where = isset($param['where']) ? $param['where'] : "";

	$limit = isset($param['limit']) ? $param['limit'] : "";
	$order = empty($param['order']) ? 'p.create_time desc' : $param['order'];
	$page = isset($param['page']) ? $param['page'] : false;

	$field = isset($param['field']) ? $param['field'] : "p.*, c.corp_name";
	// 入驻房间信息
	$join = [
		['pms_corp c', 'p.corp_id = c.id', 'LEFT']
	];

	$payment = Db::name('payment') -> alias('p')
					-> where(['p.pay_status'=>'1'])
					-> where($where)
					-> join($join)
					-> field($field)
					-> order($order);
	$return = [];

	if (empty($page)) {
		$payment = $payment->limit($limit)->select();
        $return['payment'] = $payment;
	} else {

        if (is_array($page)) {
            if (empty($page['list_rows'])) {
                $page['list_rows'] = 10;
            }

            $payment = $payment->paginate($page);
        } else {
            $payment = $payment->paginate(intval($page));
        }

        $payment->appends(request()->param());

        $return['payment']     = $payment->items();
        $return['page']        = $payment->render();
        $return['total']       = $payment->total();
        $return['total_pages'] = $payment->lastPage();
	}

	return $return;
}