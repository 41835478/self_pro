<?php
define('PROJECT_NAME','LK');
include 'init.php'; //初始化  //旁边的初始化

class run{
	/**
	 * 内部服务器错误（数据库错误、PHP处理异常等所有异常情况）
	 * 
	 */
	const ERROR_500 = '500';
	/**
	 * 参数不正确
	 *
	 */
	const ERROR_404 = '404';
	/**
	 * 正确返回
	 *
	 */
	const SUCC	= '200';
	/**
	 * 默认页码
	 *
	 */
	const  PAGE_NUM = 1;
	/**
	 * 默认页码
	 *
	 */
	const PAGE_SIZE = 10;
	private $_get = array();
	public function __construct(){
		header('Content-type: application/json;charset=utf-8');
		$this->_validate();
		$this->index();
	}
	
	private function _validate(){
		if($_POST){
			foreach($_POST as $key => $val){
				$this->_get[$key] = $val;
			}
		}
		if($_GET){
			foreach($_GET as $key => $val){
				$this->_get[$key] = $val;
			}
		}
		if (empty($this->_get)){
			exit($this->callback('',self::ERROR_404,'缺少参数'));
		}
	}

	private function index(){
		$func = '_'.$this->_get['commend'];
		if (method_exists($this,$func)){
			$this->$func();
		}else{
			exit($this->callback('',self::ERROR_404,'接口不存在'));	
		}
	}
	private function _abc(){
		show_message('中国');
	}
	private function callback($data,$code=200,$msg=''){
		if (strtoupper(CHARSET) == 'GBK'){
			$data = charset($data,'GBK','UTF-8');
		}
		if (isset($_GET['debug']) && $_GET['debug'] == '1'){
			print_R(array('code'=>$code,'msg'=>$msg,'data'=>$data));
			exit();
		}else{
			return json_encode(array('code'=>$code,'msg'=>$msg,'data'=>$data));
		}
	}
	
	//订单测试支付
	private function _wx_payment2(){
		$data = $this->_is_wx_pay();
		if($data){
			file_put_contents('a.log' , date('Y-m-d H:i:s').'['.json_encode($data)."] \n" , FILE_APPEND);
		}
	}
	
	//是否支付成功
	private function _is_wx_pay(){
		$input = file_get_contents('php://input');
		if (!empty($input) && empty($_GET['out_trade_no'])) {
			$obj = simplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
			file_put_contents('text.log',date('Y-m-d|H:i:s').'--'.json_encode($obj)."\n" , FILE_APPEND );
		//	$obj = '{"appid":"wxd9798daf783a0deb","attach":"\u7ecd\u5174\u4e00\u5e97\uff08\u8d8a\u90fd\u540d\u5e9c\u5e97\uff09","bank_type":"COMM_DEBIT","cash_fee":"100000","fee_type":"CNY","is_subscribe":"Y","mch_id":"1455407902","nonce_str":"n1tgn24tqs7alv3zdaeo7tv5tilhb05a","openid":"oweZM09eUzaTe3ir6m16YzLpk8Pc","out_trade_no":"201706041401221604197082","result_code":"SUCCESS","return_code":"SUCCESS","sign":"0BE88A5D5CD67F64A2B3599FFD8196DD","time_end":"20170604140148","total_fee":"100000","trade_type":"JSAPI","transaction_id":"4009962001201706044234184232"}';
		//	$obj = json_decode($obj);
			$data = json_decode(json_encode($obj), true);
			//根据$data处理自己所要的逻辑
			$buff = '';
			if(!empty($data)){
				foreach($data as $key => $val){
					if($key != 'sign' && $val != "" && !is_array($val)){
						$buff .= $key . "=" . $val . "&";
					}
				}
				$buff = trim($buff, "&");
				include BasePath.DS.'payment/wx_pay/lib/WxPay.Config.php';
				$buff .= "&key=".WxPayConfig::KEY;
				$buff = md5($buff);
				//签名步骤四：所有字符转为大写
				$result = strtoupper($buff);
				if($result == $data['sign']){
			//		echo 222;
					//发送给微信说明收到了
					$xml = '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
					echo $xml;
					return $data;
				}
			}
		}
		return false;
	}
	//订单支付
	private function _wx_payment(){
		$data = $this->_is_wx_pay();
		if($data){ //支付成功
			$out_trade_no = $data['out_trade_no'];
			if(empty($out_trade_no)){
				die;
			}
			
			$order = M('order')->where(array('out_trade_no'=>$out_trade_no))->find();
			if($order['pay'] == 1){  //已支付
				echo '已支付';
				die;
			}
			$order_data = array(
				'pay'		=> 1,	   //已支付
				'pay_type' 	=> 'wx',   //支付类型
				'pay_time' 	=> time(),
				'transaction_id' => $data['transaction_id'],
				'other' 		=> json_encode($data),
				'deposit_pay' 	=> 1,
			);
			if(!empty($order['st_cart'])){
				$is_coupon2 = M('user_coupon2')->where(array('c_code' => $order['st_cart'],'is_del' => 0,'is_use' => 0))->find();
				if(!empty($is_coupon2)){
					$user_coupon_update = array(
						'is_use' => 1,
						'update_time' => time(),
						'order_id' => $order['order_id'],
						'user_id' => $order['user_id'],
					);
					M('user_coupon2')->where(array('c_code' => $order['st_cart']))->update($user_coupon_update);
				}
			}
			M('order')->where(array('order_no' => $order['order_no']))->update($order_data);
			$order_room_buy = array(
				'user_id' 	=> $order['user_id'],
				'is_buy' 	=>1,
			);
			M('order_room_buy')->where(array('order_id'=>$order['order_id']))->update($order_room_buy);
			$order_goods_buy = array(
				'user_id' 	=> $order['user_id'],
				'is_buy' 	=>1,
				'pay_type' 	=>'wx',
				'pay_type2' =>'1',
			);
			$order_room = array(
				'order_id' 		=> $order['order_id'],
				'p_amount' 		=> $order['over_price'],
				'create_time' 	=> time(),
			);
			$is_order_room = M('order_room')->where(array('order_id' => $order['order_id']))->find();
			if(empty($is_order_room)){
				M('order_room')->add($order_room);
			}
			M('order_goods_buy')->where(array('order_id'=>$order['order_id']))->update($order_goods_buy);
			if(intval($order['youhui_price']) > 0){
				M('user_coupon')->where(array('coupon_id'=>$order['youhui_price']))->update(array('is_use'=>1));
			}
			
			$_POST['sign'] = en_key($order['order_no'],KEY);
			$_POST['order_id'] = $order['order_id'];
			
			$this->_send_message();
			$this->_send_voice_message();
		}
	}
	
