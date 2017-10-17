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
			'u_id' => $_SESSION['area']['id'],
			'create_time' => time(),
			'ip' => getIp(),
			'other' => $_SESSION['area']['phone'].'在'.date('Y-m-d H:i:s').'退出了',
		);
		M('admin_log')->add($log);
		
		unset($_SESSION['area']);
		header('Location:?act=login&op=login');
	}
	
	private function is_login(){
		$phone = I('username');
		$password = I('password');
		if(!empty($phone) && !empty($password)){
			$where = array(
				'password' => MD5(MD5($password.KEY).KEY),
				'phone' => $phone,
			);
			$area = M('user')
					->where($where)
					->find();
			
			if(!empty($area)){
				if($area['is_del'] == '1'){
					show_message(array('code' => '-1' , 'msg' => '不存在的账户'),'json');
				}
				
				$_SESSION['area'] = $area;
				
				$log = array(
					'u_id' 	 => $_SESSION['area']['id'],
					'create_time' => time(),
					'ip' 		 => getIp(),
					'admin_type' => '1',
					'other' 	 => $_SESSION['area']['phone'].'在'.date('Y-m-d H:i:s').'登录了',
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