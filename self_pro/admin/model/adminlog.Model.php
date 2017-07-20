<?php
if(!defined('PROJECT_NAME')) die('project empty');
class adminlogModel{
	//后台管理员添加用户
	public function add_log(){
		$data = array(
			'admin' 	 	=> $_SESSION['admin'],
			'admin_desc' 	=> $_SESSION['admin'].'在'.date('Y-m-d H:i:s').'添加了用户'.$_POST['username'],
			'add_time'   	=> time(),
		);
		M('admin_log')->insert($data);
	}
	//更新用户日志
	public function update_log(){
		$data = array(
			'admin' 	 	=> $_SESSION['admin'],
			'admin_desc' 	=> $_SESSION['admin'].'在'.date('Y-m-d H:i:s').'修改了用户'.$_POST['username'],
			'add_time'   	=> time(),
		);
		M('admin_log')->insert($data);
	}
	
	public function login_log(){
		$data = array(
			'admin' 	 	=> $_SESSION['admin'],
			'admin_desc' 	=> $_POST['username'].'登陆时间：'.date('Y-m-d H:i:s'),
			'add_time'   	=> time(),
		);
		M('admin_log')->insert($data);
	}
}
?>