<?php

if(!defined('PROJECT_NAME')) die('project empty');
class loginControl extends control{
	public function login(){
		if($_POST){
			$this->is_login();
		}
		self::display('login');
	}
	
	public function logout(){
		
		$log = array(
			'admin_id' => $_SESSION['admin']['id'],
			'create_time' => time(),
			'ip' => getIp(),
			'other' => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'退出了',
		);
		M('admin_log')->add($log);
		
		unset($_SESSION['admin']);
		header('Location:?act=login&op=login');
	}
	
	private function is_login(){
		$username = I('username');
		$password = I('password');
		if(!empty($username) && !empty($password)){
			$where = array(
				'password' => MD5(MD5($password.KEY).KEY),
				'username' => $username,
			);
			$damin = M('admin')
					->where($where)
					->find();
			if(!empty($damin)){
				if($damin['state'] == '1'){
					show_message(array('code' => '-1' , 'msg' => '禁止登录'),'json');
				}
				if($damin['is_del'] == '1'){
					show_message(array('code' => '-1' , 'msg' => '不存在的账户'),'json');
				}
				$d['id'] 		= $damin['id'];
				$d['username'] 	= $damin['username'];
				$d['pid'] 		= $damin['pid'];
				$d['state'] 	= $damin['state'];
				$d['user_type'] = $damin['user_type'];
				$d['login_time'] = time();
				$_SESSION['admin'] = $d;
				
				$log = array(
					'admin_id' 	 => $_SESSION['admin']['id'],
					'create_time' => time(),
					'ip' 		 => getIp(),
					'admin_type' => '1',
					'other' 	 => $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'登录了',
				);
				M('admin_log')->add($log);
				
				show_message(array('code' => '1' , 'msg' => '登录成功'),'json');
			}else{
				show_message(array('code' => '-1' , 'msg' => '帐号或密码错误'),'json');
			}
		}
	}
}
?>