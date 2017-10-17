
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
		header("Access-Control-Allow-Origin:*");
		header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELET, OPTIONS");
		header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");
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
	
	private function _get_service_list(){
		$game_name = $_POST['game_name'];
		if($game_name == 'shouhu'){
			$services = M('services')
					->where(array(
						'is_del' => 0,
						'is_open' => 1,
					))
					->select();
			if(!empty($services)){
				exit($this->callback($services,self::SUCC,'成功'));	
			}
		}
		exit($this->callback('','-1','失败'));	
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
	
	//首页数据
	private function _home(){
		$comm_id = $_POST['comm_id'];
		$data = array();
		//获取广告
		$adv = M('adv',true)->get_adv();
		$data['adv'] = array();
		if(!empty($adv)){
			$data['adv'] = $adv;
		}
		//获取导航
		$data['nav'] = array();
		$nav = M('nav',true)->get_nav();
		if(!empty($nav)){
			$data['nav'] = $nav;
		}
		//获取社长
		$data['president'] = array();
		$president = M('president',true)->get_president();
		if(!empty($president)){
			$data['president'] = $president;
		}
		
		//精品资源
		$data['boutique'] = array();
		$boutique = M('goods',true)->get_boutique();
		if(!empty($boutique)){
			$data['boutique'] = $boutique;
		}
		exit($this->callback($data,'1','成功'));
	}
	
	//提交社区接口
	private function _commit_community(){
		$data = array();
		
		$data['name'] 	= $_POST['name'];
		$data['type'] 	= $_POST['type'];
		$data['address'] = $_POST['address'];
		$data['adcode']  = $_POST['adcode'];
		$data['citycode'] = $_POST['citycode'];
		$data['cityname'] = $_POST['cityname'];
		$data['pname'] 	= $_POST['pname'];
		$data['adname'] = $_POST['adname'];
		$data['posx'] = $_POST['posx'];
		$data['posy'] = $_POST['posy'];
		$data['s_type'] = $_POST['s_type'];
		$data['pca'] = $_POST['pname'].$_POST['cityname'].$_POST['adname'];
		
		$community = M('community')->where(array('name' => $data['name']))->find();
		if(!empty($community)){
			exit($this->callback(array('id' => $community['id']),'-2','已存在的社区'));
		}
		
		$data['c_type'] = '1';
		$data['create_time'] = time();
		$data['update_time'] = time();
		$res = M('community')->add($data);
		
		$this->add_area();
		
		if($res){
			exit($this->callback(array( 'id' => $res ,'code' => $res),'1','添加成功'));
		}else{
			exit($this->callback('','-1','添加失败'));
		}
	}
	
	//查询社区
	private function _search_community(){
		$value = $_POST['value'];
		if(!empty($value)){
			$community = M('community')->where(array('name' => 'like %'.$value.'%'))->find();
			if($community){
				exit($this->callback($community , '1' , '成功'));
			}
		}
	}
	
	//添加省市县
	private function add_area(){
		$data = array();
		$data['name'] = $_POST['pname'];
		$is = M('area')->where($data)->where(array('is_del' => '0'))->find();
		$p_id = 0;
		$pp_id = 0;
		if(empty($is)){
			$data['create_time'] = time();
			$id = M('area')->add($data);
			$p_id = $id;
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
			);
			$log['other'] =  $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了省级别,id是'.$id;
			M('admin_log')->add($log);
		}
		$data = array();
		$data['name'] = $_POST['cityname'];
		$is = M('area')->where($data)->where(array('is_del' => '0'))->find();
		if(empty($is)){
			$data['create_time'] = time();
			$data['p_id'] = $p_id;
			$id = M('area')->add($data);
			$pp_id = $id;
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
			);
			$log['other'] =  $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了市级别,id是'.$id;
			M('admin_log')->add($log);
		}
		$data = array();
		$data['name'] = $_POST['adname'];
		$is = M('area')->where($data)->where(array('is_del' => '0'))->find();
		if(empty($is)){
			$data['create_time'] = time();
			if($pp_id == 0){  //如果市级没有直接用省级别的
				$data['p_id'] = $p_id;
			}else{
				$data['p_id'] = $pp_id;
			}
			
			$id = M('area')->add($data);
			
			$log = array(
				'admin_id' => $_SESSION['admin']['id'],
				'create_time' => time(),
				'ip' => getIp(),
			);
			$log['other'] =  $_SESSION['admin']['username'].'在'.date('Y-m-d H:i:s').'时添加了县级别,id是'.$id;
			M('admin_log')->add($log);
		}
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
	
	private function _send_message(){
		/*
		$code = rand(1000,9999);
		$_SESSION['phone_code'] = $code;
		var_dump($code);die;
		*/
		$phone = $_POST['phone'];
	//	$phone = '18721365391';
		$time_jiange = 60;   //发送时间间隔
		$send_num = 5; //限制发送5条，短信平台也只能发送10条
		if(preg_match("/^1[34578]{1}\d{9}$/",$phone)){
			$time = time() - $time_jiange;
			$is = false;
			//限制5条
			$count = M('phone_send_message')->where(array('phone' => $phone , 'create_time' => '>'.strtotime(date('Y-m-d 00:00:00'))))->count();
			if($count >= $send_num){
				exit($this->callback('','-1','超出发送限制，每天只能发送'.$send_num.'条'));
			}
			//频繁发送
			if(isset($_SESSION['phone_send_message'])){
				$is = $_SESSION['phone_send_message'];
			}else{
				$is = M('phone_send_message')->where(array('phone' => $phone,'create_time' => '>'.$time))->find();
			}
			if($is){
				$d_time = $time_jiange - (time() - $is['create_time']);
				exit($this->callback(array('d_time' => $d_time),'-1','请勿频繁发送'));
				$_SESSION['phone_send_message'] = $is;
			}
			$name = 'short_message';
			$data = '';
			$system_conf = M('config')->where(array('name' => $name))->find();
			if(!empty($system_conf)){
				$data = unserialize($system_conf['value']);
				$data['id'] = $system_conf['id'];
				switch($data['type']){
					case 'cl':  //创蓝短信
						include_once BasePath.DS.PLUGINS.DS.'/cldx/ChuanglanSmsHelper/ChuanglanSmsApi.php';
						$clapi  = new ChuanglanSmsApi();
						$code = rand(1000,9999);
						$_SESSION['phone_code'] = $code;
						$str = '您的验证码是：'.$code;
						$result = $clapi->sendSMS($phone, $str);
						M('phone_send_message')->add(array('phone' => $phone , 'create_time' => time()));
						if(!is_null(json_decode($result))){
							$output=json_decode($result,true);
							if(isset($output['code'])  && $output['code']=='0'){
								exit($this->callback('','1',''));
							}else{
								exit($this->callback('','-1','短信发送失败！'));
							}
						}else{
								exit($this->callback('','-1','短信发送失败！'));
						}
						die;
					break;
				}
			}
		}else{  
			echo "手机号填写错误";  
		}  
	}
	
	//手机号注册
	private function _phone_register(){
		$phone 		= $_POST['phone'];
		$password 	= $_POST['password'];
		$phone_code = $_POST['phone_code'];
		$name 		= $_POST['name'];
		
		if(empty($phone_code)){
			exit($this->callback('','-1','请填写验证码'));
		}
		if(!isset($_SESSION['phone_code'])){
			exit($this->callback('','-1','短信验证码错误1'));
		}
		if($phone_code != $_SESSION['phone_code']){
			exit($this->callback('','-1','短信验证码错误2'));
		}
		
		if(!preg_match("/^1[34578]{1}\d{9}$/",$phone)){
			exit($this->callback('','-1','手机号填写错误'));
		}
		//是否存在
		$is = M('user')
			  ->where(array('phone' => $phone))
			  ->find();
		if($is){
			exit($this->callback('','-1','已经注册'));
		}
		if(empty($name)){
			exit($this->callback('','-1','请填写昵称'));
		}
		if(strlen($name) > 60){
			exit($this->callback('','-1','昵称太长了'));
		}
		if(empty($password)){
			exit($this->callback('','-1','请填写密码'));
		}
		if(strlen($password) < 6 || strlen($password) > 16){
			exit($this->callback('','-1','密码请使用6-16位字母或数字'));
		}
		
		$recomm_code = substr(md5(microtime(true)), 0, 6);
		$password = MD5(MD5($password.KEY).KEY);
		$role_id = M('role')->where(array('is_del' => '0' , 'is_default' => '2'))->find();
		if(!empty($role_id)){
			$role_id = $role_id['id'] ;
		}else{
			$role_id = '0';
		}
		$user = array(
			'phone' => $phone,
			'password' => $password,
			'name' => $name,
			'recomm_code' => $recomm_code,
			'create_time' => time(),
			'update_time' => time(),
			'role_id' => $role_id,
		);
		$id = M('user')->add($user);
		if($id){
			$user = M('user')->where(array('id' => $id))->find();
			$_SESSION['user'] = $user;
			unset($_SESSION['phone_code']);
			exit($this->callback($user,'1','注册成功'));
		}else{
			exit($this->callback('','-1','注册失败'));
		}
	}
	
	//微信附加注册
	private function _phone_register2(){
		$phone 		= $_POST['phone'];
		$password 	= $_POST['password'];
		$phone_code = $_POST['phone_code'];
		$u_id 		= $_POST['u_id'];
		
		if(empty($phone_code)){
			exit($this->callback('','-1','请填写验证码'));
		}
		if(!isset($_SESSION['phone_code'])){
			exit($this->callback('','-1','短信验证码错误1'));
		}
		if($phone_code != $_SESSION['phone_code']){
			exit($this->callback('','-1','短信验证码错误2'));
		}
		
		if(!preg_match("/^1[34578]{1}\d{9}$/",$phone)){
			exit($this->callback('','-1','手机号填写错误'));
		}
		//是否存在
		$is_user = M('user')
			  ->where(array('phone' => $phone))
			  ->find();
		if(!empty($is_user) && !empty($is_user['openid'])){
			exit($this->callback('','-1','已经注册'));
		}
		if(empty($password)){
			exit($this->callback('','-1','请填写密码'));
		}
		if(strlen($password) < 6 || strlen($password) > 16){
			exit($this->callback('','-1','密码请使用6-16位字母或数字'));
		}
		
		$role_id = M('role')->where(array('is_del' => '0' , 'is_default' => '2'))->find();
		if(!empty($role_id)){
			$role_id = $role_id['id'] ;
		}else{
			$role_id = '0';
		}
		$recomm_code = substr(md5(microtime(true)), 0, 6);
		if(!empty($is_user) && empty($is_user['openid'])){
			$password = MD5(MD5($password.KEY).KEY);
			$open = M('user')->where(array('id' => $u_id))->find();
			$user = array(
				'openid' 	  => $open['openid'],
				'password'    => $password,
				'image' 	  => $open['image'],
				'u_sex' 	  => $open['u_sex'],
				'province' 	  => $open['province'],
				'city' 	  	  => $open['city'],
				'remark' 	  => $open['remark'],
				'groupid' 	  => $open['groupid'],
			);
			$is_update = M('user')->where(array('phone' => $phone))->update($user);
			$open = M('user')->where(array('id' => $u_id))->del();
		}else if(empty($is_user)){
			$password = MD5(MD5($password.KEY).KEY);
			$open = M('user')->where(array('id' => $u_id))->find();
			$user = array(
				'phone' 	  => $phone,
				'password'    => $password,
				'recomm_code' => $recomm_code,
				'create_time' => time(),
				'update_time' => time(),
				'role_id' 		  => $role_id,
			);
			$is_update = M('user')->where(array('id' => $u_id))->update($user);
		}
		
		if($is_update){
			$user = M('user')->where(array('phone' => $phone))->find();
			$user['sign'] = en_key($user['phone'].$user['password'].date('YmdHis'),KEY);
			M('user')->where(array('phone' => $user['phone']))->update(array('sign' => $user['sign']));
			$_SESSION['user'] = $user;
			unset($_SESSION['phone_code']);
			exit($this->callback($user,'1','注册成功'));
		}else{
			exit($this->callback('','-1','注册失败'));
		}
	}
	
	//密码重置
	private function _user_back(){
		$phone 		= $_POST['phone'];
		$password 		= $_POST['password'];
		$phone_code = $_POST['phone_code'];
		
		if(empty($phone_code)){
			exit($this->callback('','-1','请填写验证码'));
		}
		if(!isset($_SESSION['phone_code'])){
			exit($this->callback('','-1','短信验证码错误'));
		}
		if($phone_code != $_SESSION['phone_code']){
			exit($this->callback('','-1','短信验证码错误'));
		}
		
		if(!preg_match("/^1[34578]{1}\d{9}$/",$phone)){
			exit($this->callback('','-1','手机号填写错误'));
		}
		//是否存在
		$is = M('user')
			  ->where(array('phone' => $phone))
			  ->find();
		if(!$is){
			exit($this->callback('','-1','用户不存在'));
		}
		if(empty($password)){
			exit($this->callback('','-1','请填写密码'));
		}
		if(strlen($password) < 6 || strlen($password) > 16){
			exit($this->callback('','-1','密码请使用6-16位字母或数字'));
		}
		
		$password = MD5(MD5($password.KEY).KEY);
		$data = array(
			'password' => $password,
			'update_time' => time(),
		);
		$res = M('user')->where(array('phone' => $phone))->update($data);
		if($res){
			exit($this->callback('','1','修改密码成功'));
		}else{
			exit($this->callback('','-1','修改密码失败'));
		}
		
	}
	
	private function _get_label(){
		
		$data1 = array();
		$where1 = array(
			'pid' => '0',
			'is_del' => '0',
		);
		$where2 = array(
			'pid' => '>0',
			'is_del' => '0',
		);
		
		$list1 = M('user_label')
				->field('id,name,pid')
				->where($where1)
				->select();
		$list2 = M('user_label')
				->field('id,name,pid')
				->where($where2)
				->select();
		if(!empty($list2)){
			$d = array();
			foreach($list2 as $key => $val){
				$d[$val['pid']][] = $val;
			}
		}
		
		if(!empty($list1)){
			foreach($list1 as $key => $val){
				$da = $val;
				if(isset($d[$val['id']])){
					$da['child'] = $d[$val['id']];
				}
				$data1[] = $da;
			}
		}
		if(!empty($data1)){
			exit($this->callback($data1,'1','数据返回'));
		}
		exit($this->callback('','-1','没有数据'));
	}
	
	//设置标签
	private function _set_label(){
		$u_id = $_POST['u_id'];
		$sign = $_POST['sign'];
		$labels = $_POST['labels'];
		$label1 = $_POST['label1'];
		$label2 = $_POST['label2'];
		
		$this->auth(); //验证
		$data = array('u_label' => $labels);
		$label_str = '';
		if(!empty($label1)){
			$label_str .= $label1;
		}
		if(!empty($label2)){
			$label_str .= ','.$label2;
		}
		$data['u_label2'] = $label_str;
		$res = M('user')->where(array('id' => $u_id ))->update($data);
		if($res){
			exit($this->callback('','1','修改成功'));
		}else{
			exit($this->callback('','-1','修改失败'));
		}
	}
	
	//发布资源
	private function _publishing_resources(){
		$u_id 	= $_POST['u_id'];	//用户id
		$sign 	= $_POST['sign'];	//用户sign
		$name 	= $_POST['name'];	//资源标题
		$price 	= $_POST['price'];	//资源价格
		$type 	= $_POST['type'];	//资源类型
		$comm_id 	= $_POST['comm_id'];	//社区id
		$image 		= $_POST['image'];	//组图
		$content 	= $_POST['content'];	//内容
		$image_str 	= array();	
		$this->auth();	//验证
		
		if($u_id > 0){
			$user = M('user')->where(array('id' => $u_id))->find();
			if(empty($user)){
				exit($this->callback('','-1','没有此用户'));
			}
			if($user['role_id'] == 0){
				exit($this->callback('','-1','没有此权限'));
			}else{
				$role = M('role')->where(array('id' => $user['role_id']))->find();
				if(empty($role) || $role['is_goods'] != 1){
					exit($this->callback('','-1','没有此权限'));
				}
			}
		}else{
			exit($this->callback('','-1','用户id错误'));
		}
		$file = new FileUpload();
		$first_image = '';
		if(!empty($image)){
			foreach($image as $key => $val){
				if(empty($first_image)){
					$_POST['image'.$key] = $val;
					$first_image = $file->base64('image'.$key);
				}else{
					$_POST['image'.$key] = $val;
					$image_str[] = $file->base64('image'.$key);
				}
			}
		}
		if(!empty($image_str)){
			$image_str = implode(',',$image_str);
		}else{
			$image_str = '';
		}
		$data = array();
		$data['u_id'] 	= $u_id;
		$data['comm_id'] = $comm_id;
		$data['name'] 	= $name;
		$data['price'] 	= $price;
		$data['type'] 	= $type;
		$data['image'] 	= $first_image;
		$data['images'] 	= $image_str;
		$data['content'] 	= $content;
		$data['create_time'] 	= time();
		$data['update_time'] 	= time();
		$data['is_show'] 	= 1;
		$res = M('goods')->add($data);
		if($res){
			exit($this->callback('','1','添加资源成功'));
		}else{
			exit($this->callback('','-1','添加资源失败'));
		}
	}
	
	//用户上传照片
	private function _user_images(){
		$id = $_POST['u_id'];
		$this->auth();
		$data = array();
		$file = new FileUpload();
		$image_list = array();
		$images 		= $_POST['images'];	//组图
		if(!empty($images)){
			foreach($images as $key => $val){
				$_POST['image'.$key] = $val;
				$image_list[] = $file->base64('image'.$key);
			}
		}
		if(!empty($image_list)){
			$image_list = implode(',',$image_list);
			$data['images'] = $image_list;
			$res = M('user')->where(array('id' => $id))->update($data);
			if($res){
				exit($this->callback('','1','上传成功'));
			}else{
				exit($this->callback('','-1','上传失败'));
			}
		}
		exit($this->callback('','-1','未知错误'));
	}
	
	//登录
	private function _login(){
		$phone 		= $_POST['phone'];
		$password 		= $_POST['password'];
	//	$phone_code = $_POST['phone_code'];
		
	//	$phone = '18721365391';
	//	$password = '123456';
		/*
		if(empty($phone_code)){
			exit($this->callback('','-1','请填写验证码'));
		}
		/*
		if(!isset($_SESSION['phone_code'])){
			exit($this->callback('','-1','短信验证码错误'));
		}
		if($phone_code != $_SESSION['phone_code']){
			exit($this->callback('','-1','短信验证码错误'));
		}
		*/
		if(!preg_match("/^1[34578]{1}\d{9}$/",$phone)){
			exit($this->callback('','-1','手机号填写错误'));
		}
		
		//是否存在
		$user = M('user')
			  ->where(array('phone' => $phone , 'is_del' => '0'))
			  ->find();
			 
		if(!$user){
			exit($this->callback('','-1','用户不存在'));
		}
		if(empty($password)){
			exit($this->callback('','-1','请填写密码'));
		}
		$password = MD5(MD5($password.KEY).KEY);
		if($user['password'] != $password){
			exit($this->callback('','-1','密码错误'));
		}
		if($user['password'] == $password){
			
			$log = array(
				'u_id' => $user['id'],
				'ip' => get_Ip(),
				'create_time' => time(),
			);
			M('user_log')->add($log);
		//	unset($_SESSION['phone_code']);
			$user['time'] = date('YmdHis');
			$user['sign'] = en_key($user['phone'].$user['password'].$user['time'],KEY);
			M('user')->where(array('phone' => $phone , 'is_del' => '0'))->update(array('sign' => $user['sign']));
			if(!empty($user['images'])){
				$user['images'] = explode(',',$user['images']);
			}
			$_SESSION['user'] = $user;
			unset($user['password']);
			exit($this->callback($user,'1','登录成功'));
		}
		exit($this->callback('','-1','未知错误'));
	}
	
	//退出
	private function _logout(){
		$id = $_POST['u_id'];
		$this->auth();
		$is = M('user')->where(array('id' => $id))->update(array('sign' => ''));
		unset($_SESSION['user']['sign']);
		if($is){
			exit($this->callback('','1','登出成功'));
		}else{
			exit($this->callback('','-1','登出失败'));
		}
	}
	
	//获取用户信息
	private function _get_user_info(){
		$this->auth();
		$id = $_POST['u_id'];
		$user = M('user',true)->find($id);
		if($user){
			exit($this->callback($user,'1','获取成功'));
		}else{
			exit($this->callback('','-1','获取失败'));
		}
	}
	
	//获取社长信息
	private function _get_president(){
		$id = $_POST['id'];
		$u_id = $_POST['u_id'];
		$president = M('user',true);
		$data = $president->find($id);
		if(empty($u_id)){
			$data['is_guanzhu'] = '2';
		}else{
			$where = array(
				'p_id' => $id,
				'u_id' => $u_id,
			);
			$is_guanzhu = M('userAuser')->where($where)->find();
			if(!empty($is_guanzhu) && $is_guanzhu['type'] == 1){
				$data['is_guanzhu'] = '1';
			}else{
				$data['is_guanzhu'] = '2';
			}
		}
		
		//获取资源
		$goods = $president->get_goods($id);
		$data['goods'] = $goods;
		if($data){
			exit($this->callback($data,'1','获取成功'));
		}else{
			exit($this->callback('','-1','获取失败'));
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
	
	//个人信息修改
	public function _avater(){
		//验证
		$this->auth();
		$data = array();
		$id = $_POST['u_id'];
		if($id <= 0){
			exit($this->callback('','-1','用户id错误'));
		}
		
		if(isset($_POST['image']) && !empty($_POST['image'])){
			$image = new FileUpload();
			$data['image']  = $image->base64('image');
		}
		if(isset($_POST['name']) && !empty($_POST['name'])){
			$data['name'] = $_POST['name'];
		}
		if(isset($_POST['u_sex']) && !empty($_POST['u_sex'])){
			$data['u_sex'] = $_POST['u_sex'];
		}
		if(isset($_POST['u_desc']) && !empty($_POST['u_desc'])){
			$data['u_desc'] = $_POST['u_desc'];
		}
		if(!empty($data)){
			$res = M('user')->where(array('id' => $id))->update($data);
			if($res){
				exit($this->callback($data,'1','修改成功'));
			}else{
				exit($this->callback('','-1','修改失败'));
			}
		}else{
			exit($this->callback('','-1','访问错误'));
		}
	}
	
	//用户关注
	private function _follow(){
		$id = $_POST['u_id'];
		$p_id = $_POST['p_id'];
		$type = $_POST['type'];
		$this->auth();
		$type = $type == 1 ? '1' : '2';
		$data = array();
		$data['u_id'] = $id;
		$data['p_id'] = $p_id;
		$data['create_time'] = time();
		$data['type'] = $type;
		$where = array(
			'u_id' => $id,
			'p_id' => $p_id,
		);
		$is = M('userAuser')->where($where)->find();
		if($is){
			$res = M('userAuser')->where($where)->update(array('type' => $type));
		}else{
			$res = M('userAuser')->add($data);
		}
		if($res){
			if($type == '1'){
				exit($this->callback($data,'1','关注成功'));
			}else{
				exit($this->callback($data,'1','取消关注成功'));
			}
		}else{
			exit($this->callback('','-1','关注失败'));
		}
	}
	
	//获取资源
	private function _get_goods(){
		$id = intval($_POST['id']);
		$u_id = $_POST['u_id'];
		if($id > 0){
			$data = array();
			$goods = M('goods')->where(array('id' => $id))->find();
			$collection_num = M('goods_collection')->where(array('g_id' => $id , 'type' => '2'))->count();	//收藏
			$fabulous_num 	= M('goods_collection')->where(array('g_id' => $id , 'type' => '1'))->count();  //点赞
			$comment 		= M('goods_comment')->where(array('g_id' => $id ))->count();	//评论
			$comment_list 	= M('goods_comment')->where(array('g_id' => $id ))->select();
			if($u_id){ //	是否收藏
				$is_collection 	= M('goods_collection')->where(array('g_id' => $id , 'is_open' => '1' , 'type' => '2', 'u_id' => $u_id))->find();
				if($is_collection){
					$data['is_collection'] = '1';	//已收藏
				}else{	
					$data['is_collection'] = '2';	//未收藏
				}
				$is_guanzhu = M('userAuser')->where(array('u_id' => $u_id , 'is_open' => '1','is_del' => '0' ,'type' => '1', 'p_id' => $goods['u_id']))->find();
				if($is_guanzhu){
					$data['is_guanzhu'] = '1';		//已关注
				}else{
					$data['is_guanzhu'] = '2';		//未关注
				}
			}
			
			//获取用户信息
			if($goods['u_id'] > 0){
				$user = M('user')->where(array('id' => $goods['u_id']))->find();
				$data['user'] = $user;
			}
			
			
			
			if(!empty($goods)){
				$goods['create_time2'] = d_time($goods['create_time']);  //多长时间之前
				$goods['create_time'] = date('Y-m-d H:i:s',$goods['create_time']);
				if(!empty($goods['images'])){
					$goods['images'] = explode(',',$goods['images']);
				}
				
				$data['goods'] = $goods;
				$data['collection_num'] 	= $collection_num;
				$data['fabulous_num'] 		= $fabulous_num;
				$data['comment'] 		= $comment;
				$data['comment_list'] 	= $comment_list;
				exit($this->callback($data,'1','成功'));
			}
		}
		exit($this->callback('','-1','获取资源失败'));
	}
	
	//点赞和收藏
	private function _set_goods_collection(){
		$u_id = $_POST['u_id'];
		$g_id = $_POST['g_id'];
		$type = $_POST['type'];
		$is_open = $_POST['is_open'];
		$this->auth();
		$data = array();
		$data['u_id'] = $u_id;
		$data['g_id'] = $g_id;
		$data['type'] = $type;
		$where = $data;
		$is_goods_collection = M('goods_collection')->where($where)->find();
		$data['is_open'] = $is_open;
		$data['create_time'] = time();
		if($is_goods_collection){
			$res = M('goods_collection')->where($where)->update($data);
			$return_data = $res;
		}else{
			$res = M('goods_collection')->add($data);
			$return_data = M('goods_collection')->where(array('id' => $res))->find();
		}
		
		if($res){
			exit($this->callback($return_data,'1','成功'));
		}else{
			exit($this->callback('','-1','失败'));
		}
	}
	
	//获取社区全部资源活动信息
	private function _get_community_all_goods_helpinfo_activity(){
		$comm_id = intval($_POST['comm_id']);
		$s_id = 5;  //社长
		if($comm_id > 0){
			$community = M('community')->where(array('id' => $comm_id , 'is_del' => '0'))->find();
			$users = M('user')
					->field('id,c_id')
					->where(array('c_id' => $comm_id , 'is_del' => '0'))
					->select();
			$u_ids = array();
			
			if(!empty($users)){
				foreach($users as & $val){
					$u_ids[] = $val['id'];
				}
				$u_ids = implode(',',$u_ids);
			}
			if(!empty($community) && !empty($u_ids)){
				$data = array();
				$comm = M('community',true);
				$goods 	  = $comm->get_goods($u_ids);
				$helpinfo = $comm->get_helpinfo($u_ids);
				$activity = $comm->get_activity($u_ids);
				$data['community'] 		= $community;
				$data['goods'] 		= $goods;
				$data['helpinfo'] 	= $helpinfo;
				$data['activity'] 	= $activity;
				exit($this->callback($data,'1','成功'));
			}
		}
		exit($this->callback('','-1','访问错误'));
	}
	
	//用户变更社区
	private function _user_register_community(){
		$id = $_POST['u_id'];
		$comm_id = $_POST['comm_id'];
		$this->auth();
		$where = array(
			'u_id' => $id,
		);
		$update = array(
			'comm_id' => $comm_id,
		);
		$c_where = array(
			'is_del' => '0',
			'id' 	 => $comm_id,
		);
		//社区是否存在
		$community = M('community')->where($c_where)->find();
		if(!$community){
			exit($this->callback('','-1','此社区不存在'));
		}
		
		$res = M('user')->where($where)->update($update);
		
		//把资源的社区id也变掉
		$g_update = array(
			'comm_id' => $comm_id,
		);
		M('goods')->where(array('u_id' => $id))->update($g_update);
		
		if($res){
			exit($this->callback(array('comm_id' => $comm_id , 'name' => $community['name']),'1','变更成功，社区id是'.$comm_id));
		}else{
			exit($this->callback('','-1','变更失败'));
		}
	}
	
	//验证
	private function auth(){
		$id = $_POST['u_id'];
		$sign = $_POST['sign'];
		$debug = $_POST['debug '];
		$user = M('user')->where(array('id' => $id))->find();
		if(empty($user)){
			exit($this->callback('','-1','用户错误'));
		}
		if($sign != $user['sign']){
			if($debug == 'true'){
				exit($this->callback(array('sign ' => $sign ,'user_sign' => $user['sign']) , '-1' , 'sign值传输错误'));
			}
			exit($this->callback('','-1','sign值传输错误'));
		}
	}
	
	
}

new run();

?>