<?php
//后台控制器
class sysControl extends control{
	//private $type='';
	public function __construct(){
	//	$this->__init();
	//	$this->__weight();
		$this->is_login();
	//	$this->__weight();
	}
	
	public function is_login(){
		if(!isset($_SESSION['area'])){
			header('Location:?act=login&op=login');
		}
	}
	
	//初始化
	public function __init(){
	
	}
	
	//权限检查
	public function __weight(){
		$act = $_GET['act'];
		$op  = $_GET['op'];
		$menu = read_language('menu');
		$str = '?act='.$act.'&op='.$op;
		$p = '';
		foreach($menu['left'] as $key => $val){
			foreach($val as $k => $v){
				if($v[1] == $str){
					$p = $key.'_'.$k;
					break;
				}
			}
			if($p){
				break;
			}
		}
		$admin = $_SESSION['admin'];
		
		$admin = M('admin')->where(array('id' => $admin['id']))->find();
		if($admin['user_type'] != 1){
			$admin['weight'] = unserialize($admin['weight']);
			$is_weight = false;
			foreach($admin['weight'] as $key => $val){
				if($key == $p){
					$is_weight = true;
					break;
				}
			}
			if(!$is_weight){
				show_message('权限不足','html','-1');
			}
		}
	}
	
	public static function set_menu(){
		
	}
	
}
?>