	//发送消息
	private function _send_message(){
		$sign = $_POST['sign'];
		$order_id = $_POST['order_id'];
		$zhanyang_phone = '18304626584';
		$fanchaochen_phone = '15078971515';
		if($order_id > 0){
			$order = M('order')->where(array('order_id'=>$order_id))->find();
			$order_no = de_key($sign,KEY);
			if($order_no == $order['order_no']){
				//dd123 发送语音
				$chang = '白场';
				if($order['changci'] == 2){
					$chang = '夜场';
				}
				include_once BasePath.DS.'plugins/ronglian/SendTemplateSMS.php';
				$str1 = $order['safe_name'];
				$str2 = date('Y年m月d日 H时',$order['start_time']).$chang;
				$yonghu_phone = trim($order['mobile']);
				$res = sendTemplateSMS($yonghu_phone,array($str1,$str2),172857);
				$week = date('w',$order['start_time']);
				if($week == 0){
					$week = 7;
				}
				$guanjia = M('guanjia_work')->where(array('store_id'=> $order['store_id']))->find();
				if(!empty($guanjia)){
					$guanjia_id = $guanjia['week'.$week];
					$gg = M('guanjia')->where(array('guanjia_id'=>$guanjia_id))->find();
					$str1 = $gg['guanjia_name'];
					$str2 = $order['safe_name'];
					$str3 = date('Y年m月d日 H时',$order['start_time']).$chang;
					$str4 = $order['order_no'];
					$str5 = $order['mobile'];
					$guanjia_phone = trim($gg['guanjia_phone']);
					sendTemplateSMS($guanjia_phone,array($str1,$str2,$str3,$str4,$str5),172858);
					sendTemplateSMS($zhanyang_phone,array($str1,$str2,$str3,$str4,$str5),172858);
					sendTemplateSMS($fanchaochen_phone,array($str1,$str2,$str3,$str4,$str5),172858);
				}
			}
		}
	}
	
