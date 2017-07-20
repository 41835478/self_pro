<?php
if(!defined('PROJECT_NAME')) die('project empty');
class paymentControl extends baseControl{
	
	//微信支付页面
	public function fangjianxiaofeizhifu(){
		$order_id = intval($_GET['order_id']);
		$out_trade_no = $_GET['out_trade_no'];
		if($order_id > 0){
			$order = M('order')
					->field('__AFFIX__store.store_name,__AFFIX__order.*')
					->join('left __AFFIX__store','__AFFIX__store.store_id = __AFFIX__order.store_id')
					->where(array('order_id'=>$order_id))
					->find();
			$order['sign'] = en_key($order['order_no'],KEY);
			$order_goods_buy = M('order_goods_buy')->where(array('order_id' => $order_id , 'is_buy' => 0 ,'out_trade_no' => $out_trade_no))->select();
			$over_price = 0;$goods = array();
			if(!empty($order_goods_buy)){
				foreach($order_goods_buy as $key => $val){
					$over_price += $val['z_price'];
					$goods[] = $val['buy_id'];
				}
			}
			$order['out_trade_no'] = $out_trade_no;
			$order['str'] = implode(',',$goods);
			self::output('order_goods_buy',$order_goods_buy);
			$order['over_price'] = $over_price;
			self::output('order',$order);
			self::output('out_trade_no',$out_trade_no);
			include_once BasePath.DS.'payment/wx_pay/example/fangjianxiaofei_zhifu.php';
		}
		self::display('dingdanzhifu2');
	}
	
	//个人微信支付页面
	public function fangjianxiaofeizhifu2(){
	//	$order_id = intval($_GET['order_id']);
		$out_trade_no = $_GET['out_trade_no'];
		if(!empty($out_trade_no)){
			$order_goods_buy = M('order_goods_buy')->where(array('order_id' => 0, 'is_buy' => 0 ,'out_trade_no' => $out_trade_no))->select();
			$over_price = 0;$goods = array();
			if(!empty($order_goods_buy)){
				foreach($order_goods_buy as $key => $val){
					$over_price += $val['z_price'];
					$goods[] = $val['buy_id'];
				}
			}
			$order['out_trade_no'] = $out_trade_no;
			$order['order_no'] = $out_trade_no;
			$order['str'] = implode(',',$goods);
			self::output('order_goods_buy',$order_goods_buy);
			$order['over_price'] = $over_price;
			self::output('order',$order);
			self::output('out_trade_no',$out_trade_no);
			include_once BasePath.DS.'payment/wx_pay/example/gerengoumai_zhifu.php';
		}
		self::display('dingdanzhifu3');
	}
	
	//个人支付页面,支付宝
	public function ali_gerengoumai(){
		$this->is_wxopen();
		$out_trade_no = $_GET['out_trade_no'];
		if(!empty($out_trade_no)){
			$order_goods_buy = M('order_goods_buy')->where(array('order_id' => 0, 'is_buy' => 0 ,'out_trade_no' => $out_trade_no))->select();
			$over_price = 0;$goods = array();
			if(!empty($order_goods_buy)){
				foreach($order_goods_buy as $key => $val){
					$over_price += $val['z_price'];
					$goods[] = $val['buy_id'];
				}
			}
			$order['subject'] 	= '黑眼圈潮趴馆';
		//	$order['out_trade_no'] = $out_trade_no;
			$order['body'] 		= $order['out_trade_no'];
			$order['order_no'] = $out_trade_no;
			self::output('order_goods_buy',$order_goods_buy);
			$order['over_price'] = $over_price;
		//	self::output('order',$order);
		//	self::output('out_trade_no',$out_trade_no);
			$order['return_url']= 'http://'.$_SERVER['SERVER_NAME'].'/api/payment/alipay/order_geren_return_url.php';
			$order['notify_url']= 'http://'.$_SERVER['SERVER_NAME'].'/api/payment/alipay/order_geren_notify_url.php';
			include_once BasePath.DS.'payment/alipay/wappay/pay.php';
		}
	}
	public function order_bujia(){
		$b_id = $_GET['b_id'];
		$order_bujia = M('order_bujia')->where(array('b_id' => $b_id))->find();
		self::output('order_bujia',$order_bujia);
		if(!empty($order_bujia)){
			$order = M('order')->where(array('order_id' => $order_bujia['order_id']))->find();
			if(time() - $order_bujia['pay_update_time'] > 1800){
				$out_trade_no = date('YmdHis').rand(10000,99999).rand(10000,99999);
				$order_bujia['out_trade_no'] = $out_trade_no;
				$res = M('order_bujia')->where(array('b_id' => $b_id))->update(array('out_trade_no' => $out_trade_no,'pay_update_time' => time()));
			}
			
			$order['out_trade_no'] = $order_bujia['out_trade_no'];
			$order['order_no'] = $out_trade_no;
			self::output('order_goods_buy',$order_goods_buy);
			$order['over_price'] = $order_bujia['b_price'] ;
			$order['callback_url'] = 'http://'.$_SERVER['SERVER_NAME'].'/api/payment/wx_payment/order_bujia.php';
			
			self::output('order',$order);
			self::output('out_trade_no',$out_trade_no);
			include_once BasePath.DS.'payment/wx_pay/example/self_zhifu.php';
		}
		self::display('dingdanzhifu4');
	}
	
