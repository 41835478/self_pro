<?php
if(!defined('PROJECT_NAME')) die('project empty');
class loginControl extends control{
	private $m;
	public function __construct(){
		$this->m = M('setting');
	}
	public function index(){
		$this->login();
	}
	//登录
	public function login(){
		//读取语言
		$language = read_language('login');
		if(isset($_SESSION['user_state']) && $_SESSION['user_state'] == true){
			header('Location:index.php?act=user&op=index');
		}
		
		$setting = get_setting();
		if($setting['is_login'] != 1){
			$error = '网站禁止登陆，请联系客服';
			show_message($error);
		}
		
		if(!empty($_POST)){
			if((time() - de_key($_POST['key'],KEY)) > $setting['login_time']){
				$error = '登录超时';
				show_message($error);
			}
			if(!$this->is_captcha($setting['is_captcha'])){
				$error = '验证码不正确';
				show_message($error);
			}
			//验证帐号密码
			if($this->bool_login()){
				header('Location:index.php?act=user&op=index');
			}
		}
		
		//隐藏登录加密串
		$key = en_key(time(),KEY);
		self::output('key', $key );
		self::output('is_captcha', $setting['is_captcha'] );
		self::output( 'login' , $language );
		self::display('login_index');
	}
	//登出
	public function logout(){
		unset($_SESSION['user_id']);
		unset($_SESSION['user_state']);
		unset($_SESSION['user_name']);
		unset($_SESSION['user_time']);
		unset($_SESSION['user_ip']);
		header('Location:index.php?act=login');
	}
	//生成验证码
	public function captcha(){
		$captcha = new captcha();  //实例化一个对象
		$captcha->doimg();  
		$_SESSION['captcha'] = $captcha->getCode();
	}
	
	//判断验证码
	public function is_captcha($is_captcha){
		if($is_captcha == 2){
			return true;
		}
		$captcha = strtolower($_POST['captcha']);
		if($captcha == $_SESSION['captcha']){
			return true;
		}
		return false;
	}
	//用户密码验证
	public function bool_login(){
		$username = $_POST['username'];
		$password = md5(sha1($_POST['password'].SECRET_KEY));
		$user = $this->m->table('user')->where(array('user_password'=>$password,'user_name'=>$username))->find();
		
		//登录判断暂时先这样写
		if( $username == $user['user_name'] && $password == $user['user_password'] ){
			if($user['user_state'] != '1'){
				$error = '禁止登陆，请联系客服';
				show_message($error);
			}
			$_SESSION['user_id'] 	= $user['user_id'];
			$_SESSION['user_state'] = true;
			$_SESSION['user_name']  = $username;
			$_SESSION['user_time']  = time();
			$_SESSION['user_ip']    = getIp();
			
			$update_data = array();
			if(!empty($user['login_type'] )){
				$user['login_type'] = explode(',',$user['login_type']);
				if(count($user['login_type']) >= 30){
					unset($user['login_type'][29]);
				}
				array_unshift($user['login_type'],'PC');
				$user['login_type'] = implode(',',$user['login_type']);
			}
			$update_data['login_type'] = $user['login_type'];
			if(!empty($user['login_ip'] )){
				$user['login_ip'] = explode(',',$user['login_ip']);
				if(count($user['login_ip']) >= 30){
					unset($user['login_ip'][29]);
				}
				array_unshift($user['login_ip'],getIp());
				$user['login_ip'] = implode(',',$user['login_ip']);
			}
			$update_data['login_ip'] = $user['login_ip'];
			if(!empty($user['login_time'] )){
				$user['login_time'] = explode(',',$user['login_time']);
				if(count($user['login_time']) >= 30){
					unset($user['login_time'][29]);
				}
				array_unshift($user['login_time'],time());
				$user['login_time'] = implode(',',$user['login_time']);
			}
			$update_data['login_time'] = $user['login_time'];
			$this->m->table('user')->where(array('user_id'=>$user['user_id']))->update($update_data);
			
			return true;
		}
		$error = '用户名或密码不正确';
		show_message($error);
	}
	
	public function login2(){
		
		//读取语言
		$language = read_language('login');
		
		if(isset($_SESSION['user_state']) && $_SESSION['user_state'] == true){
			header('Location:index.php?act=user&op=index');
		}
		
		$setting = get_setting();
		if($setting['is_login'] != 1){
			$error = '网站禁止登陆，请联系客服';
			show_message($error);
		}
		
		if(!empty($_POST)){
			
			if((time() - de_key($_POST['key'],KEY)) > $setting['login_time']){
				$error = '登录超时';
				show_message($error);
			}
		
			if(!$this->is_captcha($setting['is_captcha'])){
				$error = '验证码不正确';
				show_message($error);
			}
			//验证帐号密码
			if($this->bool_login2()){
				header('Location:index.php?act=baoxiao&op=baoxiao_reg');
			}
		}
		
		//隐藏登录加密串
		$key = en_key(time(),KEY);
		self::output('key', $key );	
		self::output('is_captcha', $setting['is_captcha'] );
	
		self::output( 'login' , $language );
		self::display('login_index2');
	}
	
	//用户密码验证2
	public function bool_login2(){
		$username = $_POST['username'];
	//	$password = md5(sha1($_POST['password'].SECRET_KEY));
		$password = md5($_POST['password'].KEY);
		$user = $this->m->table('admin')->where(array('password'=>$password,'username'=>$username))->find();
		
		//登录判断暂时先这样写
	//	var_dump($password);
	//	var_dump($user);die;
		if( $username == $user['username'] && $password == $user['password'] && $user['admin_type'] == 3){
			if($user['admin_state'] == '3'){
				$error = '禁止登陆，请联系客服';
				show_message($error);
			}
			$_SESSION['user_id'] 	= $user['admin_id'];
			$_SESSION['admin_state'] = true;
			$_SESSION['user_name']  = $username;
			$_SESSION['user_time']  = time();
			$_SESSION['user_ip']    = getIp();
			/*
			$update_data = array();
			if(!empty($user['login_type'] )){
				$user['login_type'] = explode(',',$user['login_type']);
				if(count($user['login_type']) >= 30){
					unset($user['login_type'][29]);
				}
				array_unshift($user['login_type'],'PC');
				$user['login_type'] = implode(',',$user['login_type']);
			}
			$update_data['login_type'] = $user['login_type'];
			if(!empty($user['login_ip'] )){
				$user['login_ip'] = explode(',',$user['login_ip']);
				if(count($user['login_ip']) >= 30){
					unset($user['login_ip'][29]);
				}
				array_unshift($user['login_ip'],getIp());
				$user['login_ip'] = implode(',',$user['login_ip']);
			}
			$update_data['login_ip'] = $user['login_ip'];
			if(!empty($user['login_time'] )){
				$user['login_time'] = explode(',',$user['login_time']);
				if(count($user['login_time']) >= 30){
					unset($user['login_time'][29]);
				}
				array_unshift($user['login_time'],time());
				$user['login_time'] = implode(',',$user['login_time']);
			}
			$update_data['login_time'] = $user['login_time'];
			$this->m->table('admin')->where(array('user_id'=>$user['user_id']))->update($update_data);
			*/
			return true;
		}
		$error = '用户名或密码不正确';
		show_message($error,'html','-1');
	}
}
?>