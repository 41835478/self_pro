<?php
if(!defined('PROJECT_NAME')) die('project empty');
class userControl extends baseControl{
	
	//个人中心
	public function personal(){
		
		if(!isset($_SESSION['user'])){  //如果没有就跳转到登录页面
			$url = URL.DS.PROJECT.DS.'tpl'.DS.WEB.DS.'login/login.html';
			header('Location:'.$url);
		}
		$user = $_SESSION['user'];
		$m_where = array(
			'u_id' => $_SESSION['user']['id'],
			'is_show' => '1',
			'is_del' => '0',
		);
		$message_count = M('user_message')->where($m_where)->count();
		$role = M('role')->where(array('id' => $user['role_id']))->find();
		$user['message_count'] = $message_count;
		$user['role_name'] = $role['name'];
		
		$guanzhu_where = array(
			'is_del'  => '0',
			'is_open' => '1',
			'u_id' 	  => $id,
		);
		$guanzhu = M('userAuser')->where($guanzhu_where)->count();
		
		$guanzhu_where = array(
			'is_del'  => '0',
			'is_open' => '1',
			'p_id' 	  => $id,
		);
		
		$fensi = M('userAuser')->where($fensi_where)->count();
		$user['guanzhu'] = $guanzhu;
		$user['fensi'] = $fensi;
		
		self::output('data',$user);
		self::display('me/me');
	}
	
	public function index(){
		self::display('user_index');
	}
	
	
}
?>