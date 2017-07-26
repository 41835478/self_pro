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
		$setting = $this->m->where(array('name'=>'web_config'))->find();
		$setting = unserialize($setting['value']);
		if(!empty($_POST)){
			if((time() - de_key($_POST['key'],KEY)) > $setting['login_time']){
				$error = '登录超时';
				show_message($error,'html','-1');
			}
			//这个是验证码
			
			if(!$this->is_captcha($setting['is_captcha'])){
				$error = '验证码不正确';
				show_message($error,'html','-1');
			}
			
			//验证帐号密码
			if($this->bool_login()){
				header('Location:index.php?act=index&op=index');
			}
		}
		
		//隐藏登录加密串
		$key = en_key(time(),KEY);
		self::output('key', $key );
		self::output('is_captcha', $setting['is_captcha'] );
		self::output( 'login' , $language );
		self::display('login');
	}
	
	//登出
	public function logout(){
		unset($_SESSION['login_state']);
		unset($_SESSION['admin']);
		unset($_SESSION['admin_id']);
		unset($_SESSION['admin_logo']);
		unset($_SESSION['login_time']);
		unset($_SESSION['login_ip']);
		header('Location:index.php?act=login');
	}
	//生成验证码
	public function captcha(){
		$captcha = new captcha();  //实例化一个对象
		$captcha->doimg2();  
		$_SESSION['captcha'] = $captcha->getCode2();
	}
	
	//判断验证码
	public function is_captcha($is_captcha){
		if(!$is_captcha){
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
		$password = md5($_POST['password'].KEY);
		$admin = $this->m->table('admin')->where(array('username'=>$_POST['username'],'password'=>$password))->find();
		if($username == $admin['username'] && $password == $admin['password']){
			$logo_img = get_img($admin['admin_logo'],'admin');
			$_SESSION['admin_id'] 	 = $admin['admin_id'];
			$_SESSION['login_state'] = true;
			$_SESSION['login_state'] = 'admin';
			$_SESSION['admin_logo']  = !empty($logo_img)?$logo_img:'/public/imgs/admin_default.jpg';
			$_SESSION['admin']       = $username;
			$_SESSION['login_time']  = time();
			$_SESSION['login_ip']    = getIp();
			//写入登陆日志
			M('adminlog',true)->login_log();
			return true;
		}
		$error = '用户名或密码不正确';
		show_message($error,'html','-1');
	}
}
?>