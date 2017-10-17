<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	短信
*/
class shortControl extends sysControl{
	
	//短信
	public function short_message(){
		$name = 'short_message';
		$data = '';
		$system_conf = M('config')->where(array('name' => $name))->find();
		if(!empty($system_conf)){
			$data = unserialize($system_conf['value']);
			$data['id'] = $system_conf['id'];
			$this->short_message_link($data);
		}
		
		self::display('short_index');
	}
	
	public function short_message_edit(){
		if($_POST){
			$this->short_commit();
		}
		$name = 'short_message';
		$data = '';
		$system_conf = M('config')->where(array('name' => $name))->find();
		if(!empty($system_conf)){
			$data = unserialize($system_conf['value']);
			$data['id'] = $system_conf['id'];
			
		}
		$data['name'] = $name;
		$data['auth_path'] = 'http://'.str_replace('http://','',URL.DS);
		$data['desc'] = '填写字母即可:创蓝(cl)';
		self::form("this",array(
			array('hidden','id','ID'),
			array('hidden','name','短信'),
			array('text','desc','类型说明',array('disabled' => 'disabled' ,'width' => 'auto')),
			array('text','type','类型'),
			array('text','username','帐号'),
			array('text','password','密码'),
			array('text','keyword1','参数1'),
			array('text','keyword2','参数2'),
			array('text','keyword3','参数3'),
			array('radio','is_open','是否启用',array('1' => '启用' , '2' => '禁止')),
		),$data,'post','public_form');
	}
	
	private function short_message_link($data){
		switch($data['type']){
			case 'cl':
				$data['url'] = '?act=short&op=short_message_page';
				$data['name'] = '创蓝短信';
				self::output('short_data',$data);
			break;
		}
	}
	
	
	public function short_commit(){
		$field = array('id','name');
		$table = new table('config');
		$data = array();
		$data['type'] 	  = trim($_POST['type']);
		$data['username'] = trim($_POST['username']);
		$data['password'] = trim($_POST['password']);
		$data['keyword1'] = trim($_POST['keyword1']);
		$data['keyword2'] = trim($_POST['keyword2']);
		$data['keyword3'] = trim($_POST['keyword3']);
		if(empty($_POST['is_open'])){
			show_message(array('code' => '-1' , 'msg' => '是否启用'),'json');
		}
		$data['is_open'] = $_POST['is_open'];
		
		$data = serialize($data);
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->type('name','unique')		//主键
			  ->other('add',array('value' => $data , 'update_time' => time(),'c_type' => 3))  //添加的时候附加的值	//更新的时候附加的值
			  ->other('update',array( 'value' => $data,'update_time' => time() ,'c_type' => 3))
			  ->commit();
		$data = $table->get_state();
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('config')->where(array('id' => $res))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了短信配置,id是'.$res,
			);
			M('admin_log')->add($log);
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('config')->where(array('id' => $_POST['id']))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时修改了短信配置,id是'.intval($_POST['id']),
			);
			M('admin_log')->add($log);
		}
		if($res){
			show_message(array('code' => '1' ,'msg' => '操作成功'),'json');
		}else{
			show_message(array('code' => '-1' ,'msg' => '操作失败'),'json');
		}
	}
	
	//短信页面
	public function short_message_page(){
		$name = 'short_message';
		$data = '';
		$system_conf = M('config')->where(array('name' => $name))->find();
		if(!empty($system_conf)){
			$data = unserialize($system_conf['value']);
			$data['id'] = $system_conf['id'];
			$botton = array();
			switch($data['type']){
				case 'cl':
					$d1 = array(
						'url' => '?act=short&op=short_message_send',
						'name' => '发送短信测试',
					);
					$d2 = array(
						'url' => '?act=short&op=short_message_balance',
						'name' => '余额查询',
					);
					$botton[] = $d1;
					$botton[] = $d2;
				break;
			}
			self::output('botton',$botton);
		}
		self::display('short_message_page');
	}
	
	//短信发送测试
	public function short_message_send(){
		
		if($_POST){
			$name = 'short_message';
			$data = '';
			$system_conf = M('config')->where(array('name' => $name))->find();
			$phone = trim($_POST['phone']);
			$message = trim($_POST['message']);
			if(!empty($system_conf)){
				$data = unserialize($system_conf['value']);
				$data['id'] = $system_conf['id'];
				switch($data['type']){
					case 'cl':
						
						include_once BasePath.DS.PLUGINS.DS.'/cldx/ChuanglanSmsHelper/ChuanglanSmsApi.php';
						$clapi  = new ChuanglanSmsApi();
						$result = $clapi->sendSMS($phone, $message);
						
						if(!is_null(json_decode($result))){
	
							$output=json_decode($result,true);
							if(isset($output['code'])  && $output['code']=='0'){
								show_message(array('code' => '1' , 'msg' => '短信发送成功！'),'json');
							}else{
								show_message(array('code' => '-1' , 'msg' => '短信发送失败！'),'json');
							}
						}else{
								show_message(array('code' => '-1' , 'msg' => '短信发送失败！'),'json');
						}
						die;
					break;
				}
			}
		}
		
		self::form("this",array(
			array('text','phone','手机号'),
			array('text','message','信息'),
		),'','post','public_form');
	}
	
	public function short_message_balance(){
		$name = 'short_message';
		$data = '';
		$system_conf = M('config')->where(array('name' => $name))->find();
		$phone = trim($_POST['phone']);
		$message = trim($_POST['message']);
		$price = '金额未知';
		if(!empty($system_conf)){
			$data = unserialize($system_conf['value']);
			$data['id'] = $system_conf['id'];
			switch($data['type']){
				case 'cl':
					include_once BasePath.DS.PLUGINS.DS.'/cldx/ChuanglanSmsHelper/ChuanglanSmsApi.php';
					$clapi  = new ChuanglanSmsApi();
					$result = $clapi->queryBalance();
					if(!is_null(json_decode($result))){
						$output=json_decode($result,true);
						if(isset($output['code'])  && $output['code']=='0'){
							$price = $output['balance'];
						}
					}
				break;
			}
		}
		$dat[0]['price'] = $price;
		self::form_list(array(
			array('label','price','余额'),
		),$dat,'id');
	}
	
}
?>