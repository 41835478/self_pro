<?php
//后台控制器
class sysControl extends control{
	//private $type='';
	public function __construct(){
	//	$this->__init();
	//	$this->__weight();
		$this->is_login();
	}
	
	public function is_login(){
		if(!isset($_SESSION['admin'])){
			header('Location:?act=login&op=login');
		}
	}
	
	//初始化
	public function __init(){
	
	}
	
	//权限检查
	public function __weight(){
		
	}
	
	public static function set_menu(){
		
	}
	
}
?>