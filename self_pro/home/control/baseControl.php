<?php
if(!defined('PROJECT_NAME')) die('project empty');
class baseControl extends control{
	public function __construct(){
	//	$this->__init();
	}
	public function __init(){
		$url='http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	//	if($_SESSION['wx_jdk']){
	//		 $wx_jdk = $_SESSION['wx_jdk'];
	//	}else{
			require_once(BasePath.DS.'payment/wx_pay/example/WxPay.JsApiPay.php');
			$tools = new JsApiPay();
			$wx_jdk = $tools->GetEditAddressParameters();
			$wx_jdk = json_decode($wx_jdk,true);
			
			$token  = $tools->get_token();
		
			$ticket = $tools->getNowJsapiTicket($token);
			
			
			$string='jsapi_ticket='.$ticket.'&noncestr='.$wx_jdk['nonceStr'].'&timestamp='.$wx_jdk['timeStamp'].'&url='.$url;
			
			$signature = sha1($string);
			$wx_jdk['signature'] = $signature;
			$_SESSION['wx_jdk'] = $wx_jdk; 
	//	}
		$wechatShare = array(
			'title'	=> 'LK邀请你体验黑眼圈潮趴馆',
			'desc'	=> 'VR设备、Xbox、桌游、KTV等娱乐无限畅玩',
			'link'	=> 'http://'.$_SERVER["SERVER_NAME"],
			'imgUrl'=> 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].'/data/default_file/logo2.jpg',
		);
		self::output('wechatShare',$wechatShare);
		self::output('wx_jdk',$wx_jdk);
		self::setfooter('public_footer');
	}
}

//商铺控制器
class user_storeControl extends control{
	
}

?>