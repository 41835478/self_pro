
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
	
	/*
	*	广告
	*	type 	是广告类型
	*/
	private function _adv_list(){
		$adv_id = isset($_POST['adv_id']) ? intval($_POST['adv_id']) : intval($_GET['adv_id']);
		$adv = M('adv')->where(array('adv_id'=>$adv_id))->find();
		
		if(!empty($adv)){
			if($adv['type'] == 'take_turns'){
				if(!empty($adv['images'])){
					$adv['images'] = explode(',',$adv['images']);
					foreach($adv['images'] as $key => $val){
						$adv['images'][$key] = DS.'uploads/adv/'.substr($val,0,8).DS.$val;
					}
				}
				if(!empty($adv['urls'])){
					$adv['urls'] = explode(',',$adv['urls']);
				}
				$adv['date_time'] 		= date('Y-m-d H:i:s',$adv['date_time']);
				$adv['is_L_AND_R'] 		= $adv['is_L_AND_R'] == 1 ? true : false;
				$adv['is_show_bottom'] 	= $adv['is_show_bottom'] == 1 ? true : false;
				$adv['is_show_num'] 	= $adv['is_show_num'] == 1 ? true : false;
				echo json_encode($adv);die;
			}
		}
		
		$adv_list = array(
			'type' 	=> 'take_turns',   			//广告类型，轮播图
			'title'	=> '轮播图',
			'width' => '330',
			'height' => '220',
			'adv_desc'	=> '简介',
			'date_time' => date('Y-m-d H:i:s',time()),
			'is_L_AND_R' => true,
			'is_show_bottom' => true,
			'is_show_bottom_move' => 'center',  //left,center,right  左中右
			'adv_mode' => 'left',  //移动方式
			'is_show_num' => true,
			'images' => array(
				'http://www.project.com/1.jpg',
				'http://www.project.com/2.jpg',
				'http://www.project.com/3.jpg',
				'http://www.project.com/4.jpg',
			),
			'urls' => array(
				'http://www.1.com',
				'http://www.2.com',
				'http://www.3.com',
				'http://www.4.com',
			),
			
		);
		if($adv_id == 2){
			$adv_list['width'] = 400;
			$adv_list['height'] = 300;
			$adv_list['adv_mode'] = 'right';
		}
		if($adv_id == 3){
		//	$adv_list['is_show_num'] = false;
			$adv_list['images'][] = 'http://www.project.com/4.jpg';
			$adv_list['urls'][] = 'http://www.4.com';
			$adv_list['is_L_AND_R'] = false;
		}
		if($adv_id == 4){
		//	$adv_list['is_L_AND_R'] = false;
		}
		
		echo json_encode($adv_list);
		
	}
	
	//生成验证码
	private function _captcha(){
		$captcha = new captcha();  //实例化一个对象
		$type = $_GET['type'];
		$captcha->doimg();
		if(!empty($type)){
			switch($type){
				case 'register':   //注册
					$_SESSION['register_captcha'] = $captcha->getCode();
				break;
				
				default:
				break;
			}
		}
	}
	
	//验证码判断
	private function is_captcha($type = '',$code = ''){
		if(!empty($type)){
			switch($type){
				case 'register':
					if($code == $_SESSION['register_captcha']){
						return true;
					}
				break;
				case 'phone_captcha':
					if($code == $_SESSION['register_code']){
						return true;
					}
				break;
				default:
				break;
			}
		}
		return false;
	}
	
	//注册
	private function _register(){
		$type = isset($_POST['register_type']) ? $_POST['register_type'] : $_GET['register_type'];
		if(!empty($type)){
			switch($type){
				case 'pc':
					//PC端注册
					$this->pc_register();
				break;
				
				default:
				break;
			}
		}
		exit($this->callback('',self::SUCC,'错误请求'));	
	}
	/*
	private function pc_register(){
		$setting = get_setting();
		if($setting['is_register'] != 1){
			exit($this->callback('',self::SUCC,'已关闭注册，请联系客服'));
		}
		$type2 		= isset($_POST['register_type2'])? $_POST['register_type2'] : $_GET['register_type2'];
		$user_name 	= isset($_POST['user_name'])? $_POST['user_name'] : $_GET['user_name'];
		$password 	= isset($_POST['password'])? $_POST['password'] : $_GET['password'];
		$phone 		= isset($_POST['phone'])? $_POST['phone'] : $_GET['phone'];
		$phone_captcha = isset($_POST['phone_captcha'])? $_POST['phone_captcha'] : $_GET['phone_captcha'];
		$captcha 	= isset($_POST['captcha'])? $_POST['captcha'] : $_GET['captcha'];
		if(!$this->is_captcha('register',$captcha)){
			exit($this->callback('',self::SUCC,'验证码错误'));	
		}
		if(!$this->is_captcha('phone_captcha',$phone_captcha)){
			exit($this->callback('',self::SUCC,'手机验证码错误'));
		}
		//各种验证
		$preg = new preg();
		$preg->verification($user_name,array('username','min_length'=>6,'max_length'=>30),'用户名');
		$preg->verification($password,array('password','min_length'=>6,'max_length'=>30),'密码');
		$preg->verification($phone,array('phone'));
		$error = $preg->verify();
		$error_msg = reset($error);
		if(!empty($error)){
			exit($this->callback('',self::SUCC,$error_msg));
		}
		$data = array();
		$data['user_name'] = $user_name;
		$is_user = M('user')->where(array('user_name'=>$user_name))->find();
		if(!empty($is_user)){
			exit($this->callback('',self::SUCC,'用户名已存在'));
		}
		//加密
		$password = md5(sha1($password.SECRET_KEY));
		$data['user_password'] = $password;
		$data['phone'] = $phone;
		$data['add_time'] = time();
		//注册类型pc代表电脑端，type2是注册的用户类型 分为普通，邮箱，手机号注册
		$data['user_type'] = 'pc:'.$type2;
		$data['login_time'] = time();
		$data['login_ip'] = getIp();
		$data['login_type'] = 'PC';
		if($type2 == 'email'){
			$data['user_email'] = $user_name;
		}
		$res = M('user')->insert($data);
		if($res){
			exit($this->callback(200,self::SUCC,'注册成功'));
		}else{
			exit($this->callback(400,self::SUCC,'注册失败'));
		}
	}
	//发送手机验证码
	private function _send_phone(){
		$type = isset($_POST['type'])? $_POST['type'] : $_GET['type'];  //类型
		if(!empty($type)){
			switch($type){
				case 'register':
					$phone = !empty($_POST['phone'])? $_POST['phone'] : $_GET['phone'];  //手机
					$reg_phone = '/^[0-9]{11}$/';
					if(!empty($phone) && preg_match($reg_phone,$phone)){
						$code = rand(100000,999999);
						$_SESSION['register_code'] = $code;
						$data = array(
							'code'=>1,
							'register_code'=>$code,
						);
						//发送200
						exit($this->callback('',self::SUCC,$data));	
					}
				break;
				
				default:
				break;
			}
		}
		exit($this->callback('',self::ERROR_404,'发送失败'));	
	}
	*/
	
	//用户评价
	private function _user_evaluation(){
	//	$this->auth();
		$order_id = isset($_POST['order_id'])?intval($_POST['order_id']):0;
		if($order_id > 0){
			$order = M('order')->where(array('order_id'=>$order_id))->find();
			$data = array();
			if(!empty($order)){
				$data['message'] = $_POST['evaluation_info'];   //消息
				$data['evaluation_num'] = $_POST['evaluation_num'];  //评分
				$data['order_id'] = $order['order_id'];   	//订单号
				$data['user_id'] = $order['user_id'];		//用户
				$data['store_id'] = $order['store_id'];		//店铺
				$data['is_nimin'] = $_POST['is_nimin'];		//是否是匿名评论
				$data['create_time'] = time();
				$data['create_time2'] = date('Y-m-d H:i:s',$data['create_time']);
				$res = M('user_evaluate')->add($data);
				if($res){
					exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'评价成功')));
				}else{
					exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'评价失败')));
				}
			}else{
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'评价失败')));
			}
		}else{
			exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'订单错误！')));
		}
	}
	
	//是否预定
	private function _reserve(){
		$dat2 = $_POST['dat2'];
		$store_id = intval($_POST['store_id']);
		if(!empty($dat2) && $store_id > 0){
			ksort($dat2);
			$msg = '';
			$code = '';
			$return_data = array();
			$over_price = 0;
			$min_p = 0;
		//	var_dump($dat2);die;
			$price_data = array();
			if(count($dat2) > 1){
				if(reset($dat2) == 1){
					$code = '-1';
					$msg = '时间选择错误1';
				}
				if(end($dat2) == 2){
					$code = '-1';
					$msg = '时间选择错误2';
				}
				$d1 = $dat2;
				$last = 0;
				foreach($dat2 as $key => $val){
					if(count($dat2)-1 == $last){
						break;
					}
					if($last !=0 && $last != count($dat2)-1){
						if($val != 3){
							$code = '-1';
							$msg = '时间选择错误4' ;
						}
					}
					$last++;
					
					foreach($d1 as $k => $v){
						if($k != $key && strtotime($k) > strtotime($key)){
							if((strtotime($key) + 86400) == strtotime($k)){
								break;
							}else{
								$code = '-1';
								$msg = '时间选择错误3';
							}
						}
					}
				}
				if($code != '-1'){
					$quantian = false;
					foreach($dat2 as $key => $val){
						if($val == 3){
							$quantian = true;
						}else{
							$quantian = false;
						}
						$week = date('w',strtotime($key));
						if($week == 0){
							$week = 7;
						}
						if($val == 1 || $quantian){
							$label = 1;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							//	$return_data['over_price'] = $zhidingjiage['goods_price'];
							}else{
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								//	$return_data['over_price'] = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
									$ppp = $goods['goods_price'];
								//	$return_data['over_price'] = $goods['goods_price'];
								}
							}
							$price_data[] = $ppp;
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
						
						if($val == 2 || $quantian){
							$label = 2;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							}else{
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
									$ppp = $goods['goods_price'];
								}
							}
							$price_data[] = $ppp;
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}

					}
					//价格减半
					$len = (int)(count($price_data)/2);
					sort($price_data);
					//var_dump($price_data);die;
					for($i = 0 ; $i < $len ; $i ++ ){
						$min_p += (($price_data[$i])/2);
					}
				}else{
					$return_data['code'] = $code;
					$return_data['msg'] = $msg;
				}
			}else{
				foreach($dat2 as $key => $val){  //一场的价格
					$week = date('w',strtotime($key));
					if($week == 0){
						$week = 7;
					}
					$quantian = false;
					if($val == 3){
						$quantian = true;
					}
					
						if($val == 1 || $quantian){
							$label = 1;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							//	$return_data['over_price'] = $zhidingjiage['goods_price'];
							}else{
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								//	$return_data['over_price'] = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
								//	$return_data['over_price'] = $goods['goods_price'];
									$ppp = $goods['goods_price'];
								}
							}
							$price_data[] = $ppp;
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
						
						if($val == 2 || $quantian){
							$label = 2;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							}else{
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
									$ppp = $goods['goods_price'];
								}
							}
							$price_data[] = $ppp;
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
					if($val == 3){
						$min_p = min($price_data[0],$price_data[1])/2;
					}
					break;
				}
			}
			if(isset($over_price) && $over_price > 0){
				$over_price = $over_price - $min_p;
				$return_data['over_price'] = $over_price;
				$return_data['code'] = '1';
			//	$return_data['data'] = $dat2;
			}
		}
		exit($this->callback(200,self::SUCC,$return_data));
	}
	
	//立即预订，生成订单
	public function _lijiyuding(){
		$dat2 = $_POST['over_post'];
		$store_id = intval($_POST['store_id']);
	//	$is_st = false;
		if(!empty($dat2) && $store_id > 0){
			ksort($dat2);
			$msg = '';
			$code = '';
			$return_data = array();
			$over_price = 0;
			$yajin = 0;
			$changci = 1;
			$t1 = '';$t2 ='';
			$min_p = 0;
			$price_data = array();
			if(count($dat2) > 1){
				
				if(reset($dat2) == 1){
					$code = '-1';
					$msg = '预订错误';
				}
				if(end($dat2) == 2){
					$code = '-1';
					$msg = '预订错误';
				}
				
				$d1 = $dat2;
				$last = 0;
				foreach($dat2 as $key => $val){
					if(count($dat2)-1 == $last){
						break;
					}
					$last++;
					
					foreach($d1 as $k => $v){
						if($k != $key && strtotime($k) > strtotime($key)){
							if((strtotime($key) + 86400) == strtotime($k)){
								break;
							}else{
								$code = '-1';
								$msg = '预订错误';
							}
						}
					}
				}
				if($code != '-1'){
					$quantian = false;
					foreach($dat2 as $key => $val){
						if(empty($t1)){
							$t1 = $key;
						}
						if(end($dat2) == $val){
							$t2 = $key;
						}
						if($val == 3){
							$quantian = true;
						}else{
							$quantian = false;
						}
						$week = date('w',strtotime($key));
						if($week == 0){
							$week = 7;
						}
						if($val == 1 || $quantian){
							$label = 1;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							//	$return_data['over_price'] = $zhidingjiage['goods_price'];
							}else{
								
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								//	$return_data['over_price'] = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
								//	$return_data['over_price'] = $goods['goods_price'];
									$ppp = $goods['goods_price'];
								}
							}
							if($ppp > 0){
								$price_data[] = $ppp;
							}
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
						
						if($val == 2 || $quantian){
							$label = 2;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							}else{
								
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
									$ppp = $goods['goods_price'];
								}
							}
							if($ppp > 0){
								$price_data[] = $ppp;
							}
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
					}
					//价格减半
					$len = (int)(count($price_data)/2);
					//var_dump($len);die;
					sort($price_data);
					for($i = 0 ; $i < $len ; $i ++ ){
						$min_p += (($price_data[$i])/2);
					}
				}else{
					$return_data['code'] = $code;
					$return_data['msg'] = $msg;
				}
			}else{
				foreach($dat2 as $key => $val){  //一场的价格
					if(empty($t1)){
						$t1 = $key;
					}
					if(end($dat2) == $val){
						$t2 = $key;
					}
					$week = date('w',strtotime($key));
					if($week == 0){
						$week = 7;
					}
					$quantian = false;
					if($val == 3){
						$quantian = true;
					}
					if($val == 1 || $quantian){
							$label = 1;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							//	$return_data['over_price'] = $zhidingjiage['goods_price'];
							}else{
								
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								//	$return_data['over_price'] = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
								//	$return_data['over_price'] = $goods['goods_price'];
									$ppp = $goods['goods_price'];
								}
							}
							if($ppp > 0){
								$price_data[] = $ppp;
							}
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
						
						if($val == 2 || $quantian){
							$label = 2;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							}else{
								
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
									$ppp = $goods['goods_price'];
								}
							}
							if($ppp > 0){
								$price_data[] = $ppp;
							}
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
					if($val == 3){
						$min_p = min($price_data[0],$price_data[1])/2;
					}
					break;
				}
			}
			//$t1 = reset($dat2);
			$changci = reset($dat2);
			//$t2 = end($dat2);
			if(reset($dat2) == 2){
				$g1 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>2))->find();
			}else{
				$g1 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>1))->find();
			}
			//$t1 = array_flip($t1);
			$t1 .= ' '.$g1['goods_start_time'];
			if(end($dat2) == 1){
				$g2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>1))->find();
			}else{
				$g2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>2))->find();
			}
			
			//$t2 = array_flip($t2);
			$t2 .= ' '.$g2['goods_start_time'];
			$t2 = strtotime($t2) + 3600 * $g2['duration'];
			$start_time = strtotime($t1);
			$end_time = $t2;
			//生成订单
			$over_price = $over_price - $min_p;
			$order_data = array();
			$order_data['order_no'] 	= generate_order();  //生成订单号
			//押金计算
			$store = M('store')->where(array('store_id' => $store_id))->find();
			if($store['max_deposit'] > 0 && $yajin > $store['max_deposit']){
				$yajin = $store['max_deposit'];
			}else if($yajin > 2000){  //押金最高2000
				$yajin = 2000;
			}
			$order_data['deposit']  	= $yajin;  //押金
		//	$order_data['over_price']  	= $over_price;  //支付金额
			$order_data['create_time']  = time();  //支付金额
			$order_data['start_time']   = $start_time;  //开始时间
			$order_data['end_time']   	= $end_time;// $end_time;  //结束时间
			$order_data['price']   		= $over_price;  //支付价格
			$order_data['store_id']   	= $store_id;  //店铺id
			$order_data['changci']   	= $changci;  //店铺id
			
			if($order_data['price'] <= 0){
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'价格错误')));
			}
			$is_buy = M('order')->where(array('start_time'=>'<='.$start_time,'end_time'=>'>='.$end_time,'pay'=>1,'store_id'=>$store_id))->find();
			if(!empty($is_buy)){
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'已经出售')));
			}
			$order1 = M('order')->add($order_data);
			if($order1){
				$order2 = M('order')->where($order_data)->find();
				$return_data['order_id'] = $order2['order_id'];
			}else{
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'创建订单失败')));
			}
			foreach($dat2 as $key => $val){
				$ins_and_ins = false;
				if($val == 3){
					$ins_and_ins = true;
				}
				$order_room_buy = array();
				$order_room_buy['order_id'] = $order2['order_id'];
				$order_room_buy['store_id'] = $store_id;
				$order_room_buy['create_time'] = time();
				$order_room_buy['order_time'] = strtotime($key);
				if($val == 1 || $ins_and_ins){
					$order_room_buy['label'] = 1;
					M('order_room_buy')->add($order_room_buy);
				}
				if($val == 2 || $ins_and_ins){
					$order_room_buy['label'] = 2;
					M('order_room_buy')->add($order_room_buy);
				}
			}
			if(isset($over_price) && $over_price > 0){
				$return_data['over_price'] = $over_price;
				$return_data['code'] = '1';
			}
			
		}
	//	die;
		exit($this->callback(200,self::SUCC,$return_data));
	}
	
	//带学生证重新计算价格
	public function _new_math_order_price(){
		$order_id = $_POST['order_id'];
		$store_id = $_POST['store_id'];
		$st_cart = $_POST['st_cart'];
	//	$user_id  = $_POST['user_id'];
		if($order_id > 0){
			$room = M('order_room_buy')->where(array('order_id'=>$order_id))->select();
			$user = M('user')->where(array('user_id' => $user_id))->find();
			$dat2 = array();
			if(!empty($room)){
				foreach($room as $key => $val){
					$t = date('Y-m-d',$val['order_time']);
					if(isset($dat2[$t])){
						$dat2[$t] = 3;
					}else{
						$dat2[$t] = $val['label'];
					}
				}
				if(!empty($dat2)){
					$user_coupon_where = array(
						'is_del' => 0,
						'is_use' => 0,
						'c_code' => $st_cart,
					);
					$user_coupon2 = M('user_coupon2')->where($user_coupon_where)->find();
					if(!empty($user_coupon2)){  //
						$data = $this->chongxinjisuan2($dat2,$order_id,$store_id,$st_cart);
					}else{
						$data = $this->chongxinjisuan($dat2,$order_id,$store_id);
					}
					exit($this->callback(200,self::SUCC,$data));
				}
			}
		}
	}
	
	//提交学生证号，重新计算价格，在前台显示
	private function chongxinjisuan($dat2,$order_id,$store_id){
		//
		$order = M('order')->where(array('order_id'=> $order_id))->find();
		if(!empty($dat2) && $store_id > 0){
			ksort($dat2);
			$msg = '';
			$code = '';
			$return_data = array();
			$over_price = 0;
			$yajin = 0;
			$changci = 1;
			$t1 = '';$t2 ='';
			$min_p = 0;
			$price_data = array();
			if(count($dat2) > 1){
				
				if(reset($dat2) == 1){
					$code = '-1';
					$msg = '预订错误';
				}
				if(end($dat2) == 2){
					$code = '-1';
					$msg = '预订错误';
				}
				
				$d1 = $dat2;
				$last = 0;
				foreach($dat2 as $key => $val){
					if(count($dat2)-1 == $last){
						break;
					}
					$last++;
					
					foreach($d1 as $k => $v){
						if($k != $key && strtotime($k) > strtotime($key)){
							if((strtotime($key) + 86400) == strtotime($k)){
								break;
							}else{
								$code = '-1';
								$msg = '预订错误';
							}
						}
					}
				}
				if($code != '-1'){
					$quantian = false;
					foreach($dat2 as $key => $val){
						$ppp1 = $ppp2 = 0;
						if(empty($t1)){
							$t1 = $key;
						}
						if(end($dat2) == $val){
							$t2 = $key;
						}
						if($val == 3){
							$quantian = true;
						}else{
							$quantian = false;
						}
						$week = date('w',strtotime($key));
						if($week == 0){
							$week = 7;
						}
						if($val == 1 || $quantian){
							$label = 1;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							//	$return_data['over_price'] = $zhidingjiage['goods_price'];
							}else{
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>3,'st'=>'bai'))->find();
							//	$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								//	$return_data['over_price'] = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
								//	$return_data['over_price'] = $goods['goods_price'];
									$ppp = $goods['goods_price'];
								}
							}
							if($ppp > 0){
								$price_data[] = $ppp;
								$ppp1 = $ppp;
							}
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
						
						if($val == 2 || $quantian){
							$label = 2;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							}else{
								
							//	$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>4,'st'=>'ye'))->find();
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
									$ppp = $goods['goods_price'];
								}
							}
							if($ppp > 0){
								$price_data[] = $ppp;
								$ppp2 = $ppp;
							}
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
						if($val == 3){
							$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>5,'st'=>'st_all'))->find();
							$over_price = $over_price + $week_price['week'.$week] - $ppp1 - $ppp2 ;
						}
					}
					//价格减半
					$len = (int)(count($price_data)/2);
					sort($price_data);
					for($i = 0 ; $i < $len ; $i ++ ){
						$min_p += (($price_data[$i])/2);
					}
					
				}else{
					$return_data['code'] = $code;
					$return_data['msg'] = $msg;
				}
			}else{
				foreach($dat2 as $key => $val){  //一场的价格
					if(empty($t1)){
						$t1 = $key;
					}
					if(end($dat2) == $val){
						$t2 = $key;
					}
					$week = date('w',strtotime($key));
					if($week == 0){
						$week = 7;
					}
					$quantian = false;
					if($val == 3){
						$quantian = true;
					}
					if($val == 1 || $quantian){
							$label = 1;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							//	$return_data['over_price'] = $zhidingjiage['goods_price'];
							}else{
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>3,'st'=>'bai'))->find();
								
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								//	$return_data['over_price'] = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
								//	$return_data['over_price'] = $goods['goods_price'];
									$ppp = $goods['goods_price'];
								}
							}
							if($ppp > 0){
								$price_data[] = $ppp;
							}
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
						
						if($val == 2 || $quantian){
							$label = 2;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							}else{
								
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>4,'st'=>'ye'))->find();
								//var_dump($week_price);die;
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
									$ppp = $goods['goods_price'];
								}
							}
							if($ppp > 0){
								$price_data[] = $ppp;
							}
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
					if($val == 3){
						$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>5,'st'=>'st_all'))->find();
						if(!empty($week_price)){
							$over_price = $over_price + $week_price['week'.$week] - $price_data[0] - $price_data[1] ;
						}
						$min_p = min($price_data[0],$price_data[1])/2;
					}
					
					break;
				}
			}
			$changci = reset($dat2);
			if(reset($dat2) == 2){
				$g1 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>2))->find();
			}else{
				$g1 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>1))->find();
			}
			//$t1 = array_flip($t1);
			$t1 .= ' '.$g1['goods_start_time'];
			if(end($dat2) == 1){
				$g2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>1))->find();
			}else{
				$g2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>2))->find();
			}
			$youhuijuan = 0;
			if(!empty($order['youhui_price'])){  //这是个id号
				$coupon = M('user_coupon')->where(array('coupon_id'=>$order['youhui_price']))->find();
				if(!empty($coupon)){
					$youhuijuan = $coupon['coupon_price'];
					$coupon_id = $coupon['coupon_id'];
				}
			}
			//$t2 = array_flip($t2);
			$t2 .= ' '.$g2['goods_start_time'];
			$t2 = strtotime($t2) + 3600 * $g2['duration'];
			$start_time = strtotime($t1);
			$end_time = $t2;
			$store = M('store')->where(array('store_id' => $store_id))->find();
			if($store['max_deposit'] > 0 && $yajin > $store['max_deposit']){
				$yajin = $store['max_deposit'];
			}else if($yajin > 2000){  //押金最高2000
				$yajin = 2000;
			}
			$room_price = 0;   //房间消费
			$room = M('order_goods_buy')->where(array('order_id'=>$order_id,'is_del'=>0,'is_buy'=>'0'))->select();
			if(!empty($room)){
				foreach($room as $key => $val){
					$room_price += $val['z_price'];
				}
			}
			//终极价格 减去多场减半  加押金 减优惠卷 加房间价格
			//var_dump($over_price.'|||'.$min_p."|||".$yajin.'|||'.$youhuijuan.'|||'.$room_price);die;
			$over_price = $over_price - $min_p - $youhuijuan + $room_price ;
			if($over_price < 0){
				$over_price = 0 + $yajin;
			}else{
				$over_price += $yajin;
			}
			$order['price'] = $over_price;
			$_SESSION['order'] = $order;
			
			if(isset($over_price) && $over_price > 0){
				$return_data['over_price'] = $over_price;
				$return_data['code'] = '1';
			}
			
			return $return_data;
		}
		return null;
	}
	
	public function chongxinjisuan2($dat2,$order_id,$store_id,$st_cart){
	//	$dat2 = $_POST['over_post'];
	//	$store_id = intval($_POST['store_id']);
	//	$is_st = false;
		if(!empty($dat2) && $store_id > 0){
			$order = M('order')->where(array('order_id' => $order_id))->find();
			ksort($dat2);
			$msg = '';
			$code = '';
			$return_data = array();
			$over_price = 0;
			$yajin = 0;
			$changci = 1;
			$t1 = '';$t2 ='';
			$min_p = 0;
			$price_data = array();
			if(count($dat2) > 1){
				
				if(reset($dat2) == 1){
					$code = '-1';
					$msg = '预订错误';
				}
				if(end($dat2) == 2){
					$code = '-1';
					$msg = '预订错误';
				}
				
				$d1 = $dat2;
				$last = 0;
				foreach($dat2 as $key => $val){
					if(count($dat2)-1 == $last){
						break;
					}
					$last++;
					
					foreach($d1 as $k => $v){
						if($k != $key && strtotime($k) > strtotime($key)){
							if((strtotime($key) + 86400) == strtotime($k)){
								break;
							}else{
								$code = '-1';
								$msg = '预订错误';
							}
						}
					}
				}
				if($code != '-1'){
					$quantian = false;
					foreach($dat2 as $key => $val){
						if(empty($t1)){
							$t1 = $key;
						}
						if(end($dat2) == $val){
							$t2 = $key;
						}
						if($val == 3){
							$quantian = true;
						}else{
							$quantian = false;
						}
						$week = date('w',strtotime($key));
						if($week == 0){
							$week = 7;
						}
						if($val == 1 || $quantian){
							$label = 1;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							//	$return_data['over_price'] = $zhidingjiage['goods_price'];
							}else{
								
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								//	$return_data['over_price'] = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
								//	$return_data['over_price'] = $goods['goods_price'];
									$ppp = $goods['goods_price'];
								}
							}
							if($ppp > 0){
								$price_data[] = $ppp;
							}
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
						
						if($val == 2 || $quantian){
							$label = 2;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							}else{
								
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
									$ppp = $goods['goods_price'];
								}
							}
							if($ppp > 0){
								$price_data[] = $ppp;
							}
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
					}
					//价格减半
					$len = (int)(count($price_data)/2);
					//var_dump($len);die;
					sort($price_data);
					for($i = 0 ; $i < $len ; $i ++ ){
						$min_p += (($price_data[$i])/2);
					}
				}else{
					$return_data['code'] = $code;
					$return_data['msg'] = $msg;
				}
			}else{
				foreach($dat2 as $key => $val){  //一场的价格
					if(empty($t1)){
						$t1 = $key;
					}
					if(end($dat2) == $val){
						$t2 = $key;
					}
					$week = date('w',strtotime($key));
					if($week == 0){
						$week = 7;
					}
					$quantian = false;
					if($val == 3){
						$quantian = true;
					}
					if($val == 1 || $quantian){
							$label = 1;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							//	$return_data['over_price'] = $zhidingjiage['goods_price'];
							}else{
								
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								//	$return_data['over_price'] = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
								//	$return_data['over_price'] = $goods['goods_price'];
									$ppp = $goods['goods_price'];
								}
							}
							if($ppp > 0){
								$price_data[] = $ppp;
							}
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
						
						if($val == 2 || $quantian){
							$label = 2;
							$zhidingjiage  = M('goods_week_price')->where(array('update_time'=>strtotime($key),'store_id'=>$store_id,'label'=>$label))->find();
							if(!empty($zhidingjiage)){
								$over_price += $zhidingjiage['goods_price'];
								$ppp = $zhidingjiage['goods_price'];
							}else{
								
								$week_price = M('goods_week_price')->where(array('update_time'=>'0','store_id'=>$store_id,'label'=>$label))->find();
								
								if(!empty($week_price)){
									$over_price += $week_price['week'.$week];
									$ppp = $week_price['week'.$week];
								}else{
									$goods = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
									$over_price += $goods['goods_price'];
									$ppp = $goods['goods_price'];
								}
							}
							if($ppp > 0){
								$price_data[] = $ppp;
							}
							$goods2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>$label))->find();
							$yajin += $goods2['deposit'];
						}
					if($val == 3){
						$min_p = min($price_data[0],$price_data[1])/2;
					}
					break;
				}
			}
			//$t1 = reset($dat2);
			$changci = reset($dat2);
			//$t2 = end($dat2);
			if(reset($dat2) == 2){
				$g1 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>2))->find();
			}else{
				$g1 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>1))->find();
			}
			//$t1 = array_flip($t1);
			$t1 .= ' '.$g1['goods_start_time'];
			if(end($dat2) == 1){
				$g2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>1))->find();
			}else{
				$g2 = M('goods')->where(array('store_id'=>$store_id,'goods_label'=>2))->find();
			}
			
			//$t2 = array_flip($t2);
			$t2 .= ' '.$g2['goods_start_time'];
			$t2 = strtotime($t2) + 3600 * $g2['duration'];
			$start_time = strtotime($t1);
			$end_time = $t2;
			//生成订单
			$over_price = $over_price - $min_p;
			$order_data = array();
			
			//押金计算
			$store = M('store')->where(array('store_id' => $store_id))->find();
			if($store['max_deposit'] > 0 && $yajin > $store['max_deposit']){
				$yajin = $store['max_deposit'];
			}else if($yajin > 2000){  //押金最高2000
				$yajin = 2000;
			}
			
			if(isset($over_price) && $over_price > 0){
				$return_data['over_price'] = $over_price;
				$return_data['code'] = '1';
			}
			
			$youhuijuan = 0;
			if(!empty($order['youhui_price'])){  //这是个id号
				$coupon = M('user_coupon')->where(array('coupon_id'=>$order['youhui_price']))->find();
				if(!empty($coupon)){
					$youhuijuan = $coupon['coupon_price'];
					$coupon_id = $coupon['coupon_id'];
				}
			}
			
			$room_price = 0;   //房间消费
			$room = M('order_goods_buy')->where(array('order_id'=>$order_id,'is_del'=>0,'is_buy'=>'0'))->select();
			if(!empty($room)){
				foreach($room as $key => $val){
					$room_price += $val['z_price'];
				}
			}
			
			$user_coupon_where = array(
				'is_del' => 0,
				'is_use' => 0,
				'c_code' => $st_cart,
			);
			$user_coupon2 = M('user_coupon2')->where($user_coupon_where)->find();
			if(!empty($user_coupon2)){
				$return_data['over_price'] -= $user_coupon2['c_price'];
			}
			
			
			//计算金额
			$return_data['over_price'] = $return_data['over_price'] - $youhuijuan + $yajin + $room_price;
			
			$order['price'] = $return_data['over_price'];
			$_SESSION['order'] = $order;
			return $return_data;
		}
		return null;
	}
	
	//设置优惠卷
	public function _set_coupon(){
		$order_id = intval($_POST['order_id']);
		$coupon_id = intval($_POST['coupon_id']);
		if($order_id > 0 && $coupon_id > 0){
		//	$coupon = M('user_coupon')->where(array('coupon_id'=> $coupon_id ))->find();
		//	$order = M('order')->where(array('order_id'=> $order_id))->find();
			$res = M('order')->where(array('order_id'=> $order_id))->update(array('youhui_price'=>$coupon_id));
			if($res){
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'设置成功')));
			}else{
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'设置失败')));
			}
		}
	}
	
	public function _get_month_order_reserve(){
		
		$store_id 	= $_POST['store_id'];
		$today 		= $_POST['today'];
		if($store_id > 0 && !empty($today)){
			$return_data = array();
			$time = date('Y-m',strtotime($today));
			$year = (int)date('Y',strtotime($today));
			$month = (int)date('m',strtotime($today));
			$room = M('order_room_buy');
			$goods = M('goods')->where(array('store_id' => $store_id))->select();
			
			for($i = 1 ; $i <= 31 ; $i ++){
				if($i < 10){
					$i = (string)('0'.$i);
				}
			//	var_dump(is_date($time.'-'.$i).'|||'.$time.'-'.$i.'|||'.strtotime($time.'-'.$i));
				if(is_date($time.'-'.$i)){  //判断这天是否存在
					foreach($goods as $key => $val){
						$is_buy = $room
									->where(array('is_buy'=>1,
												  'store_id'=>$store_id,
												  'order_time'=>strtotime($time.'-'.$i),
												  'label'=>$val['goods_label'],
												  'is_del' => 0,
												)
											)
									->find();
					
						if(!empty($is_buy)){
							
							$return_data[$year.'-'.$month.'-'.$i][$val['goods_label']] = $is_buy['label'];
						}
					}
				}
			}
		//	var_dump($return_data);die;
			if(!empty($return_data)){
				foreach($return_data as $key => $val){
					if(count($val) == 2){
						$return_data[$key] = 3;  //全天
					}
					if(count($val) == 1){
						$return_data[$key] = reset($val);
					}
				}
				exit($this->callback(200,self::SUCC,$return_data));
			}else {
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'无订单数据')));
			}
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'获取订单数据失败')));
	}
	
	//修改订单备注
	private function _order_remarks(){
	//  $this->auth();
		$order_id = $_POST['order_id'];
		$order_remarks = $_POST['order_remarks'];
		if(!empty($order_remarks)){
			$res = M('order')->where(array('order_id'=>$order_id))->update(array('order_remarks'=>$order_remarks));
			if($res){
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'添加备注信息成功！')));
			}else{
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'添加备注信息失败！')));
			}
		}else{
			exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'添加备注信息失败！')));
		}
	}
	
	//取消订单
	private function _quxiaodingdan(){
		$order_id 	= intval($_POST['order_id']);
		$order_no 	= $_POST['order_no'];
		$sign 		= $_POST['sign'];
		
		if($order_id > 0 && !empty($sign)){
			$order = M('order')->where(array('order_id'=> $order_id))->find();
			if(!empty($order)){
				$sign2 = de_key($sign,KEY);
				if($sign2 != $order['order_no']){
					exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'参数错误')));
				}else{
					$res = M('order')->where(array('order_id'=> $order_id))->update(array('pay'=>2));
					if($res){
						exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'取消订单成功')));
					}else{
						exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'取消订单失败')));
					}
				}
			}
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'取消订单错误')));
	}
	
	//已支付的订单取消订单
	private function _quxiaodingdan2(){
		$order_id 	= intval($_POST['order_id']);
		$order_no 	= $_POST['order_no'];
		$sign 		= $_POST['sign'];
		
		if($order_id > 0 && !empty($sign)){
			$order = M('order')->where(array('order_id'=> $order_id))->find();
			if(!empty($order)){
				$sign2 = de_key($sign,KEY);
				if($sign2 != $order['order_no']){
					exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'参数错误')));
				}else{
					//已经结算的，不能取消
					if($order['is_settlement'] == 1){
						exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'已经结算的订单不能取消')));
					}
					$res = M('order')->where(array('order_id'=> $order_id))->update(array('o_state'=>1));
					if($res){
						exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'取消订单成功')));
					}else{
						exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'取消订单失败')));
					}
				}
			}
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'取消订单错误')));
	}
	
	//订单补全
	private function _order_buquan(){
		$dat = $_POST['data'];
		$order_id = intval($dat['order_id']);
		if($order_id > 0){
			$order = M('order')->where(array('order_id'=>$order_id))->find();
			$sign = de_key($dat['sign'],KEY);
			if($sign != $order['order_no']){
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'订单错误,参数错误')));
			}
			$update_date = array();
			$youhui = 0;
			if(!empty($order['youhui_price']) && $order['youhui_price'] > 0){
				$coupon = M('user_coupon')->where(array('coupon_id'=>$order['youhui_price']))->find();
				$youhui = $coupon['coupon_price'];
			}
			
			$room_price = 0;   //房间消费
			$room = M('order_goods_buy')->where(array('order_id'=>$order_id,'is_del'=>0,'is_buy'=>'0'))->select();
			if(!empty($room)){
				foreach($room as $key => $val){
					$room_price += $val['z_price'];
				}
			}
			
			$update_date['id_cart']   	= $dat['id_cart'];  //身份证
			$update_date['st_cart']   	= $dat['st_cart'];  //学生证
			$update_date['people_num'] 	= $dat['pop_num'];
			$update_date['safe_name'] 	= $dat['name'];
			$update_date['mobile'] 		= $dat['phone'];
			$update_date['user_id'] 		= $dat['user_id'];
			$update_date['yaoqingma'] 		= $dat['yaoqingma'];
			$update_date['over_price'] = $order['price'] + $room_price - $youhui;// + $order['deposit'];  //这里是最微信要支付的价格
			if($update_date['over_price'] < 0){
				$update_date['over_price'] = 0 + $order['deposit'];
			}else{
				$update_date['over_price'] += $order['deposit'];
			}
			
			//重设价格
			if( !empty($dat['st_cart']) && isset($_SESSION['order'])){
				$order['over_price'] = $_SESSION['order']['price'];
			//	$update_date['price'] = $_SESSION['order']['price'];
				$update_date['over_price'] = $_SESSION['order']['price'];
				unset($_SESSION['order']);
			}
			
			$res = M('order')->where(array('order_id'=>$order_id))->update($update_date);
			if($res){
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'修改订单成功')));
			}else{
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'订单错误')));
			}
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'订单错误')));
	}
	
	//房间消费添加商品
	private function _fangjianxiaofeitianjiashangping(){
		$order_id = intval($_POST['order_id']);
		if($order_id > 0  && !empty($_POST['sign'])){
			$order = M('order')->where(array('order_id'=>$order_id))->find();
			$sign = de_key($_POST['sign'],KEY);
			if($sign != $order['order_no']){
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'参数错误')));
			}
			$list = $_POST['data'];
			if(!empty($list)){
				$where = array(
					'store_id'=> $order['store_id'],
					'order_id'=> $order['order_id'],
				);
				M('order_goods_buy')->where($where)->del();
				foreach($list as $key => $val){
					$data = array();
					$data['goods_id'] = $key;
					$data['store_id'] = $order['store_id'];
					$data['order_id'] = $order['order_id'];
					
					$data['z_price'] = $val['z_price'];
					$data['price'] = $val['price'];
					$data['goods_num'] = $val['num'];
					
					$data['create_time'] = time();
					$data['create_time2'] = date('Y-m-d H:i:s',time());
					$res = M('order_goods_buy')->add($data);
					
					if(!$res){
						exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'添加商品错误1')));
					}
				}
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'添加商品成功')));
			}
			
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'添加商品错误！')));
	}
	
	//房间消费添加商品
	private function _fangjianxiaofeitianjiashangping2(){
		$order_id = intval($_POST['order_id']);
		if($order_id > 0  && !empty($_POST['sign'])){
			$order = M('order')->where(array('order_id'=>$order_id))->find();
			$sign = de_key($_POST['sign'],KEY);
			if($sign != $order['order_no']){
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'参数错误')));
			}
			$list = $_POST['data'];
			$out_trade_no = date('YmdHis').rand(10000,99999).rand(10000,99999);
			if(!empty($list)){
				$where = array(
					'store_id'=> $order['store_id'],
					'order_id'=> $order['order_id'],
				);
				//M('order_goods_buy')->where($where)->del();  //不能删除咯
				foreach($list as $key => $val){
					$data = array();
					$data['goods_id'] = $key;
					$data['store_id'] = $order['store_id'];
					$data['order_id'] = $order['order_id'];
					
					$data['z_price'] = $val['z_price'];
					$data['price'] = $val['price'];
					$data['goods_num'] = $val['num'];
					$data['out_trade_no'] = $out_trade_no;
					
					$data['create_time'] = time();
					$data['create_time2'] = date('Y-m-d H:i:s',time());
					$res = M('order_goods_buy')->add($data);
					
					if(!$res){
						exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'添加商品错误1')));
					}
				}
				if(isset($_POST['fujia']) && !empty($_POST['fujia']['message'])){
					$call_guanjia = array(
						'g_message' => $_POST['fujia']['message'],
						'order_id'  => $order['order_id'],
						'store_id'  => $order['store_id'],
						'create_time'  => time(),
					);
					M('guanjia_message')->add($call_guanjia);
				}
				
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'添加商品成功','out_trade_no'=>$out_trade_no)));
			}
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'添加商品错误！')));
	}
	
	//房间消费添加商品
	private function _fangjianxiaofeitianjiashangping3(){
		$store_id = $_POST['store_id'];
		$user_id = $_POST['user_id'];
		$list = $_POST['data'];
		$out_trade_no = date('YmdHis').rand(10000,99999).rand(10000,99999);
		if(!empty($list)){
			foreach($list as $key => $val){
				$data = array();
				$data['goods_id'] = $key;
				$data['store_id'] = $store_id ;
				$data['order_id'] = 0;
				
				$data['z_price'] = $val['z_price'];
				$data['price'] = $val['price'];
				$data['user_id'] = $user_id;
				$data['goods_num'] = $val['num'];
				$data['out_trade_no'] = $out_trade_no;
				
				$data['create_time'] = time();
				$data['create_time2'] = date('Y-m-d H:i:s',time());
				$res = M('order_goods_buy')->add($data);
				
				if(!$res){
					exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'添加商品错误1')));
				}
			}
			if(empty($_POST['fujia']['message'])){
				$_POST['fujia']['message'] = '有人买东西啦！！！';
			}
			if(isset($_POST['fujia']) && !empty($_POST['fujia']['message'])){
				$call_guanjia = array(
					'g_message' => $_POST['fujia']['message'],
					'order_id'  => 0,
					'store_id'  => $store_id ,
					'create_time'  => time(),
				);
				M('guanjia_message')->add($call_guanjia);
			}
			
			exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'添加商品成功','out_trade_no'=>$out_trade_no)));
		}
	
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'添加商品错误！')));
	}
	
	//个人购买
	private function _people_buy(){
		$out_trade_no = $_POST['out_trade_no'];
		if(!empty($out_trade_no)){
			$goods = M('order_goods_buy')->where(array('out_trade_no'=>$out_trade_no))->find();
			if($goods['is_buy'] == 1){
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'购买成功','out_trade_no'=>$out_trade_no)));
			}
		}
	}
	//查询是否购买
	private function _order_is_pay(){
		$order_id = intval($_POST['order_id']);
		if($order_id > 0){
			$order = M('order')->where(array('order_id'=>$order_id))->find();
			$sign = de_key($_POST['sign'],KEY);
			if($sign != $order['order_no']){
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'参数错误')));
			}
			if($order['pay'] == 1 && $order['deposit_pay'] == 1){
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'支付成功')));
			}
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'获取数据信息错误')));
	}
	
	//查询是否房间交易成功
	private function _room_goods_is_buy(){
		$order_id = intval($_POST['order_id']);
		$out_trade_no = $_POST['out_trade_no'];
		if($order_id > 0){
			
			$order = M('order')->where(array('order_id'=>$order_id))->find();
			$out_trade_no = M('order_goods_buy')->where(array('out_trade_no'=>$out_trade_no))->find();
			$sign = de_key($_POST['sign'],KEY);
			if($sign != $order['order_no']){
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'参数错误')));
			}
			if($out_trade_no['is_buy'] == 1){
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'支付成功')));
			}
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'获取数据信息错误')));
	}
	
	//开发票
	private function _kaifapiao(){
		$data = $_POST['data'];
		if($data && intval($data['order_id']) > 0){
			$insert = array();
			$insert['user_id'] = $data['user_id'];
			$insert['order_id'] = $data['order_id'];
			$insert['f_title'] = $data['f_title'];
			$insert['f_price'] = $data['f_price'];
			$insert['f_name'] 	= $data['f_name'];
			$insert['email'] 	= $data['email'];
			$insert['phone'] 	= $data['phone'];
			$insert['address'] 	= $data['address'];
			$insert['xx_address'] = $data['xx_address'];
			$insert['f_fapiaoneirong'] = $data['f_fapiaoneirong'];
			$insert['f_xinghao'] = $data['f_xinghao'];
			$insert['create_time'] = time();
			$order = M('order')->where(array('order_id'=> $data['order_id']))->find();
			$insert['store_id'] = $order['store_id'];
			$is_fa = M('fapiao')->where(array('user_id'=> $data['user_id'],'order_id'=>$data['order_id']))->find();
			if(empty($is_fa)){
				$res = M('fapiao')->add($insert);
				if($res){
					exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'申请发票成功')));
				}else{
					exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'添加失败')));
				}
			}else{
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'已经申请过发票了')));
			}
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'获取数据信息错误')));
	}
	
	//晒单评分
	private function _shaidanpingfen(){
		$data = $_POST['data'];
		$this->order_sign_auth($data['sign'],$data['order_id']);
		if(intval($data['order_id']) > 0){
			$insdata = array();
			$user_evaluate = M('user_evaluate')->where(array('order_id'=>$data['order_id']))->find();
			$order = M('order')->where(array('order_id'=>$data['order_id']))->find();
			if(!empty($user_evaluate)){
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'您已经评价过了哦')));
			}
			$insdata['message']  = $data['message'];
			$insdata['message2'] = $data['message2'];
			$insdata['order_id'] = $data['order_id'];
			$insdata['user_id']  = $data['user_id'];
			$insdata['store_id'] = $order['store_id'];
			$insdata['evaluation_num'] 	= $data['pingfen'];
			$insdata['info_taidu'] 	= $data['taidu'];
			$insdata['info_sudu'] 	= $data['sudu'];
			$insdata['info_zhiliang'] 	= $data['zhiliang'];
			$insdata['create_time'] 	= time();
			$insdata['is_type'] 	= 1;
			if(isset($data['images']) && !empty($data['images'])){
				$insdata['images'] = implode(',',$data['images']);
			}
			$res = M('user_evaluate')->add($insdata);
			M('order')->where(array('order_id'=> $data['order_id']))->update(array('is_pingjia' => 1));
			if($res){
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'晒单评价成功')));
			}else{
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'晒单评价失败')));
			}
		}
	}
	
	private function _yijianfankui(){
		$data = $_POST['data'];
		$time = time();
		$insdata = array();
		$is_ins = M('yijianfankui')->where(array('user_id' =>$data['user_id'],'create_time'=>'>'.($time-5*60)))->limit(3)->select();
		if(!empty($is_ins) && count($is_ins) == 3){
			exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'请勿频繁提交')));
		}
		$insdata['user_id'] = $data['user_id'];
		$insdata['y_type'] = $data['y_type'];
		$insdata['y_info'] = $data['y_info'];
		$insdata['y_phone'] = $data['y_phone'];
		$insdata['create_time'] = $time;
		if(isset($data['y_images']) && !empty($data['y_images'])){
			$insdata['y_images'] = implode(',',$data['y_images']);
		}
		$res = M('yijianfankui')->add($insdata);
		if($res){
			exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'反馈成功')));
		}else{
			exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'反馈失败')));
		}
	}
	private function _gerenziliao(){
		$data = $_POST['data'];
		$user_id = intval($_POST['user_id']);
		if($user_id > 0){
			$res = M('user')->where(array('user_id'=> $user_id))->update($data);
			if($res){
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'修改成功')));
			}else{
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'修改失败')));
			}
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'错误')));
	}
	
	//订单加密判定  //传过来的order_no 加密
	private function order_sign_auth($sign,$order_id){
		$order = M('order')->where(array('order_id'=>$order_id))->find();
		if(!empty($order)){
			$order_no = de_key($sign,KEY);
			if($order_no == $order['order_no']){
				return true;
			}
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'参数错误')));
		return false;
	}
	
	//管家获取信息
	private function _get_guanjia_message(){
		$store_id = intval($_POST['store_id']);
		if($store_id > 0){
			$where = array(
				'store_id' => $store_id,
				'is_use' => 0,
				'create_time' => '>'.(time()-7200),  //两个小时前
			);
			$data = M('guanjia_message')->where($where)->select();
			if(!empty($data)){
				$str = '';
				$str .= '时间：'.date('Y-m-d H:i:s',$data[0]['create_time']).'<br>';
				if(!empty($data[0]['user_name'])){
					$str .= '名称：'.$data[0]['user_name'].'<br>';
				}
				if(!empty($data[0]['phone'])){
					$str .= '手机：'.$data[0]['phone'].'<br>';
				}
				if(!empty($data[0]['g_message'])){
					$str .= '消息：'.$data[0]['g_message'].'<br>';
				}
				if(!empty($data[0]['g_message2'])){
					$str .= '位置：'.$data[0]['g_message2'].'<br>';
				}
				if(!empty($str)){
					$data[0]['g_message'] = $str;
				}
			}
			
			if(!empty($data)){
				$data['count'] = count($data);
				$data['code'] = 1;
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>$data)));
			}else{
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'无消息')));
			}
		}
	}
	
	//发送验证码
	private function _send_phone_code(){
		
		$phone = $_POST['phone'];
		$order_id = $_POST['order_id'];
		$sign = $_POST['sign'];
		//$user_id = $_POST['user_id'];
		$this->order_sign_auth($_POST['sign'],$_POST['order_id']);
		
		if($order_id > 0 && $_POST['captcha'] == $_SESSION['phone_captcha']){
			if(time()-$_SESSION['phone_ss_time'] > 60 ){
				$_SESSION['phone_ss_time'] = time();
			}else{
				die;
			}
			$code = rand(1000,9999);
			include_once BasePath.DS.'plugins/ronglian/SendTemplateSMS.php';
			sendTemplateSMS($phone,array($code),170411);
			$_SESSION['phone_code'] = $code;
			$_SESSION['send_phone'] = $phone;
			$_SESSION['phone_ss_time'] = time();
			$data = array(
				'code' => 1,
				'message' => '发送成功',
		//		'phone_code' => $code,
			);
			exit($this->callback(200,self::SUCC,$data));
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'发送失败')));
		
	}
	//发送语音验证码
	private function _send_voice_code(){
		if(isset($_SESSION['phone_code']) && !empty($_SESSION['phone_code'])){
			if(time()-$_SESSION['phone_vv_time'] > 60 ){
				$_SESSION['phone_vv_time'] = time();
			}else{
				die;
			}
			$_SESSION['phone_vv_time'] = time();
			include_once BasePath.DS.'plugins/voice_code/VoiceVerify.php';
			voiceVerify($_SESSION['phone_code'],"3",$_SESSION['send_phone']);
		}
		
	}
	//判断验证码是否正确
	private function _is_captcha(){
		$captcha = $_POST['captcha'];
		if(isset($_POST['captcha']) && !empty($captcha)){
			if($captcha == $_SESSION['phone_captcha']){
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'验证码正确')));
			}
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'验证码错误')));
	}
	
	//我知道了
	private function _my_know_message(){
		$g_id = intval($_POST['g_id']);
		$admin_id= intval($_POST['admin_id']);
		$sign = $_POST['sign'];
		if($g_id > 0 && $admin_id > 0){
			$admin = M('admin')->where(array('admin_id'=>$admin_id))->find();
			if(!empty($admin) && de_key($sign,KEY) == $admin['username']){
				$res = M('guanjia_message')->where(array('g_id '=>$g_id))->update(array('is_use'=>1));
				if($res){
					exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'成功')));
				}
			}
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'访问错误')));
	}
	
	//呼叫管家
	private function _hujiaoguanjia(){
		$data = $_POST['data'];
		$insert = array();
		if(isset($data['name']) && !empty($data['name'])){
			$insert['user_name'] = $data['name'];
		}
		if(isset($data['phone']) && !empty($data['phone'])){
			$insert['phone'] = $data['phone'];
		}
		if(isset($data['name']) && !empty($data['name'])){
			$insert['user_name'] = $data['name'];
		}
		if(isset($data['position']) && !empty($data['position'])){
			$insert['g_message2'] = $data['position'];
		}
		if(isset($data['beizhu']) && !empty($data['beizhu'])){
			$insert['g_message'] = $data['beizhu'];
		}
		if(isset($data['order_id']) && !empty($data['order_id'])){
			$order = M('order')->where(array('order_id'=>$data['order_id']))->find();
			$insert['order_id'] = $data['order_id'];
			$insert['store_id'] = $order['store_id'];
		}
		if(!empty($insert)){
			$insert['create_time'] = time();
			$res = M('guanjia_message')->add($insert);
			exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'呼叫成功')));
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'呼叫失败')));
	}
	
	
	//管家知道商品已送出
	private function _room_goods_buy_my_know(){
		$buy_id = $_POST['buy_id'];
		if($buy_id){
			M('order_goods_buy')->where(array('buy_id'=>$buy_id))->update(array('is_know'=>1));
		}
	}
	
	//删除订单
	private function _delete_order(){
		$order_id = $_POST['order_id'];
		if($order_id > 0){
			$res = M('order')->where(array('order_id' => $order_id))->update(array('is_del' => 1));
			if($res){
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'删除成功')));
			}else{
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'删除失败')));
			}
		}
	}
	
	//商品租赁
	private function _shangpinzulin(){
		$order_id = intval($_POST['order_id']);
		$store_id = intval($_POST['store_id']);
		$dat = $_POST['data'];
		if($store_id > 0 && $order_id){
			$data = array();
			if(!empty($dat)){
				foreach($dat as $key => $val){
					$d = array();
					$d['zl_id'] = $key;
					$d['create_time'] = time();
					$d['store_id'] = $store_id;
					$d['z_num'] = $val['num'];
					$d['z_price'] = $val['z_price'];
					$d['order_id'] = $order_id;
					$d['message'] = $_POST['info'];
					$data[] = $d;
				}
				$res = M('shangpinzulin_log')->insert_all($data);
				if($res){
					exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'租赁商品成功')));
				}
			}
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'数据有误')));
	}
	
	private function _toupiao(){
		$ovar_time = '2017-05-26 00:00:00';
		$ovar_time = strtotime($ovar_time);
		if(time() > $ovar_time){
			die;
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'投票结束')));
		/*
		$ip = getIp();
		$is_ip = M('school_information_masssage')->where(array('ip' => $ip))->find();
		if($is_ip){
			die;
		}
		*/
		$user_id = $_POST['user_id'];
		$s_id = $_POST['s_id'];
		$is_tou = M('school_information_masssage')->where(array('user_id' => $user_id))->find();
		/*
		if(!empty($is_tou)){
			exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'您已经投过票了')));
		}
		*/
		if(isset($_COOKIE['is_toupiao']) || isset($_SESSION['is_toupiao'])){
			exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'您已经投过票了')));
			$_SESSION['is_toupiao'] = $s_id;
		}else{
			$_COOKIE['is_toupiao'] = $s_id;
			$_SESSION['is_toupiao'] = $s_id;
		}
		
		$data = array(
			'user_id' => $user_id,
			's_id' => $s_id,
			'create_time' => time(),
			'num' => 1,
			'ip' => getIp(),
		);
		$res = M('school_information_masssage')->add($data);
		$school_information = M('school_information')->field('s_num')->where(array('s_id' => $s_id))->find();
		$school_information['s_num'] += 1;
		M('school_information')->where(array('s_id' => $s_id))->update($school_information);
		
		if($res){
			exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'投票成功','s_num' => $school_information['s_num'])));
		}else{
			exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'数据有误')));
		}
	}
	
	//退押金消息通知
	private function _send_message_tuiyajin(){
		$order_id = $_GET['order_id'];
		$t_price = $_GET['t_price'];
		$order = M('order')->where(array('order_id' => $order_id))->find();
		$kefu_mobile = '1854500004541';  //张鹏
		if($order['deposit_pay'] == 2){  //押金已退的
			include_once BasePath.DS.'plugins/ronglian/SendTemplateSMS.php';
			$phone = trim($order['mobile']);
			sendTemplateSMS($phone,array($order['safe_name'],date('Y-m-d H:i:s',$order['start_time']),$t_price,$kefu_mobile),181357);
		}
	}
	
	private function _test(){
		$res = M('school_information_masssage')
				->field('__AFFIX__school_information.s_name,__AFFIX__school_information_masssage.*')
				->join('left __AFFIX__school_information','__AFFIX__school_information.s_id = __AFFIX__school_information_masssage.s_id')
				->where('__AFFIX__school_information_masssage.ip != ""')->select();
		$data = array();
		$data2 = array();
		$data3 = array();
		$data4 = array();
		$arr1 = array();
		$arr = array();
		foreach($res as $key => $val){
			if(isset($data[$val['ip']])){
				$data[$val['ip']]++; 
			}else{
				$data2[$val['ip']]['s_name'] = $val['s_name'];
				$data[$val['ip']] = 1;
			}
			$data3[$val['s_name']] = $val['s_name'];
			$data4[$val['s_name']] .= $val[''];
		}
		
		arsort($data);
		foreach($data as $key => $val){
		//	echo '班级'.$data2[$key]['s_name'].'|IP:'.$key.',票'.$val."\n";
		//	echo '班级'.$data2[$key]['s_name']."\n";//.'|IP:'.$key.',票'.$val."\n";
		//	echo $key."\n";
			echo $val."\n";
		//	echo '班级'.$data2[$key]['s_name']."\n";//.'|IP:'.$key.',票'.$val."\n";
		}
		
	//	var_dump($data);die;
		foreach($data3 as $key => $val){
		//	echo $val."\n";
		}
		/*
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
		*/
	}
	
	private function _mishitaotuo(){
		$user_id = $_POST['user_id'];
		$num = $_POST['num'];
		if($num > 0 && $user_id > 0){
			$mishi = M('mishitaotuo')->where(array('user_id' => $user_id))->find();
			if(!empty($mishi)){
				if($mishi['num'] > $num){
					exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'分数不是最高值')));
				}
				if($num > $mishi['num']){
					$res = M('mishitaotuo')->where(array('user_id' => $user_id))->update(array('update_time'=>time(),'num' => $num));
				}
			}else{
				$data = array(
					'user_id' => $user_id,
					'num' => $num,
					'create_time' => time(),
					'update_time' => time(),
					'ip' => getIp(),
				);
				$res = M('mishitaotuo')->add($data);
			}
			if($res){
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'存储成功')));
			}else{
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'存储失败')));
			}
		}
	}
	
	//用户清单图片更新
	private function _yonghuqingdantupian(){
		$x_id = intval($_POST['x_id']);
		if($x_id > 0){ 
			$data['image'] = $_POST['image'];
			$res = M('xiaofeiqingdan')->where(array('x_id' => $x_id))->update($data);
			if($res){
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'签名成功')));
			}else{
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'签名失败')));
			}
		}
	}
	
	private function _cunchu(){
		if($_POST){
			$data = $_POST['datas'];
			$add_data = array();
			foreach($data as $key => $val){
				$d['store_id'] = $val['store_id'];
				$d['store_num'] = $val['store_num'];
				$d['create_time'] = time();
				$add_data[] = $d;
			}
			$s_time = strtotime(date('Y-m-d 00:00:00'));
			$e_time = strtotime(date('Y-m-d 23:59:59'));
			$bool = M('store_rand_num')->where('create_time >'.$s_time.' and create_time < '.$e_time)->find();
			if($bool){
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'已抽取')));
			}
			$res = M('store_rand_num')->insert_all($add_data);
			if($res){
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'插入成功')));
			}else{
				exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'插入失败')));
			}
		}
	}
	
	//判断酒水兑换码
	private function _get_jiushui(){
		if($_POST){
			$order_no = $_POST['order_no'];
			$d_code = $_POST['d_code'];
			$duihuanma = M('duihuanma')->where(array('d_code' => $d_code,'is_use' => 0 , 'is_del' => 0))->find();
			if(!empty($duihuanma)){
				exit($this->callback(200,self::SUCC,$duihuanma));
			}
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'无数据')));
	}
	
	//使用掉
	private function _use_jiushui(){
		if($_POST){
			$order_id = $_POST['order_id'];
			$d_code = $_POST['d_code'];
			$duihuanma = M('duihuanma')->where(array('d_code' => $d_code,'is_use' => 0 , 'is_del' => 0))->find();
			$order = M('order')->where(array('order_id' => $order_id))->find();
			if(!empty($duihuanma)){
				$update = array(
					'is_use' => 1,
					'update_time' => time(),
					'order_id' => $order['order_id'],
					'user_id' => $order['user_id'],
				);
				$duihuanma = M('duihuanma')->where(array('d_code' => $d_code,'is_use' => 0 , 'is_del' => 0))->update($update);
				exit($this->callback(200,self::SUCC,array('code'=>'1','msg'=>'成功')));
			}
		}
		exit($this->callback(200,self::SUCC,array('code'=>'-1','msg'=>'无数据')));
	}
	
	//首页获取店铺列表
	private function _get_index_store_list(){
	//	exit($this->callback(-1,self::SUCC,'错误'));  //返回错误信息
		$city = '';
		$shi = '';
		if(!empty($_POST['city'])){
			$city = explode('&nbsp',$_POST['city']);
			$sheng = $city[0];
			if(isset($city[1])){
				$shi = $city[1];
			}
		}
		
		
		$keyword = $_POST['keyword'];
		$start_time = strtotime(str_replace('&nbsp',' ',$_POST['start_time']));
		$end_time = strtotime(str_replace('&nbsp',' ',$_POST['end_time']));
		if($start_time >= $end_time){
			exit($this->callback(-1,self::SUCC,'时间选择不正确'));
		}
		$data = array();
		$city_data = array();
		$keyword_data = array();
		$$store_list = array();
		if(!empty($sheng)){
			
			if(!empty($shi)){
				$city_data = M('store')->where(array('keyword' => 'like %'.$sheng.'%','__AFFIX__store.keyword' => 'like %'.$shi.'%'))->select(1);
			}else{
				$city_data = M('store')->where(array('keyword' => 'like %'.$sheng.'%'))->select();
			}
		}
		if(!empty($keyword)){
			$keyword_data = M('store')
							->where(array('keyword' => 'like %'.$keyword.'%'))
							->where(array('store_name' =>'like %'.$keyword.'%'),'or')
							->select();
		}
	//	var_dump($keyword_data);die;
		if(!empty($city_data)){
			foreach($city_data as $key => $val){
				$data[$val['store_id']] = $val;
			}
		}
		if(!empty($keyword_data)){
			foreach($keyword_data as $key => $val){
				$data[$val['store_id']] = $val;
			}
		}
		
		
		$where = array(
			'start_time' => '<='.$start_time,
			'end_time' => '>='.$end_time,
			'pay' => '1',  //已支付
		);
		$order = M('order')
				->where('(start_time <= '.$start_time . ' and end_time >= '.$end_time . ' and pay = "1")  or ( start_time = '. $start_time.' and pay = "1" ) or ( end_time = '.$end_time.' and pay = "1" )')
				->find();
		
		$orders = array();
		if(!empty($order)){
			foreach($order as $key => $val){
			//	$orders[$val['store_id']] = $val;
				if(isset($data[$val['store_id']])){
					unset($data[$val['store_id']]);
				}
			}
		}
		
		if(empty($data)){
			exit($this->callback(-1,self::SUCC,'没有查询到店铺'));
		}else{
			foreach( $data as $key => $val){
				$store_list[] = $val;
			}
		}
	//	$store_list = $data;
		$week = date('w');
		if($week == 0){
			$week = 7;
		}
		
		if(!empty($store_list)){
			foreach($store_list as $key => $val){
				if(!empty($val['store_label'])){
					$store_list[$key]['store_label'] = explode('|',$val['store_label']);
				}
				$where = array(
					'store_id' => $val['store_id'],  //店铺id
					'label' => 1,
					'update_time' => 0,
				);
				$week_price = M('goods_week_price')->where($where)->find();
				if(!empty($week_price)){
					$store_list[$key]['price'] = $week_price['week'.$week];
				}else{
					$store_list[$key]['price'] = $val['price'];
				}
				if(!empty($val['store_imgs'])){
					$store_list[$key]['store_imgs'] = explode(',',$val['store_imgs']);
					foreach($store_list[$key]['store_imgs'] as $k => $v){
						$store_list[$key]['store_imgs'][$k] = get_img($v,'store');
					}
					$store_list[$key]['image'] = $store_list[$key]['store_imgs'][0];
				}
				
				
			}
			exit($this->callback(200,self::SUCC,$store_list));
		}
	}
}

new run();

?>