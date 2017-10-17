<?php
if(!defined('PROJECT_NAME')) die('project empty');
class paymentControl extends sysControl{
	
	//支付列表按钮
	public function payment_index(){
		self::display('payment_index');
	}
	
	//微信支付配置
	public function wx_pay(){
		if($_POST){
			$this->wx_commit();
		}
		$name = 'wx_pay';
		$data = '';
		
		$system_conf = M('config')->where(array('name' => $name))->find();
		if(!empty($system_conf)){
			$data = unserialize($system_conf['value']);
			$data['id'] = $system_conf['id'];
			
		}
		$data['name'] = $name;
		$data['auth_path'] = 'http://'.str_replace('http://','',URL.DS);
		self::form("this",array(
			array('hidden','id','ID'),
			array('hidden','name','微信支付'),
			array('text','appid','appId'),
			array('text','appsecret','appsecret'),
			array('text','token','token'),
			array('text','encodingaeskey','EncodingAESKey'),
			array('text','mchid','商户id'),
			array('text','key','支付密钥(商户支付key)'),
			array('text','auth_path','支付授权目录(填写到微信商户平台)'),
			array('radio','is_open','是否启用',array('1' => '启用' , '2' => '禁止')),
		),$data,'post','public_form');
	}
	
	//提交微信配置
	public function wx_commit(){
		$field = array('id','name');
		$table = new table('config');
		$data = array();
		$data['token'] = $_POST['token'];
		$data['encodingaeskey'] = $_POST['encodingaeskey'];
		$data['appid'] = $_POST['appid'];
		$data['appsecret'] = $_POST['appsecret'];
		$data['mchid'] = $_POST['mchid'];
		$data['key'] = $_POST['key'];
		if(empty($_POST['is_open'])){
			show_message(array('code' => '-1' , 'msg' => '是否启用'),'json');
		}
		$data['is_open'] = $_POST['is_open'];
		
		$data = serialize($data);
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->type('name','unique')		//主键
			  ->other('add',array('value' => $data , 'update_time' => time(),'c_type' => 2))  //添加的时候附加的值	//更新的时候附加的值
			  ->other('update',array( 'value' => $data,'update_time' => time() ,'c_type' => 2))
			  ->commit();
		$data = $table->get_state();
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('config')->where(array('id' => $res))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了微信支付配置,id是'.$res,
			);
			M('admin_log')->add($log);
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('config')->where(array('id' => $_POST['id']))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了微信支付配置,id是'.intval($_POST['id']),
			);
			M('admin_log')->add($log);
		}
		if($res){
			show_message(array('code' => '1' ,'msg' => '操作成功'),'json');
		}else{
			show_message(array('code' => '-1' ,'msg' => '操作失败'),'json');
		}
	}
	
	//支付宝支付配置
	public function ali_pay(){
		if($_POST){
			$this->ali_commit();
		}
		$name = 'ali_pay';
		$data = '';
		$system_conf = M('config')->where(array('name' => $name))->find();
		if(!empty($system_conf)){
			$data = unserialize($system_conf['value']);
			$data['id'] = $system_conf['id'];
		}
		$data['name'] = $name;
		self::form("this",array(
			array('hidden','id','ID'),
			array('hidden','name','支付宝支付'),
			array('text','app_id','appid'),
			array('textarea','merchant_private_key','私钥(merchant_private_key)'),
			array('textarea','alipay_public_key','公钥(alipay_public_key)'),
			array('radio','is_open','是否启用',array('1' => '启用' , '2' => '禁止')),
		),$data,'post','public_form');
	}
	
	//支付宝支付配置
	public function ali_commit(){
		$field = array('id','name');
		$table = new table('config');
		$data = array();
		$data['app_id'] = $_POST['app_id'];
		$data['merchant_private_key'] = $_POST['merchant_private_key'];
		$data['alipay_public_key'] = $_POST['alipay_public_key'];
		if(empty($_POST['is_open'])){
			show_message(array('code' => '-1' , 'msg' => '是否启用'),'json');
		}
		$data['is_open'] = $_POST['is_open'];
		
		$data = serialize($data);
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->type('name','unique')		//主键
			  ->other('add',array('value' => $data , 'update_time' => time(),'c_type' => 2))  //添加的时候附加的值	//更新的时候附加的值
			  ->other('update',array( 'value' => $data,'update_time' => time() ,'c_type' => 2))
			  ->commit();
		$data = $table->get_state();
		$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
			);
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('config')->where(array('id' => $res))->find();
			$log['other'] = $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了支付宝支付配置,id是'.$res;
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('config')->where(array('id' => $_POST['id']))->find();
			$log['other'] = $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了支付宝支付配置,id是'.intval($_POST['id']);
		}
		M('admin_log')->add($log);
		if($res){
			show_message(array('code' => '1' ,'msg' => '操作成功'),'json');
		}else{
			show_message(array('code' => '-1' ,'msg' => '操作失败'),'json');
		}
	}
}
?>