	private function _send_voice_message(){
		$zhanyang_phone = '18304626584';
		$fanchaochen_phone = '15078971515';
		$sign = $_POST['sign'];
		$order_id = $_POST['order_id'];
		if($order_id > 0){
			$order = M('order')->where(array('order_id'=>$order_id))->find();
			$order_no = de_key($sign,KEY);
			if($order_no == $order['order_no']){
				$week = date('w',$order['start_time']);
				if($week == 0){
					$week = 7;
				}
				$guanjia = M('guanjia_work')->where(array('store_id'=> $order['store_id']))->find();
				if(!empty($guanjia)){
					$guanjia_id = $guanjia['week'.$week];
					$gg = M('guanjia')->where(array('guanjia_id'=>$guanjia_id))->find();
					include_once BasePath.DS.'plugins/voice_code/VoiceVerify.php';
					$guanjia_phone = trim($gg['guanjia_phone']);
					voiceVerify('11111111',"3",$guanjia_phone);
					voiceVerify('11111111',"3",$zhanyang_phone);
					voiceVerify('11111111',"3",$fanchaochen_phone);
				}
			}
		}
	}
	private function _send_voice_v1_message($store_id){
		$week = date('w',time());
			if($week == 0){
				$week = 7;
			}
			$guanjia = M('guanjia_work')->where(array('store_id'=> $store_id))->find();
			if(!empty($guanjia)){
				$guanjia_id = $guanjia['week'.$week];
				$gg = M('guanjia')->where(array('guanjia_id'=>$guanjia_id))->find();
				include_once BasePath.DS.'plugins/voice_code/VoiceVerify.php';
				$guanjia_phone = trim($gg['guanjia_phone']);
				voiceVerify('11111111',"3",$guanjia_phone);
			}
	}
	//wx_room_goods_payment
	private function _wx_room_goods_payment(){
		$data = $this->_is_wx_pay();
		if($data){ //支付成功
			$out_trade_no = $data['out_trade_no'];
			$order_no = $data['attach'];  //附加信息订单号
			if(empty($order_no)){
				die;
			}
			$order = M('order')->where(array('order_no'=>$order_no))->find();
			//给管家发送语音消息
			$_POST['sign'] = en_key($order['order_no'],KEY);
			$_POST['order_id'] = $order['order_id'];
			$this->_send_voice_message();
			
			$goods_buy = M('order_goods_buy')->where(array('out_trade_no'=>$out_trade_no,'order_id'=>$order['order_id'],'is_buy'=>0))->select();
			$xianshangciaofei  = 0 ;
			foreach($goods_buy as $key => $val){
				$xianshangciaofei += $val['z_price'];
			}
			$order_goods_buy = array(
				'user_id' 	=> $order['user_id'],
				'is_buy' 	=>1,
				'pay_type' 	=>'wx',
				'pay_type2' =>'2',
			);
			$order_room = M('order_room')->where(array('order_id'=>$order['order_id']))->find();
			$order_room = array(
				'xs_amount' 	=> $xianshangciaofei + $order_room['xs_amount'],
			);
			M('order_room')->where(array('order_id'=>$order['order_id']))->update($order_room);
			M('order_goods_buy')->where(array('out_trade_no'=>$out_trade_no))->update($order_goods_buy);
		}
	}
	
