<?php
if(!defined('PROJECT_NAME')) die('project empty');
class gameControl extends baseControl{
	public $classes = null;
	public $lable = null;
	public function __construct(){
		parent::__construct();
		$this->classes = M('class');
		$this->lable = M('lable');
		
		//添加方法就行，这样可以控制顶部
		/*
		$is_header = array('index');
		if(in_array($_GET['op'] , $is_header)){
			self::setheader('header_index');
			self::setfooter('footer_index');
		}
		*/
	}
	//获取微信配置
	public $openId = null;
	public $user = null;
	private function get_wx_openid(){
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
	
	private function get_new_wx_openid(){
		require_once(BasePath.DS.'payment/wx_pay/example/WxPay.JsApiPay.php');
		$tools = new JsApiPay();
		$openId = $tools->GetOpenid();
		$user = M('user')->where(array('openid'=>$openId))->find();
		$this->openId = $openId;
		$this->user = $user;
		$_SESSION['user'] = $user;
	}
	//验证码
	public function captcha(){
		$captcha = new captcha();  //实例化一个对象
		$captcha->doimg();  
		$_SESSION['phone_captcha'] = $captcha->getCode();
	}
	
	//密室逃脱
	public function mishitaotuo(){
		$this->get_wx_openid();
		$user= $this->user;
		/*
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
		self::output('wx_jdk',$wx_jdk);
		*/
		//获取广告
		$wechatShare = array(
			'title'	=> '变态考反应游戏《密室逃脱》能通关你就能闪子弹了！',
			'desc'	=> '你觉得你反应很快吗？试试就知道！',
			'link'	=> 'http://'.$_SERVER["SERVER_NAME"].'/?act=game&op=mishitaotuo',
		//	'imgUrl'=> 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].'/data/default_file/logo2.jpg',
			'imgUrl'=> 'http://'.$_SERVER["SERVER_NAME"].'/data/default_file/logo2.jpg',
		);
		self::output('wechatShare',$wechatShare);
		self::output('user',$user);
	//	self::setfooter('public_footer');
		self::display('game/mishitaotuo');
	}
	
	//排行
	public function rank(){
		$this->get_wx_openid();
		$user= $this->user;
		$data = M('mishitaotuo')
				->field('__AFFIX__user.user_logo,__AFFIX__user.nickname,__AFFIX__mishitaotuo.*')
				->join('left __AFFIX__user','__AFFIX__user.user_id = __AFFIX__mishitaotuo.user_id')
				->order('num desc')
				->limit(4)
				->select();
				
		
		$my = M('user')
				->field('__AFFIX__user.user_logo,__AFFIX__user.nickname,__AFFIX__mishitaotuo.*')
				->join('left __AFFIX__mishitaotuo','__AFFIX__user.user_id = __AFFIX__mishitaotuo.user_id')
				->where(array('__AFFIX__user.user_id' => $user['user_id']))
				->find();
		if(!empty($my['num'])){
			$my_rank = M('mishitaotuo')->where(array('num'=> '>'.$my['num']))->count();
			$my_rank++;
			self::output('my_rank',$my_rank);
		}
		
		self::output('my',$my);
		
		self::output('data',$data);
		
		self::display('game/rank');
	}
}
?>