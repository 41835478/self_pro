<?php
if(!defined('PROJECT_NAME')) die('project empty');
class alldanControl extends baseControl{
	public $openId = null;
	public $user = null;
	
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
	
	//推荐页面
	public function alldan(){
		$user_id = $this->user['user_id'];
		$user = M('user')->where(array('user_id'=>$user_id))->find();
		$recommend_num = M('user')->where(array('user_pid' => $user_id ))->count();
		$yaoqingma = $user['invitation'];  //邀请码
		$jifen = $user['user_integral'];	//积分
		$yaoqing = $recommend_num; 	//邀请人数
		self::output('yaoqingma',$yaoqingma);
		self::output('jifen',$jifen);
		self::output('yaoqing',$yaoqing);
		
		$url = '/public/imgs/wechat.jpg';
		$qrcode = new qr_code($url,'H',6);
		$img = $qrcode->get_img();
		self::output('img',$img);
		self::display('alldan');
	}
	
}
?>