	//个人消费
	private function _wx_people_goods_payment(){
		$data = $this->_is_wx_pay();
		if($data){ //支付成功
			$out_trade_no = $data['out_trade_no'];
			
			$order_goods_buy = M('order_goods_buy')->where(array('out_trade_no'=>$out_trade_no))->find();
			
			if(!empty($order_goods_buy)){
				foreach($order_goods_buy as $key => $val){
					$goods = M('goods')->where(array('goods_id'=>$val['goods_id']))->find();
					$goods_update['floor_quantity'] = $goods['floor_quantity'] - $val['goods_num'];
					$goods_update['goods_num'] = $goods['goods_num'] - $val['goods_num'];
					M('goods')->where(array('goods_id'=>$val['goods_id']))->update($goods_update);
				}
			}
			
			$order_goods_buy = array(
				'is_buy' 	=>1,
				'pay_type' 	=>'wx',
				'pay_type2' =>'2',
			);
			M('order_goods_buy')->where(array('out_trade_no'=>$out_trade_no))->update($order_goods_buy);
			
			//给管家发送语音消息
			$this->_send_voice_v1_message($order_goods_buy['store_id']);
		}
	}
	//订单补价
	private function _wx_order_bujia(){
		$data = $this->_is_wx_pay();
		if($data){ //支付成功
	//	file_put_contents('b.log','1');
			$out_trade_no = $data['out_trade_no'];
			$bujia_data = array(
				'pay_time' => time(),
				'pay' => 1,
				'pay_type' => 'wx',
				'other' => json_encode($data),
			);
			M('order_bujia')->where(array('out_trade_no' => $out_trade_no))->update($bujia_data);
		}
	}
	//----
	//支付宝订单通知
	private function _order_alipay_notify_url(){
		$order_zhifu = false;
		I(); //过滤
		include_once BasePath.'/payment/alipay/notify_url.php';
		if($order_zhifu){  //支付成功
			$data = $_POST;
			$order_id = $_POST['body'];  //这个是订单id号
			$order = M('order')->where(array('order_id'=>$order_id))->find();
			if($order['pay'] == 1){
				die;
			}
			$order_no = $order['order_no'];
			$_POST['sign'] = en_key($order['order_no'],KEY);
			$_POST['order_id'] = $order['order_id'];
			
			if(!empty($order['st_cart'])){
				$is_coupon2 = M('user_coupon2')->where(array('c_code' => $order['st_cart'],'is_del' => 0,'is_use' => 0))->find();
				if(!empty($is_coupon2)){
					$user_coupon_update = array(
						'is_use' => 1,
						'update_time' => time(),
						'order_id' => $order['order_id'],
						'user_id' => $order['user_id'],
					);
					M('user_coupon2')->where(array('c_code' => $order['st_cart']))->update($user_coupon_update);
				}
			}
			
			$this->_send_message();
			$this->_send_voice_message();
			
			$order_data = array(
				'pay'		=> 1,	   //已支付
				'pay_type' 	=> 'ali',   //支付类型
				'pay_time' 	=> time(),
				'transaction_id' => $data['trade_no'],
				'out_trade_no'  => $data['out_trade_no'],
				'other' 		=> json_encode($_POST),
				'deposit_pay' 	=> 1,
			);
			M('order')->where(array('order_no'=>$order_no))->update($order_data);
			$order_room_buy = array(
				'user_id' 	=> $order['user_id'],
				'is_buy' 	=>1,
			);
			M('order_room_buy')->where(array('order_id'=>$order['order_id']))->update($order_room_buy);
			$order_goods_buy = array(
				'user_id' 	=> $order['user_id'],
				'is_buy' 	=>1,
				'pay_type' 	=>'ali',
				'pay_type2' =>'1',
			);
			$order_room = array(
				'order_id' 		=> $order['order_id'],
				'p_amount' 		=> $order['over_price'],
				'create_time' 	=> time(),
			);
			$is_order_room = M('order_room')->where(array('order_id' => $order['order_id']))->find();
			if(empty($is_order_room)){
				M('order_room')->add($order_room);
			}
			M('order_goods_buy')->where(array('order_id'=>$order['order_id']))->update($order_goods_buy);
			if(intval($order['youhui_price']) > 0){
				M('user_coupon')->where(array('coupon_id'=>$order['youhui_price']))->update(array('is_use'=>1));
			}
		}
	}
	
	//支付宝订单跳转
	private function _order_alipay_return_url(){
		$order_zhifu = false;
		I(); //过滤
		unset($_GET['commend']);  //要把这些去掉。。
		unset($_GET['act']);
		unset($_GET['op']);
		include_once BasePath.'/payment/alipay/return_url.php';
		if($order_zhifu){
			$order_id = $_GET['body'];
			$order = M('order')->where(array('order_id' => $order_id))->find();
			header('Location:'.URL.'?act=order&op=order_over&order_id='.$order['order_id']);
		}
	}
	
	//支付宝订单补价
	private function _order_bujia_notify_url(){
		$order_zhifu = false;
		I(); //过滤
		include_once BasePath.'/payment/alipay/notify_url.php';
		if($order_zhifu){  //支付成功
			$data = $_POST;
			$b_id = $data['body'];
			$bu = M('order_bujia')->where(array('b_id' => $b_id))->find();
			if(!empty($bu) && $bu['pay'] == 1){
				die;
			}
			$bujia_data = array(
				'pay_time' => time(),
				'pay' => 1,
				'pay_type' => 'ali',
				'other' => json_encode($data),
			);
			M('order_bujia')->where(array('b_id' => $b_id))->update($bujia_data);
		}
	}
	
	//支付宝订单跳转
	private function _order_bujia_return_url(){
		$order_zhifu = false;
		I(); //过滤
		unset($_GET['commend']);  //要把这些去掉。。
		unset($_GET['act']);
		unset($_GET['op']);
		include_once BasePath.'/payment/alipay/return_url.php';
		if($order_zhifu){
			$b_id = $_GET['body'];
			$bujia = M('order_bujia')->where(array('b_id' => $b_id))->find();
			$order_id = $bujia['order_id'];
			$order = M('order')->where(array('order_id' => $order_id))->find();
			header('Location:'.URL.'?act=order&op=order_over&order_id='.$order['order_id']);
		}
	}
	
