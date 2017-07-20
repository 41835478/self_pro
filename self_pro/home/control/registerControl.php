<?php
if(!defined('PROJECT_NAME')) die('project empty');
class registerControl extends control{
	
	public function index(){
		//普通注册
		self::output('pt_register',true);
		//邮箱注册
	//	self::output('email_register',true);
		//手机注册
	//	self::output('mobile_register',true);
		
		self::setheader('register_header');
		
		self::display('register');
	}
}
?>