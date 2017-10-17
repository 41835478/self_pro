<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	系统
*/
class systemControl extends sysControl{
	
	public function system_setting(){
		if($_POST){
			$this->commit();
		}
		$data = '';
		$name = 'web_conf';
		$data['name'] = $name;
		$system_conf = M('config')->where(array('name' => $name))->find();
		if(!empty($system_conf)){
			$data = unserialize($system_conf['value']);
			$data['id'] = $system_conf['id'];
			$data['name'] = $name;
		}
		self::form("this",array(
			array('hidden','id','ID'),
			array('hidden','name','名称'),
			array('text','admin_name','后台名称'),
			array('text','web_name','网站名称'),
			array('text','keyword','关键词'),
			array('text','banquan','版权信息'),
			array('text','beian','备案号'),
			array('text','mobile','手机号'),
			array('text','email','邮箱'),
			array('text','QQ1','qq号1'),
			array('text','QQ2','qq号2'),
			array('radio','is_open','网站是否开启',array('1'=>'开启','2'=>'关闭')),
			array('textarea','close_desc','关闭说明'),
		),$data,'post','system_setting');
	}
	
	private function commit(){
		$field = array('id','name');
		$table = new table('config');
		$data = array();
		$data['admin_name'] = $_POST['admin_name'];
		$data['web_name'] 	= $_POST['web_name'];
		$data['keyword'] 	= $_POST['keyword'];
		$data['banquan'] 	= $_POST['banquan'];
		$data['beian'] 		= $_POST['beian'];
		$data['mobile'] 	= $_POST['mobile'];
		$data['email'] 		= $_POST['email'];
		$data['QQ1'] 		= $_POST['QQ1'];
		$data['QQ2'] 		= $_POST['QQ2'];
		$data['is_open'] 	= $_POST['is_open'];
		if(empty($_POST['is_open'])){
			show_message(array('code' => '-1' , 'msg' => '是否开启网站'),'json');
		}
		$data['close_desc'] = $_POST['close_desc'];
		$data = serialize($data);
		$res = $table
			  ->field($field)
			  ->type('id','auto_key')		//主键
			  ->type('name','unique')		//主键
			  ->other('add',array('value' => $data,'update_time' => time()))  //添加的时候附加的值
			  ->other('update',array( 'value' => $data,'update_time' => time()))						//更新的时候附加的值
			  ->commit();
		$data = $table->get_state();
		if(!empty($data) && $data['M'] == 'add'){
			$u = M('config')->where(array('id' => $res))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'添加了系统配置',
			);
			M('admin_log')->add($log);
		}else if(!empty($data) && $data['M'] == 'update'){
			$u = M('config')->where(array('id' => $_POST['id']))->find();
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
				'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'修改了系统配置',
			);
			M('admin_log')->add($log);
		}
		if($res){
			show_message(array('code' => '1' ,'msg' => '操作成功'),'json');
		}else{
			show_message(array('code' => '-1' ,'msg' => '操作失败'),'json');
		}
	}
}
?>