<?php
if(!defined('PROJECT_NAME')) die('project empty');
class guanjiaControl extends user_storeControl{
	private $classes = null;
	private $lable = null;
	public function __construct(){
		parent::__construct();
		//添加方法就行，这样可以控制顶部
		/*
		$is_header = array('index');
		if(in_array($_GET['op'] , $is_header)){
			self::setheader('header_index');
		}
		*/
		if(isset($_SESSION['user'])){
			$this->user = $_SESSION['user'];
		}else{
			require_once(BasePath.DS.'payment/wx_pay/example/WxPay.JsApiPay.php');
			$tools = new JsApiPay();
			$openId = $tools->GetOpenid();
			$user = M('user')->where(array('openid'=>$openId))->find();
			$this->openId = $openId;
			$this->user = $user;
			$_SESSION['user'] = $user;
		}
	}
	//管家控制器设置
	public function guanjia(){
		$guanjia_id = $_GET['guanjia_id'];
	//	$guanjia_id = 1;
		$guanjia = M('guanjia')->where(array('guanjia_id'=>$guanjia_id))->find();
		$guanjia['guanjia_logo'] = get_img($guanjia['guanjia_logo'],'guanjia');
		self::output('data',$guanjia);
		self::display('guanjia');
	}
	
	public function hujiaoguanjia(){
		$order_id =intval($_GET['order_id']);
		self::output('order_id',$order_id);
		self::display('hujiaoguanjia');
	}
}
?>