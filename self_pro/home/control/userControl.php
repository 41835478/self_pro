<?php
if(!defined('PROJECT_NAME')) die('project empty');
class userControl extends baseControl{
	public $openId = null;
	public $user = null;
	public function __construct(){
		
		parent::__construct();
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
	
	public function index(){
		self::display('user_index');
	}
	
		//用户积分
	public function jifen(){
		$user = $this->user;
		$dangqiankeyong = 0;   //当前可用
		$benyuexinzeng = 0;	//本月新增
		$list = M('user_jifen')->where(array('user_id'=> $user['user_id'],'create_time'=>'>'.strtotime(date('Y-m'))))->select();
		if(!empty($list)){
			foreach($list as $key => $val){
				$benyuexinzeng += $val['jifen'];
			}
		}
		$list2 = M('user_jifen')->where(array('user_id'=> $user['user_id']))->select();
		$dangqiankeyong = $user['user_integral'];
		self::output('dangqiankeyong',$dangqiankeyong);
		self::output('benyuexinzeng',$benyuexinzeng);
		self::output('list',$list2);
		self::display("jifen");
	}

	public function coupon(){
		
		$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : intval($_GET['user_id']);
		$order_id = isset($_GET['order_id'])? intval($_GET['order_id']):0;
		
		$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
		if($order_id > 0){
			$order = M('order')->where(array('order_id'=>$order_id))->find();
		}else{
			self::display('coupon');
			die;
		}
		self::output('order_id',$order_id);
		//可以使用
		$is_use = array(
			'user_id' 	=> $user_id,			//此用户
			'is_use' 	=> 0 ,	//是否已经使用
			'use_price' => '<='.$order['price'] ,  //订单的价格要超过这个价格
			'end_time'  => '>'.time(),   //结束日期要大于当前日期
		);
		$is_use_list = array();
		$is_use_list = M('user_coupon')->where($is_use)->select();
		
		//不可以使用
		$no_use_list = M('user_coupon')->where('(user_id='.$user_id.' and is_use=1)')     //已使用
									   ->where('(user_id='.$user_id.' and is_use=0 and end_time < '.time().')','OR')				//已过期
									   ->where('(user_id='.$user_id.' and is_use=0 and use_price > '.$order['price'].')','OR')	//价格不符的
									   ->select();
								   
		self::output('is_use_list',$is_use_list);
		self::output('no_use_list',$no_use_list);
		self::display('coupon');
	}
	
	public function coupon2(){
		$user = $this->user;
		$user_id = $user['user_id'];
		
		//可以使用
		$is_use = array(
			'user_id' 	=> $user_id,			//此用户
			'is_use' 	=> 0 ,	//是否已经使用
		//	'use_price' => '<='.$order['price'] ,  //订单的价格要超过这个价格
			'end_time'  => '>'.time(),   //结束日期要大于当前日期
		);
		$is_use_list = array();
		$is_use_list = M('user_coupon')->where($is_use)->select();
		$duihuanma = M('duihuanma')->where(array('user_id' => $user_id , 'is_use' => 0,'is_del' => 0))->select();  //3好类型兑换码
		if(!empty($duihuanma)){
			foreach($duihuanma as $key => $val){
				$d['coupon_id'] = $val['d_id'];
				$d['coupon_price'] = $val['d_price'];
				$d['coupon_name'] = '酒水兑换卷';
				$d['coupon_desc'] = '优惠码:'.$val['d_code'];
				$d['start_time'] = '0';
				$d['end_time'] = '0';
				$is_use_list[] = $d;
			}
		}
		//不可以使用
		$no_use_list = M('user_coupon')->where('(user_id='.$user_id.' and is_use=1)')     //已使用
									   ->where('(user_id='.$user_id.' and is_use=0 and end_time < '.time().')','OR')				//已过期
									//   ->where('(user_id='.$user_id.' and is_use=0 and use_price > '.$order['price'].')','OR')	//价格不符的
									   ->select();
		$use_duihuanma = M('duihuanma')->where(array('user_id' => $user_id , 'is_use' => 1))->select();
		if(!empty($use_duihuanma)){
			foreach($use_duihuanma as $key => $val){
				$d['coupon_id'] = $val['d_id'];
				$d['coupon_price'] = $val['d_price'];
				$d['coupon_name'] = '酒水兑换卷';
				$d['coupon_desc'] = '优惠码:'.$val['d_code'];
				$d['start_time'] = '0';
				$d['end_time'] = '0';
				$no_use_list[] = $d;
			}
		}								   
		self::output('is_use_list',$is_use_list);
		self::output('no_use_list',$no_use_list);
		self::display('coupon');
	}
	//用户开发票
	public function wei_fap(){
		$user = $this->user;
	//	$user['user_id'] = 10;
		self::output('user',$user);
		$where = array(
			'user_id'=>$user['user_id'],
			'order_state'=>0,
			'pay'=>'1',
			'is_settlement'=>0
			);
		$order = M('order')->where($where)->find();
	//	$order['order_id'] = 10;
		self::output('order',$order);
		self::display('wei_fap');
	}
	
	//用户信息
	public function person_info(){
		/*
		require_once(BasePath.DS.'payment/wx_pay/example/WxPay.JsApiPay.php');
		$tools = new JsApiPay();
		$openId = $tools->GetOpenid();
		*/
		$user = $this->user;
		
		$user = M('user')->where(array('user_id'=>$user['user_id']))->find();
		
		$level = M('user_level')->where(array('level_id'=>$user['level_id']))->find();
		self::output('user',$user);
		
		self::output('level_name',$level['level_name']);
		
		//循环所有可退押金订单
		$order = M('order')->where(array('user_id'=>$user['user_id'],'deposit_pay' => 1))->order('create_time desc')->select();
		if(!empty($order)){
			$yajin_order['deposit'] = 0;
			foreach($order as $key => $val){
				$yajin_order['deposit'] += $val['deposit'];
			}
			//$yajin_order = '';
			self::output('yajin_order',$yajin_order);
		}
		$all_order_num = M('order')->where(array('user_id'=>$user['user_id'],'is_del' => 0))->count();
		self::output('all_order_num',$all_order_num );
		self::display('person_info');
	}
	//用户信息大客户
	public function dakehu(){
		self::display("dakehu");
		
	}
	
	//用户信息大客户
	/*
	public function userdian(){
		self::display("userdian");
		
	}
	*/
	//用户信息大客户
	public function pingjiaxiangqing(){
		$user = $this->user;
		$order_id = intval($_GET['order_id']);
		if($order_id > 0){
			$order = M('order')->where(array('order_id' => $order_id))->find();
			$user_evaluate = M('user_evaluate')->where(array('order_id' => $order_id))->find();
			self::output('order',$order );
			self::output('user',$user );
			
			
			if(!empty($user_evaluate['images'])){
				$user_evaluate['images'] = explode(',',$user_evaluate['images']);
				self::output('user_evaluate',$user_evaluate );
				self::display("pingjiaxiangqing_tu");
			}else{
				self::output('user_evaluate',$user_evaluate );
				self::display("pingjiaxiangqing");
			}
		}
	}
	//用户信息大客户
	/*
	public function pingjiaxiangqing_tu(){
		self::display("pingjiaxiangqing_tu");
	}
	*/
	//此页面必须自动订单id呀 >.<
	//fangjian
	public function fangjian(){
		$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
		if(isset($_COOKIE['order_id']) && $_COOKIE['order_id'] > 0){
			$order_id = $_COOKIE['order_id'];
		}
		if($order_id == 0){
			header('Location:index.php?act=user&op=fangjian2');
		}
		
		$_COOKIE['order_id'] = $order_id;
	//	$order['store_id'] = 2;
	//	$order_id = 1;
		if(!empty($order_id)){
			$order = M('order')->where(array('order_id'=>$order_id))->find();
			$store = M('store')->where(array('store_id'=>$order['store_id']))->find();
			if(!empty($store['wifi_logo'])){
				$store['wifi_logo'] = get_img($store['wifi_logo'],'store');
			}
			self::output('order',$order );
			self::output('store',$store );
		}
		$week = date('w',time());
		if($week == 0 ){
			$week = 7;
		}
		$order['store_id'] = 5;
		$week_work = M('guanjia_work')->where(array('store_id'=>$order['store_id']))->find();
		if(!empty($week_work)){
			$guanjia_id = $week_work['week'.$week];
			$guanjia = M('guanjia')->where(array('guanjia_id'=>$guanjia_id))->find();
			if(!empty($guanjia)){
				self::output('guanjia',$guanjia);
			}
		}
		
		self::display("fangjian");
	}
	
	//fangjian
	public function fangjian2(){
		
		$user = $this->user;
		$user_id = $user['user_id'];
		$order = M('order')->where(array('start_time'=>'<='.time()-900,'end_time'=>'>='.time(),'user_id'=>$user_id))->find();
		self::output('order',$order);
		if(!empty($order)){
			$url = 'http://'.$_SERVER['SERVER_NAME'].'?act=user&op=fangjian&order_id='.$order['order_id'];
			$qrcode = new qr_code($url,'H',10);
			$img = $qrcode->get_img();
			self::output('img',$img);
		}
		
		/*
		$url = '?act=user&op=fangjian&order_id='.$order['order_id'];
		$qrcode = new qr_code($url,'H',10);
		$img = $qrcode->get_img();
		self::output('img',$img);
		*/
		self::display("fangjian2");
	}
	
	//个人资料
	public function gerenziliao(){
		$user = $this->user;
		$user = M('user')->where(array('user_id'=>$user['user_id']))->find();
		self::output('user',$user);
		self::display("gerenziliao");
		
	}
	
	//意见反馈  ok
	public function advice(){
		$user = $this->user;
		self::output('user',$user);
		self::display("advice");
	}
	
	//意见反馈
	public function dairuzhu(){
		$user = $this->user;
		$where = array(
			'user_id'=> $user['user_id'],
			'start_time'=>'>'.time(),
			'pay'=>1
		);
		$order = M('order')
				->join('left __AFFIX__store','__AFFIX__order.store_id = __AFFIX__store.store_id')
				->where($where)
				->select();
		if(!empty($order)){
			foreach($order as $key => $val){
				$order[$key]['store_logo'] = get_img($val['store_logo'],'store');
			}
		}
		self::output('order',$order);
		self::display("dairuzhu");
	}
	
	//评价晒单
	public function evaluate_detail(){
		$user = $this->user;
		$order_id = intval($_GET['order_id']);
		$order = M('order')->where(array('order_id'=>$order_id))->find();
		$user = $this->user;
		self::output('user',$user);
		$order['sign'] = en_key($order['order_no'],KEY);
		self::output('order',$order);
		self::display("evaluate_detail");
	}
	
	public function get_duihuanma(){
		$user = $this->user;
		if($_POST){
			$d_code = trim($_POST['d_code']);
			if(!empty($d_code)){
				$where = array(
					'd_code' => $d_code,
					'is_use' => 0,
					'is_del' => 0,
				);
				$is = M('duihuanma')->where($where)->find();
				if($is){
					$update = array(
						'user_id' => $user['user_id'],
					);
					$res = M('duihuanma')->where(array('d_id' => $is['d_id']))->update($update);
					if($res){
						show_message('兑换成功','html','?act=user&op=person_info');
					}else{
						show_message('兑换失败','html','?act=user&op=person_info');
					}
				}else{
					show_message('兑换码错误','html','-1');
				}
			}
		}
		self::display("get_duihuanma");
	}
	
	//pingjia
	public function evaluate(){
		$user = $this->user;
		$daipingjia = M('order')
						->join('left __AFFIX__store','__AFFIX__store.store_id = __AFFIX__order.store_id')
						->where(array('user_id'=>$user['user_id'],'pay'=>1,'is_pingjia'=>0))
						->select();
		if(!empty($daipingjia)){
			foreach($daipingjia as $key => $val){
				$daipingjia[$key]['store_logo'] = get_img($val['store_logo'],'store');
			}
		}
		$yipingjia 	= M('order')
						->join('left __AFFIX__store','__AFFIX__store.store_id = __AFFIX__order.store_id')
						->where(array('user_id'=>$user['user_id'],'pay'=>1,'is_pingjia'=>1))
						->select();
		if(!empty($yipingjia)){
			foreach($yipingjia as $key => $val){
				$yipingjia[$key]['store_logo'] = get_img($val['store_logo'],'store');
			}
		}
		self::output('daipingjia',$daipingjia);
		self::output('yipingjia',$yipingjia);
		self::display("evaluate");
	}
}
?>