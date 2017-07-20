<?php
//后台控制器
class sysControl extends control{
	//private $type='';
	public function __construct(){
	//	$this->__init();
	//	$this->__weight();
	}
	
	public function __init(){
		/*
		self::set_menu();
		$header = read_language('header');
		self::setheader('header');
		self::setleft('left');
		self::setfooter('footer');
		self::output('header',$header);
		if(!isset($_GET['top_id'])){
			if(isset($_SESSION['top_id'])){
				self::output('top_id',$_SESSION['top_id']);
			}else{
				self::output('top_id',0);
			}
		}else{
			$_SESSION['top_id'] = $_GET['top_id'];
			self::output('top_id',$_GET['top_id']);
		}
		//不让跳转
		if(isset($_SESSION['login_state']) && $_SESSION['login_state'] != 'admin'){
			header('Location:index.php?act=login&op=index');
		}
		*/
	}
	
	//权限检查
	public function __weight(){
		
	}
	
	public static function set_menu(){
		/*
		$menu = read_language('menu');
		//取控制权限
		if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0){
			$admin = M('admin')->where(array('admin_id'=>$_SESSION['admin_id']))->find();
			$admin_data = unserialize($admin['con_weight']);
			if(!empty($admin_data) && is_array($admin_data)){
				$menus = array();
				foreach($admin_data as $ak => $av){
					$menus['top'][$ak] =  $menu['top'][$ak];
					$menus['left'][$ak] = $menu['left'][$ak];
				}
				self::output('menu',$menus);
			}else{
				self::output('menu',$menu);
			}
		}else{
			self::output('menu',$menu);
		}
		//超级管理员
		if($admin['admin_state'] == 1){
			self::output('menu',$menu);
		}
		*/
	}
	//调试
	/*
	function debug($type=''){
		$msg = '';
		if(empty($type)){
			$msg = 'function debug no parameters';
			show_message($msg);
		}
		if($type = 'display'){
			$msg = parent::$page;
			show_message($msg);
		}
	}
	*/	
}
?>