	//房间消费，支付宝支付
	private function _order_room_notify_url(){
		$order_zhifu = false;
		I(); //过滤
		include_once BasePath.'/payment/alipay/notify_url.php';
		if($order_zhifu){  //支付成功
			$data = $_POST;
			$out_trade_no = $data['body'];
			$room_goods_buy = M('order_goods_buy')->where(array('out_trade_no'=>$out_trade_no))->find();
			if($room_goods_buy['is_buy'] == 1){  //已支付的，就结束
				die;
			}
			$order = M('order')->where(array('order_id'=>$room_goods_buy['order_id']))->find();
			//给管家发送语音消息
			$_POST['sign'] = en_key($order['order_no'],KEY);
			$_POST['order_id'] = $order['order_id'];
			
			$this->_send_voice_message();
			
			$goods_buy = M('order_goods_buy')->where(array('out_trade_no'=>$out_trade_no,'order_id'=>$order['order_id'],'is_buy'=>0))->select();
			$xianshangciaofei  = 0 ;
			foreach($goods_buy as $key => $val){
				$xianshangciaofei += $val['z_price'];
			}
			$order_goods_buy = array(
				'user_id' 	=> $order['user_id'],
				'is_buy' 	=>1,
				'pay_type' 	=>'ali',
				'pay_type2' =>'2',
			);
			$order_room = M('order_room')->where(array('order_id'=>$order['order_id']))->find();
			$order_room = array(
				'xs_amount' 	=> $xianshangciaofei + $order_room['xs_amount'],
			);
			M('order_room')->where(array('order_id'=>$order['order_id']))->update($order_room);
			M('order_goods_buy')->where(array('out_trade_no'=>$out_trade_no))->update($order_goods_buy);
		}
	}
	
	//个人消费支付，支付宝
	private function _order_geren_notify_url(){
		$order_zhifu = false;
		I(); //过滤
		include_once BasePath.'/payment/alipay/notify_url.php';
		if($order_zhifu){  //支付成功
			$data = $_POST;
			$out_trade_no = $data['body'];
			
			$order_goods_buy = M('order_goods_buy')->where(array('out_trade_no'=>$out_trade_no))->find();
			if($order_goods_buy['is_buy'] == 1){  //防止重复提交
				die;
			}
			
			
			if(!empty($order_goods_buy)){
				foreach($order_goods_buy as $key => $val){
					$goods = M('goods')->where(array('goods_id'=>$val['goods_id']))->find();
					$goods_update['floor_quantity'] = $goods['floor_quantity'] - $val['goods_num'];
					$goods_update['goods_num'] = $goods['goods_num'] - $val['goods_num'];
					M('goods')->where(array('goods_id'=>$val['goods_id']))->update($goods_update);
				}
			}
			
			$order_goods_buy = array(
				'is_buy' 	=>1,
				'pay_type' 	=>'ali',
				'pay_type2' =>'2',
			);
			M('order_goods_buy')->where(array('out_trade_no'=>$out_trade_no))->update($order_goods_buy);
			
			//给管家发送语音消息
			$this->_send_voice_v1_message($order_goods_buy['store_id']);
		}
	}
	
	private function _order_geren_return_url(){
		$order_zhifu = false;
		I(); //过滤
		unset($_GET['commend']);  //要把这些去掉。。
		unset($_GET['act']);
		unset($_GET['op']);
		include_once BasePath.'/payment/alipay/return_url.php';
		if($order_zhifu){
			header('Location:'.URL.'?act=index&op=index');
		}
	}
	
	//支付宝订单跳转
	private function _order_room_return_url(){
		$order_zhifu = false;
		I(); //过滤
		unset($_GET['commend']);  //要把这些去掉。。
		unset($_GET['act']);
		unset($_GET['op']);
		include_once BasePath.'/payment/alipay/return_url.php';
		if($order_zhifu){
			$b_id = $_GET['body'];
			$bujia = M('order_bujia')->where(array('b_id' => $b_id))->find();
			$order = M('order')->where(array('order_id' => $order_id))->find();
			header('Location:'.URL.'?act=order&op=order_over&order_id='.$order['order_id']);
		}
	}
	/*
	private function _test(){
		echo 'success';
	}
	*/
}
new run();

?>