<?php
if(!defined('PROJECT_NAME')) die('project empty');
class testControl extends baseControl{
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
	
	public function rand_chou(){
		$where = array(
			'is_open' => 1,
		);
		$store = M('store')->where($where)->select();
		
		$d1 = array();
		$d2 = array();
		
		for($i = 0 ; $i <= 100000 ; $i++){
			$d1[] = $i;
			$d2[] = $i;
		}
		
		foreach($store as $key => $val){
			$list = M('store_rand_num')->where(array('store_id' => $val['store_id']))->select();
			if(!empty($list)){
				$arr = array();
				foreach($list as $k => $v){
					if(isset($d2[$v['store_num']])){
						unset($d2[$v['store_num']]);
					}
				}
			}
			$s_time = strtotime(date('Y-m-d 00:00:00'));
			$e_time = strtotime(date('Y-m-d 23:59:59'));
			$st = M('store_rand_num')->where('store_id = '.$val['store_id'].' and create_time >'.$s_time.' and create_time < '.$e_time)->find();
			if(!empty($st)){
				$store[$key]['num'] = $st['store_num'];
			//	var_dump($st);die;
			}
			$store[$key]['store_num'] = implode(',',$d2);
			$d2 = $d1;
		}
		self::output('store',$store);
		self::display('rand_chou');
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
	
	public function index(){
		$this->get_wx_openid();
		$user= $this->user;
		//获取广告
		$adv_id = 1;
		$adv = M('adv',true)->find($adv_id);
		self::output('adv',$adv['images']);
		
		//获取店铺
		$store_list = M('store',true)->get_store_index_list();
		if(!empty($store_list)){
			$week = date('w');
			if($week == 0){
				$week = 7;
			}
			foreach($store_list as $key => $val){
				$where = array(
					'store_id' 		=> $val['store_id'],
					'update_time' 	=> 0,
					'label' 		=> 1,
				);
				$week_price = M('goods_week_price')->where($where)->find();
				if(!empty($week_price)){
					$store_list[$key]['price'] = $week_price['week'.$week];
				}
				
				if(!empty($store_list[$key]['store_label'])){
					$store_list[$key]['store_label'] = explode('|',$store_list[$key]['store_label']);
				}
				
			}
		}
		
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
		self::setfooter('footer_index');
		
		//var_dump($store_list);die;
		self::output('store_list',$store_list);
		
		self::display('test');
	}
	
	//页面列表
	public function web_list(){
		self::display('web_list');
	}
	
	public function send_phone_code(){
		$store_id = intval($_GET['store_id']);
		$this->get_wx_openid();
		$user= $this->user;
		if(empty($user)){
			show_message('请先关注一下我们的公众号哟~','html','?act=user&op=fangjian2');
		}
		if($_POST && $_POST['order_id'] > 0){
			$phone = $_POST['phone'];
			$order_id = $_POST['order_id'];
			$user_id= $_POST['user_id'];
			//var_dump($_POST['yanzhengma']);die;
			if(isset($_SESSION['phone_code']) && $_SESSION['phone_code'] == $_POST['yanzhengma']){
				$res = M('order')->where(array('order_id'=>$order_id))->update(array('user_id'=>$user['user_id']));
				M('order_goods_buy')->where(array('order_id'=>$order_id))->update(array('user_id'=>$user['user_id']));
				$order = M('order')->where(array('order_id'=>$order_id))->find();
				if($res){
					if($order['deposit_pay'] == 0){ //押金未支付
						header('Location:?act=order&op=wait_pay');
						//?act=order&op=wait_pay
					}else{
						header('Location:?act=user&op=person_info');
					}
				}else{
					show_message('订单错误','html','-1');
				}
			}else{
				show_message('验证码错误','html','-1');
			}
		}
		
		if($store_id > 0){
			$where = array(
				'store_id' =>$_SESSION['store_id'],
				'start_time' => '<'.time(),
				'end_time' => '>'.time(),
				'pay' => 1,
				'store_id' => $store_id,
			);
			$order = M('order')->where($where)->find();
			if(!empty($order)){
				$order['sign'] = en_key($order['order_no'],KEY);
				self::output('order',$order );
				self::output('user',$user);
			}
			
			self::display('send_phone_code');
		}
	}
	
	//用户消费清单
	public function yonghuxiaofeiqingdan(){
		$x_id = $_GET['x_id'];
	//	$x_id = 2;
		$data = M('xiaofeiqingdan')->where(array('x_id' => $x_id))->find();
		if(!empty($data)){
			self::output('data',$data);
			self::display('yonghuxiaofeiqingdan');
		}
	}
	
	public function school_information(){
		file_put_contents(BasePath.DS.'data/fangwen.log',"1\n",FILE_APPEND);
		file_put_contents(BasePath.DS.'data/b.log',$_SESSION['is_toupiao']);
		$this->get_new_wx_openid();
		$user = $this->user;
		$where = array(
			's_type' => 1,
			's_pid' => 0,
		);
		$school_information = M('school_information')->where($where)->select();
		if(!empty($school_information)){
			$data = array();$data2 = array();
			foreach($school_information as $key => $val){
				$arr = M('school_information')->where(array('s_pid' => $val['s_id']))->order('s_num desc')->select();
				$count = M('school_information')->field('sum(s_num) as num')->where(array('s_pid' => $val['s_id']))->select();
				if(!empty($arr)){
					$data2['name'] = $val['s_name'];
					$data2['s_num'] = $count[0]['num'];
					$data2['info'] = $arr;
					$data[] = $data2;
				}
				$data = f_sort($data,'r','s_num');
			}
			self::output('data',$data);
		}
		
		self::output('user',$user);
		if(!empty($user)){
			$is_tou = M('school_information_masssage')->where(array('user_id' => $user['user_id']))->find();
			if(!empty($is_tou)){
				
				self::output('is_tou',$_COOKIE['is_toupiao']);
			}
		}
		if(isset($_COOKIE['is_toupiao']) || isset($_SESSION['is_toupiao'])){
			if(isset($_COOKIE['is_toupiao'])){
				self::output('is_tou',$_COOKIE['is_toupiao']);
			}else{
				self::output('is_tou',$_SESSION['is_toupiao']);
				$_COOKIE['is_toupiao'] = $_SESSION['is_toupiao'];
			}
		}
		self::display('school_information');
	}
	
	public function school_information2(){
		file_put_contents(BasePath.DS.'data/fangwen.log',"1\n",FILE_APPEND);
		file_put_contents(BasePath.DS.'data/b.log',$_SESSION['is_toupiao']);
		$this->get_new_wx_openid();
		var_dump($this->openId);die;
		$user = $this->user;
		$where = array(
			's_type' => 1,
			's_pid' => 0,
		);
		$school_information = M('school_information')->where($where)->select();
		if(!empty($school_information)){
			$data = array();$data2 = array();
			foreach($school_information as $key => $val){
				$arr = M('school_information')->where(array('s_pid' => $val['s_id']))->order('s_num desc')->select();
				$count = M('school_information')->field('sum(s_num) as num')->where(array('s_pid' => $val['s_id']))->select();
				if(!empty($arr)){
					$data2['name'] = $val['s_name'];
					$data2['s_num'] = $count[0]['num'];
					$data2['info'] = $arr;
					$data[] = $data2;
				}
				$data = f_sort($data,'r','s_num');
			}
			self::output('data',$data);
		}
		
		self::output('user',$user);
		if(!empty($user)){
			$is_tou = M('school_information_masssage')->where(array('user_id' => $user['user_id']))->find();
			if(!empty($is_tou)){
				
				self::output('is_tou',$_COOKIE['is_toupiao']);
			}
		}
		if(isset($_COOKIE['is_toupiao']) || isset($_SESSION['is_toupiao'])){
			if(isset($_COOKIE['is_toupiao'])){
				self::output('is_tou',$_COOKIE['is_toupiao']);
			}else{
				self::output('is_tou',$_SESSION['is_toupiao']);
				$_COOKIE['is_toupiao'] = $_SESSION['is_toupiao'];
			}
		}
		self::display('school_information');
	}
	
}
?>