	//支付宝支付
	public function order_alipay(){
	//	var_dump($_SERVER['HTTP_USER_AGENT']);die;
		$this->is_wxopen();	//微信手机打开
		$order_id = $_GET['order_id'];
	//	$order_id = 1;
		$order = M('order')->where(array('order_id' => $order_id))->find();
	//	$order['pay'] == 0;
		if(!empty($order) && $order['pay'] == 0){
			$order['subject'] 	= '黑眼圈潮趴馆';
			$order['over_price'] = $order['over_price'];
			$order['body'] 		= $order['order_id'];
			$order['return_url']= 'http://'.$_SERVER['SERVER_NAME'].'/api/payment/alipay/order_alipay_return_url.php';
			$order['notify_url']= 'http://'.$_SERVER['SERVER_NAME'].'/api/payment/alipay/order_alipay_notify_url.php';
			include_once BasePath.DS.'payment/alipay/wappay/pay.php';
		}else{
			show_message('订单错误','html','?act=index&op=index');
		}
	}
	
	//房间消费支付，支付宝支付
	public function ali_room_pay(){
		$this->is_wxopen();
		$order_id = intval($_GET['order_id']);
		$out_trade_no = $_GET['out_trade_no'];
		if($order_id > 0){
			$order = M('order')
					->field('__AFFIX__store.store_name,__AFFIX__order.*')
					->join('left __AFFIX__store','__AFFIX__store.store_id = __AFFIX__order.store_id')
					->where(array('order_id'=>$order_id))
					->find();
			$order_goods_buy = M('order_goods_buy')->where(array('order_id' => $order_id , 'is_buy' => 0 ,'out_trade_no' => $out_trade_no))->select();
			$over_price = 0;$goods = array();
			if(!empty($order_goods_buy)){
				foreach($order_goods_buy as $key => $val){
					$over_price += $val['z_price'];
					$goods[] = $val['buy_id'];
				}
			}
			$order['out_trade_no'] = $out_trade_no;
			$order['body'] = $out_trade_no;
			self::output('order_goods_buy',$order_goods_buy);
			$order['over_price'] = $over_price;
			self::output('order',$order);
			self::output('out_trade_no',$out_trade_no);
			
			$order['subject'] 	= '黑眼圈潮趴馆';
			$order['return_url']= 'http://'.$_SERVER['SERVER_NAME'].'/api/payment/alipay/order_room_return_url.php';
			$order['notify_url']= 'http://'.$_SERVER['SERVER_NAME'].'/api/payment/alipay/order_room_notify_url.php';
			
			include_once BasePath.DS.'payment/alipay/wappay/pay.php';
		}
	}
	
	//支付宝订单补价   ?act=payment&op=ali_order_bujia&b_id=<?php echo 
	public function ali_order_bujia(){
		$this->is_wxopen();
		$b_id = $_GET['b_id'];
		$order_bujia = M('order_bujia')->where(array('b_id' => $b_id))->find();
		if(!empty($order_bujia)){
			$order = M('order')->where(array('order_id' => $order_bujia['order_id']))->find();
			if(time() - $order_bujia['pay_update_time'] > 1800){
				$out_trade_no = date('YmdHis').rand(10000,99999).rand(10000,99999);
				$order_bujia['out_trade_no'] = $out_trade_no;
				$res = M('order_bujia')->where(array('b_id' => $b_id))->update(array('out_trade_no' => $out_trade_no,'pay_update_time' => time()));
			}
			
		//	$order['out_trade_no'] = $order_bujia['out_trade_no'];
			$order['subject'] 	= '黑眼圈潮趴馆';
			$order['order_no'] = $out_trade_no;
			self::output('order_goods_buy',$order_goods_buy);
			$order['over_price'] = $order_bujia['b_price'] ;
			$order['body'] 		= $b_id;
			$order['return_url']= 'http://'.$_SERVER['SERVER_NAME'].'/api/payment/alipay/order_bujia_return_url.php';
			$order['notify_url']= 'http://'.$_SERVER['SERVER_NAME'].'/api/payment/alipay/order_bujia_notify_url.php';
			
			self::output('order',$order);
			self::output('out_trade_no',$out_trade_no);
			include_once BasePath.DS.'payment/alipay/wappay/pay.php';
		}
		self::display('dingdanzhifu4');
	}
	
	//是否是微信打开
	private function is_wxopen(){
		$is_wx = preg_match('/MicroMessenger/',$_SERVER['HTTP_USER_AGENT']);
		if($is_wx){
			self::display('weixintishi');
			die;
		}
	}
}
?>