<?php
if(!defined('PROJECT_NAME')) die('project empty');
class orderControl extends baseControl{
	
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
		
	}
	
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
	
	//订单预定页面
	public function reserve(){
		$this->get_wx_openid();
		$user= $this->user;
		$store_id = intval($_GET['store_id']);
		self::output('store_id',$store_id);
		$store = M('store')->where(array('store_id'=>$store_id))->find();
		if(!empty($store['store_imgs'])){  //轮播
			$store['store_imgs'] = explode(',',$store['store_imgs']);
			
			foreach($store['store_imgs'] as $key => $val){
				$store['store_imgs'][$key] = get_img( $val , 'store');
			}
			self::output('store_images',$store['store_imgs']);
		}
		if(!empty($store['store_logo'])){
			$store['store_logo'] = get_img( $val , 'store');
		}
		if(!empty($store['store_label'])){
			$store['store_label'] = explode('|',$store['store_label']);
		}
		if(!empty($store['editorValue'])){
			$store['editorValue'] = explode('####',$store['editorValue']);
		}
		$store['position'] = explode('|',$store['position']);  	//	地图
		$store['position_x'] = $store['position'][0];
		$store['position_y'] = $store['position'][1];
		self::output('store',$store);
		
		$changci = M('goods')->where(array('store_id'=>$store_id , 'goods_type'=>1))->limit(2)->select();
		$ci = array();
		if(!empty($changci)){
			foreach($changci as $key => $val){
				$t = explode(':',$val['goods_start_time']);
				$ci[] = $val['goods_id'];  //那几点
				$changci[$key]['start_time'] = $t[0].':'.$t[1];
				$t[0] = $t[0] + $val['duration'];
				$end_time = $t[0].':'.$t[1];
				if($t[0] > 24){
					$t[0] = $t[0] - 24 ;
					$end_time = $t[0] . ':'. $t[1].'(次日)';
				}
				$changci[$key]['end_time'] = $end_time ;
			}
			self::output('changci',$changci);
		}
	
		$where = array(
			'pay' => 1,
			'start_time' => '>'.strtotime(date('Y-m')),
		);
		$next_month = date('m')+1 == 13 ? 1 : date('m')+1;
		$where2 = array(
			'start_time' => '<'.strtotime(date('Y-'.$next_month)),
		);
		$order_list = M('order')
					->where($where)
					->where($where2)
					->select();
		$quanchang = array();
		if(!empty($order_list)){
			foreach($order_list as $key => $val){
				foreach($ci as $k => $v){
					if($v == $val['goods_id']){
						$order_list[$key]['changci'] = $k+1;
						$tt = date('md',$val['start_time']);
						if( $quanchang[$tt] == 1){
							$order_list[$key]['changci'] = 9;  //全场
						}
						$quanchang[$tt] = $k+1;
					}
				//	$order_list[$key]['ttttttttt'] = date('Y-m-d H:i:s',$val['start_time']);   //时间
				}
				
				$order_list[$key]['day'] = date('d',$val['start_time']);
			}
			self::output('order_list',$order_list);
		}
		$yonghupl_where = array(
			'store_id'=> $store_id,
			'is_type' => 1,  //用户
		);
		$yonghupl = M('user_evaluate')->field('__AFFIX__user.nickname,__AFFIX__user.user_logo,__AFFIX__user_evaluate.*')
									->join('left __AFFIX__user','__AFFIX__user_evaluate.user_id = __AFFIX__user.user_id')
									->where($yonghupl_where)->limit(1)->order('create_time desc')
									->find();
		
		$yonghupl_count = M('user_evaluate')->where($yonghupl_where)->order('create_time desc')->count();
		self::output('yonghupl',$yonghupl);
		self::output('yonghupl_count',$yonghupl_count);  //这家点评论
		
		$guanjiapl_where = array(
			'store_id'=> $store_id,
		);
		$thisweek = date('w');
		if($thisweek == 0){
			$thisweek = 7;
		}
		$work = M('guanjia_work')->where(array('store_id'=>$store_id))->find();
		if(!empty($work)){
			$guanjiapl_where['guanjia_id'] = $work['week'.$thisweek];
		}
		$guanjiapl = M('guanjia')->where($guanjiapl_where)->limit(1)->order('create_time desc')->find();
		$guanjiapl['guanjia_biaoqian'] = explode('|',$guanjiapl['guanjia_biaoqian']);
		$guanjiapl['guanjia_logo'] = get_img($guanjiapl['guanjia_logo'],'guanjia');
	
		self::output('guanjiapl',$guanjiapl);
		
		//用户评价
		$yonghupj = M('user_evaluate')->where(array('is_type'=>1))->limit(5)->order('create_time desc')->select();
		$yonghupj['biaoqian'] = explode('|',$yonghupj['biaoqian']);
		self::output('yonghupj',$yonghupj);
		
		self::display('reserve');
	}
	
	//下订单页面  //必须使用微信打开
	public function order(){
		$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
		
		if($order_id > 0){
			
			$this->get_wx_openid();
			$user= $this->user;
			
			$order = M('order')->where(array('order_id'=>$order_id))->find();
			$store = M('store')->where(array('store_id'=> $order['store_id']))->find();
			if(!empty($store)){
				if(!empty($store['editorValue'])){
					$store['editorValue'] = explode('####',$store['editorValue']);
				}
			}
			if(!empty($store['store_logo'])){
				$store['store_logo'] = get_img($store['store_logo'],'store');
			}
			self::output('order_id',$order['order_id']);
			self::output('sign',en_key($order['order_no'],KEY));
			self::output('user',$user);
			self::output('order',$order);
			self::output('store',$store);
			
			
			
			$goods = M('goods')->where(array('goods_type'=>1,'goods_label'=>1,'store_id'=>$order['store_id']))->find();
			$goods['goods_img'] = get_img($goods['goods_img'],'goods');
			
			$yajin = $order['deposit'];  //押金
			$room_price = 0;   //房间消费
			$room = M('order_goods_buy')->where(array('order_id'=>$order_id,'is_del'=>0,'is_buy'=>'0'))->select();
			if(!empty($room)){
				foreach($room as $key => $val){
					$room_price += $val['z_price'];
				}
			}
			
			$youhuijuan = 0;
			$coupon_id = 0;
			if(!empty($order['youhui_price'])){  //这是个id号
				$coupon = M('user_coupon')->where(array('coupon_id'=>$order['youhui_price']))->find();
				if(!empty($coupon)){
					$youhuijuan = $coupon['coupon_price'];
					$coupon_id = $coupon['coupon_id'];
				}
			}else{
				$coupon = M('user_coupon')->where(array('user_id'=>$user['user_id'],'is_use'=>'0','start_time'=>'<'.time(),'end_time'=>'>'.time(),'use_price'=>'<='.$order['price']))->find();
				if(!empty($coupon)){
					M('order')->where(array('order_id' => $order_id))->update(array('youhui_price'=>$coupon['coupon_id']));
					$youhuijuan = $coupon['coupon_price'];
					$coupon_id = $coupon['coupon_id'];
				}
			}
		//	$order['price'] = $order['price'] + $yajin;
			$price = $order['price'];
			$over_price = $order['price'] - $youhuijuan + $room_price ;  //订单价格加上房间消费
			if($over_price < 0){
				$over_price = 0 + $yajin;
			}else{
				$over_price += $yajin;
			}
			$yuanjia = (int)($price / 0.8);  //0.8折
			self::output('goods',$goods);
			$start_time = date('m月d日 H:i',$order['start_time']);//'03月28日 17:00';  //入场
			$end_time = date('m月d日 H:i',$order['end_time']);//'03月29日 09:00';	//离场
			self::output('start_time',$start_time);
			self::output('coupon_id',$coupon_id);
			self::output('end_time',$end_time);
			self::output('yajin',$yajin);
			self::output('youhuijuan',$youhuijuan);
			self::output('price',$price);
			self::output('over_price',$over_price);
			self::output('yuanjia',$yuanjia);
			self::output('room_price',$room_price);
			
			self::display('order');
		}
	}
	public function shangpinzhanshi(){
		$adv_id = 2;  //id是2
		$adv = M('adv',true)->find($adv_id);
		self::output('adv',$adv['images']);
		$store_id = $_GET['store_id'];
	//	$order = M('order')->where(array('order_id'=>$order_id))->find();
		$cat_list = M('category')->where(array('cat_pid'=>0))->limit(4)->select();
		self::output('cat_list',$cat_list);
		$goods_data = array();
		if(!empty($cat_list)){
			foreach($cat_list as $key => $val){
				$where = array(
					'goods_type'=> 2,
					'cat_id' 	=> $val['cat_id'],
					'is_show' 	=> 1,
					'is_del' => 0,
					'store_id' 	=> $store_id,
				);
				$goods = M('goods')->where($where)->order('add_time desc')->select();
				if(!empty($goods)){
					foreach($goods as $k => $v){
						$goods[$k]['goods_img'] = get_img($v['goods_img'],'goods');
						$goods_buy = M('order_goods_buy')->where(array('order_id'=>$order_id,'is_buy'=>0,'goods_id' => $v['goods_id']))->find();
					//	if($goods_buy){
					//		$goods[$k]['num'] = $goods_buy['goods_num'];
					//	}else{
						$goods[$k]['num'] = 0;
					//	}
					}
				}
				$goods_data[($key+1)] = $goods;
			}
		}
		self::output('goods_data',$goods_data);
		self::output('order_id',$order['order_id']);
		self::output('sign',en_key($order['order_no'],KEY));
		self::display('shangpinzhanshi');
	}
	
	//订单列表
	public function order_list(){
		$this->get_wx_openid();
		$user_id = $this->user['user_id'];
		$where = array(
			'user_id' => $user_id,
			'__AFFIX__order.is_del' => 0,
		);
		$order_list = M('order')
					->field('__AFFIX__order.*,__AFFIX__store.store_name,__AFFIX__store.store_logo,__AFFIX__store.store_xx_address')
					->join('left __AFFIX__store','__AFFIX__order.store_id = __AFFIX__store.store_id')
				//	->join('left __AFFIX__goods','__AFFIX__order.goods_id = __AFFIX__goods.goods_id')
					->where($where)
					->select();
		$yiwancheng = array(); $yiquxiao = array(); $daizhifu = array();
		foreach($order_list as $key => $val){
			$val['sign'] = en_key($val['order_no'],KEY);
			$val['store_logo'] = get_img($val['store_logo'],'store');
			$tt = date('H',$val['start_time']);
			/*
			if($val['goods_label'] == 1 || $val['goods_label'] == 3){
				$val['goods_label'] = '场次';
			}else{
				$val['goods_label'] = '场次';
			}
			*/
			if($tt >= 14){
				$val['goods_label'] = '夜场';
			}else{
				$val['goods_label'] = '白场';
			}
			//待支付
			if($val['pay'] == 0 || $val['pay'] == 1 && $val['deposit_pay'] == 0){
				$daizhifu[] = $val;
			}
			//已支付
			if($val['pay'] == 1 && $val['deposit_pay'] == 1 && $val['o_state'] == 0){
				$yiwancheng[] = $val;
			}
			//取消
			if($val['pay'] == 2){
				$yiquxiao[] = $val;
			}
		}
		
		self::output('yiwancheng',$yiwancheng);
		self::output('yiquxiao',$yiquxiao);
		self::output('daizhifu',$daizhifu);
		self::display('order_list');
	}
	
	//订单备注
	public function dingdanbz(){
		//ok,这个暂时不用写
		self::display('dingdanbz');
	}
	
	//退款记录
	public function tuim(){
		$this->get_wx_openid();
		$user = $this->user;
		$tuiyajin = M('tuiyajin')->where(array('user_id'=>$user['user_id']))->select();
		self::output('tuiyajin',$tuiyajin);
		self::display('tuim');
	}
	
	//可退押金
	public function myyaj_ketui(){
		$this->get_wx_openid();
		$user = $this->user;
		if(!empty($user)){
			$order = M('order')->where(array('user_id'=>$user['user_id'],'deposit_pay'=>1))->select();
			
			if(!empty($order)){
				$yajin = 0;
				foreach($order as $key => $val){
					$yajin += $val['deposit'];
				}
				self::output('yajin',$yajin);
			}
		}
		
		self::display('myyaj_ketui');
	}
	
	//可退押金退款中状态页面
	public function myyaj_tuimd(){
		//ok
		self::display('myyaj_tuimd');
	}
		
	//可退押金成功退款页面
	public function myyaj_wanc(){
		self::display('myyaj_wanc');
	}
	
	//房间消费
	public function fangxiao(){
		$adv_id = 2;  //id是2
		$adv = M('adv',true)->find($adv_id);
		self::output('adv',$adv['images']);
		
		$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
	//	$order_id = 1;
		$shuliang = 0;
		if($order_id > 0){
			$order = M('order')->where(array('order_id'=>$order_id))->find();
			$cat_list = M('category')->where(array('cat_pid'=>0))->limit(4)->select();
			self::output('cat_list',$cat_list);
			$goods_data = array();
			if(!empty($cat_list)){
				foreach($cat_list as $key => $val){
					$where = array(
						'goods_type'=> 2,
						'cat_id' => $val['cat_id'],
						'is_show' => 1,
						'is_del' => 0,
						'store_id' => $order['store_id'],
					);
					$goods = M('goods')->where($where)->order('add_time desc')->select();
					if(!empty($goods)){
						
						foreach($goods as $k => $v){
							$goods[$k]['goods_img'] = get_img($v['goods_img'],'goods');
							$goods_buy = M('order_goods_buy')->where(array('order_id'=>$order_id,'is_buy'=>0,'goods_id' => $v['goods_id']))->find();
							if($goods_buy){
								$goods[$k]['num'] = $goods_buy['goods_num'];
							}else{
								$goods[$k]['num'] = 0;
							}
							$shuliang += $goods[$k]['num'];
						}
					}
					$goods_data[($key+1)] = $goods;
				}
			}
			self::output('shuliang',$shuliang);
			self::output('goods_data',$goods_data);
			self::output('order_id',$order['order_id']);
			self::output('sign',en_key($order['order_no'],KEY));
			self::display('fangxiao');
		}
	}
	
	//房间消费2
	public function fangxiao2(){
		$adv_id = 2;  //id是2
		$adv = M('adv',true)->find($adv_id);
		self::output('adv',$adv['images']);
		
		$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
		if ($order_id == 0){
			show_message('页面错误','html','-1');
		}
	//	$order_id = 1;  这个必须存在的哦
		if($order_id){
			$order = M('order')->where(array('order_id'=>$order_id))->find();
			$cat_list = M('category')->where(array('cat_pid'=>0))->limit(4)->select();
			self::output('cat_list',$cat_list);
			$goods_data = array();
			if(!empty($cat_list)){
				foreach($cat_list as $key => $val){
					$where = array(
						'goods_type'=> 2,
						'cat_id' 	=> $val['cat_id'],
						'is_show' 	=> 1,
						'is_del' => 0,
						'store_id' 	=> $order['store_id'],
					);
					$goods = M('goods')->where($where)->order('add_time desc')->select();
					if(!empty($goods)){
						foreach($goods as $k => $v){
							$goods[$k]['goods_img'] = get_img($v['goods_img'],'goods');
							$goods_buy = M('order_goods_buy')->where(array('order_id'=>$order_id,'is_buy'=>0,'goods_id' => $v['goods_id']))->find();
						//	if($goods_buy){
						//		$goods[$k]['num'] = $goods_buy['goods_num'];
						//	}else{
							$goods[$k]['num'] = 0;
						//	}
						}
					}
					$goods_data[($key+1)] = $goods;
				}
			}
			self::output('goods_data',$goods_data);
			self::output('order_id',$order['order_id']);
			self::output('sign',en_key($order['order_no'],KEY));
			self::display('fangxiao2');
		}
	}
	
	//个人房间消费3
	public function fangxiao3(){
		$adv_id = 2;  //id是2
		$adv = M('adv',true)->find($adv_id);
		self::output('adv',$adv['images']);
		$store_id = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;
		/*
		if($store_id == 5){  //绍兴的关闭
			show_message('此二维码已失效','html','-1');
		}
		*/
		if($store_id > 0){
			$this->get_wx_openid(); //获取用户信息
			$user = $this->user;
			$cat_list = M('category')->where(array('cat_pid'=>0))->limit(4)->select();
			$goods_data = array();
			if(!empty($cat_list)){
				foreach($cat_list as $key => $val){
					$where = array(
						'goods_type'=> 2,
						'cat_id' 	=> $val['cat_id'],
						'is_show' 	=> 1,
						'is_del' => 0,
						'store_id' 	=> $store_id,
					);
					$goods = M('goods')->where($where)->order('add_time desc')->select();
					if(!empty($goods)){
						foreach($goods as $k => $v){
							$goods[$k]['goods_img'] = get_img($v['goods_img'],'goods');
							$goods_buy = M('order_goods_buy')->where(array('order_id'=>$order_id,'is_buy'=>0,'goods_id' => $v['goods_id']))->find();
							$goods[$k]['num'] = 0;
						}
					}
					$goods_data[($key+1)] = $goods;
				}
			}
			self::output('goods_data',$goods_data);
			self::output('store_id',$store_id);
			self::output('user',$user);
			self::output('cat_list',$cat_list);
			self::display('fangxiao3');
		}
	}
	
	//用户点评查看全部评论
	public function userdian(){
		$store_id = $_GET['store_id'];
		$store = M('store')->where(array('store_id'=>$store_id))->find();
		if(!empty($store['store_label'])){
			$store['store_label'] = explode('|',$store['store_label']);
		}
		$user_evaluate = M('user_evaluate')
						->field('__AFFIX__user_evaluate.*,__AFFIX__user.nickname,__AFFIX__user.user_logo')
						->join('left __AFFIX__user','__AFFIX__user.user_id = __AFFIX__user_evaluate.user_id')
						->where(array('store_id' =>$store_id))
						->order('create_time desc')
						->select();
		$num = 0;
		foreach($user_evaluate as $key => $val){
			$num += $val['evaluation_num'];
		}
		$num = (int)((float)$num/count($user_evaluate) * 10);
		$num = (float)($num) / 10;
		$shaizhaopan = M('user_evaluate')
						->field('__AFFIX__user_evaluate.*,__AFFIX__user.nickname,__AFFIX__user.user_logo')
						->join('left __AFFIX__user','__AFFIX__user.user_id = __AFFIX__user_evaluate.user_id')
						->where(array('store_id' =>$store_id,'images'=> '!=""'))
						->order('create_time desc')
						->select();
						
		self::output('shaizhaopan',count($shaizhaopan));
		self::output('user_evaluate_list',$user_evaluate);
		self::output('shaizhaopan_list',$shaizhaopan);
		self::output('pinfen',$num);
		self::output('store',$store);
		self::output('dianpinshu',count($user_evaluate));
		self::display('userdian');
	}
	
	//订单待支付
	public function wait_pay(){
		$this->get_wx_openid();
		$user = $this->user;
		$user_id = $user['user_id'];
		
		$where = '(pay=0 and user_id='.$user_id.') or (pay = 1 and deposit_pay=0 and user_id='.$user_id.')';
		$daizhifu_order = M('order')
				->join('left __AFFIX__store','__AFFIX__store.store_id = __AFFIX__order.store_id')
				->where($where)
				->select();
		if(!empty($daizhifu_order)){
			foreach($daizhifu_order as $key => $val){
				$daizhifu_order[$key]['sign'] = en_key($val['order_no'],KEY);
				$daizhifu_order[$key]['store_logo'] = get_img($val['store_logo'],'store');
			}
		}
		self::output('daizhifu_order',$daizhifu_order);
		self::display('wait_pay');
	}
	
	//微信支付页面
	public function dingdanzhifu(){
		$order_id = intval($_GET['order_id']);
		if($order_id > 0){
			$order = M('order')
					->field('__AFFIX__store.store_name,__AFFIX__order.*')
					->join('left __AFFIX__store','__AFFIX__store.store_id = __AFFIX__order.store_id')
					->where(array('order_id'=>$order_id))
					->find();
			/*
			if($order['youhui_price'] > 0){
				$coupon = M('user_coupon')->where(array('coupon_id'=>$order['youhui_price']))->find();
				
			}
			*/
			//如果现金已支付，就支付押金即可
			if($order['pay'] == 1 && $order['deposit_pay'] == 1){
				header('Locdtion:index.php?act=user&op=person_info');
			}
			if($order['pay'] == 1 && $order['deposit_pay'] == 0){
				$order['over_price'] = $order['deposit'];
			}
			
			if(time() - $order['pay_update_time'] > 1800){  //大于半小时才更新out_trade_no
				$order['out_trade_no'] = date('YmdHis').rand(10000,99999).rand(10000,99999);
				M('order')->where(array('order_id' => $order_id))->update(array('out_trade_no' => $order['out_trade_no'],'pay_update_time'=>time()));
			}
			
			$order['sign'] = en_key($order['order_no'],KEY);
			self::output('order',$order);
		//	var_dump(BasePath.DS.'payment/wx_pay/example/jsapi.php');die;
			include_once BasePath.DS.'payment/wx_pay/example/order_zhifu.php';
		}
		self::display('dingdanzhifu');
	}
	
	//微信支付页面
	public function dingdanzhifu2(){
		
		$order_id = intval($_GET['order_id']);
		$order_id = 1;
		if($order_id > 0){
			$order = M('order')
					->field('__AFFIX__store.store_name,__AFFIX__order.*')
					->join('left __AFFIX__store','__AFFIX__store.store_id = __AFFIX__order.store_id')
					->where(array('order_id'=>$order_id))
					->find();
			
			$order['out_trade_no'] = date('YmdHis').rand(10000,99999).rand(10000,99999);
			M('order')->where(array('order_id' => $order_id))->update(array('out_trade_no' => $order['out_trade_no']));
			$order['over_price'] = 600;  //指定金额
			$order['sign'] = en_key($order['order_no'],KEY);
			self::output('order',$order);
			include_once BasePath.DS.'payment/wx_pay/example/order_zhifu2.php';
		}
		self::display('dingdanzhifu');
		
	}
	
	//订单明细页面
	public function consumption(){
		self::display('consumption');
	}
	
	//房间消费清单
	public function xiaofeiqingdan(){
		$order_id = intval($_GET['order_id']);
		if($order_id > 0){
			$order = M('order')->where(array('order_id' => $order_id))->find();
			$store = M('store')->where(array('store_id'=>$order['store_id']))->find();
			if($order['youhui_price'] > 0){
				$youhui = M('user_coupon')->where(array('coupon_id'=>$order['youhui_price']))->find();
				$order['youhui'] = $youhui['coupon_price'];
			}
			$room_but = M('order_goods_buy')
						->field('__AFFIX__goods.goods_name,__AFFIX__order_goods_buy.*')
						->join('left __AFFIX__goods','__AFFIX__goods.goods_id = __AFFIX__order_goods_buy.goods_id')
						->where(array('order_id' => $order_id , 'is_buy' => 0)) //没买的
						->select();
			$goods_price = 0;
			if(!empty($room_but)){
				foreach($room_but as $key => $val){
					$goods_price += $val['z_price'];
				}
			}
			$room_price = $order['price'] - $order['deposit'];
			self::output('order',$order);
			self::output('room_price',$room_price);
			self::output('store',$store);
			self::output('room_but',$room_but);
			self::output('goods_price',$goods_price);
			$top_price = $bottom_price = $goods_price + $room_price - $order['youhui'];
			self::output('top_price',$top_price);
			self::output('bottom_price',$bottom_price);
		}
		self::display('xiaofeiqingdan');
	}
	
	
	
	//订单房间消费清单
	public function xiaofeiqingdan2(){
		$order_id = intval($_GET['order_id']);
		if($order_id > 0){
			$order = M('order')->where(array('order_id' => $order_id))->find();
			$store = M('store')->where(array('store_id'=>$order['store_id']))->find();
			$order['youhui'] = 0;
			if($order['youhui_price'] > 0){
				$youhui = M('user_coupon')->where(array('coupon_id'=>$order['youhui_price']))->find();
				$order['youhui'] = $youhui['coupon_price'];
			}
			$room_but = M('order_goods_buy')
						->field('__AFFIX__goods.goods_name,__AFFIX__order_goods_buy.*')
						->join('left __AFFIX__goods','__AFFIX__goods.goods_id = __AFFIX__order_goods_buy.goods_id')
						->where(array('order_id' => $order_id,'is_buy' => 0))  //没买的
						->select();
			$goods_price = 0;
			if(!empty($room_but)){
				foreach($room_but as $key => $val){
					$goods_price += $val['z_price'];
				}
			}
			$room_price = $order['price'] - $order['deposit'];
			self::output('order',$order);
		//	self::output('room_price',$room_price);
			self::output('store',$store);
			self::output('room_but',$room_but);
			self::output('goods_price',$goods_price);
			$top_price = $bottom_price = $goods_price  - $order['youhui'];
			self::output('top_price',$top_price);
			self::output('bottom_price',$bottom_price);
			self::output('goods_price',$goods_price);
		}
		self::display('xiaofeiqingdan');
	}
	
	
	//房间消费清单  //已完成的
	public function xiaofeiqingdan3(){
		$order_id = intval($_GET['order_id']);
		if($order_id > 0){
			$order = M('order')->where(array('order_id' => $order_id))->find();
			$store = M('store')->where(array('store_id'=>$order['store_id']))->find();
			if($order['youhui_price'] > 0){
				$youhui = M('user_coupon')->where(array('coupon_id'=>$order['youhui_price']))->find();
				$order['youhui'] = $youhui['coupon_price'];
			}
			$room_but = M('order_goods_buy')
						->field('__AFFIX__goods.goods_name,__AFFIX__order_goods_buy.*')
						->join('left __AFFIX__goods','__AFFIX__goods.goods_id = __AFFIX__order_goods_buy.goods_id')
						->where(array('order_id' => $order_id , 'is_buy' => 1))
						->select();
			$goods_price = 0;
			if(!empty($room_but)){
				foreach($room_but as $key => $val){
					$goods_price += $val['z_price'];
				}
			}
			$room_price = $order['price'] - $order['deposit'];
			self::output('order',$order);
			self::output('room_price',$room_price);
			self::output('store',$store);
			self::output('room_but',$room_but);
			self::output('goods_price',$goods_price);
			$top_price = $bottom_price = $goods_price + $room_price - $order['youhui'];
			self::output('top_price',$top_price);
			self::output('bottom_price',$bottom_price);
		}
		self::display('xiaofeiqingdan');
	}
	
	//订单完成页面
	public function order_over(){
		$order_id = $_GET['order_id'];
		if($order_id){
			$order = M('order')->where(array('order_id' => $order_id))->find();
			self::output('order',$order);
		}
		self::display('order_over');
	}
	
	//订单完成页面
	public function order_over2(){
		
		self::display('order_over');
	}
	
	//再次预定页面
	public function dingdanxiangqing_1(){
		$order_id = $_GET['order_id'];
		$order = M('order')
				->where(array('order_id' => $order_id))
				->find();
		$store = M('store')->where(array('store_id' => $order['store_id']))->find();
		$store['store_logo'] = get_img($store['store_logo'],'store');
		$order['sign'] = en_key($order['order_no'],KEY);
		self::output('order',$order);
		self::output('store',$store);
		self::display('dingdanxiangqing_1');
	}
	
	//再次预定页面
	public function dingdanxiangqing_2(){
		$order_id = $_GET['order_id'];
		$order = M('order')
				->where(array('order_id' => $order_id))
				->find();
		$store = M('store')->where(array('store_id' => $order['store_id']))->find();
		$store['store_logo'] = get_img($store['store_logo'],'store');
		$order['sign'] = en_key($order['order_no'],KEY);
		self::output('order',$order);
		self::output('store',$store);
		self::display('dingdanxiangqing_2');
	}
	
	//再次预定页面
	public function dingdanxiangqing_3(){
		$order_id = $_GET['order_id'];
		$order = M('order')
				->where(array('order_id' => $order_id))
				->find();
		$store = M('store')->where(array('store_id' => $order['store_id']))->find();
		$store['store_logo'] = get_img($store['store_logo'],'store');
		$order['sign'] = en_key($order['order_no'],KEY);
		self::output('order',$order);
		self::output('store',$store);
		self::display('dingdanxiangqing_3');
	}
}
?>