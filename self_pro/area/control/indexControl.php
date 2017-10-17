<?php
if(!defined('PROJECT_NAME')) die('project empty');
class indexControl extends sysControl{
	
	public function index(){
		$this->menu();  //设置左边菜单
		self::display("index");
	}
	
	private function menu(){
		$defaut = '?act=index&op=welcome';
		$menu = read_language('menu');
		$admin = $_SESSION['admin'];
		$admin_info = M('admin')->where(array('id' => $admin['id']))->find();
		foreach($menu['top'] as $key => $val){
			if(isset($val[1])){
				$s = '';
				foreach($val[1] as $k => $v){
					$s[] = $k.'="'.$v.'"';
				}
				$menu['top'][$key][1]= implode(' ',$s);
			}
			foreach($menu['left'][$key] as $kk => $vv){
				if(isset($vv[2])){
					$s = '';
					foreach($vv[2] as $kkk => $vvv){
						$s[] = $kkk.'="'.$vvv.'"';
					}
					$menu['left'][$key][$kk][2]= implode(' ',$s);
				}
			}
		}
		
		self::output("menu",$menu);
	}
	
	public function index_list(){
		self::display('index_list');
	}
	
	public function edit(){
		self::display('edit');
	}
	
	//导航页面
	public function nav(){
		self::display('nav');
	}
	
	public function all(){
		self::display();
	}
	public function news(){
		self::display();
	}
	public function webset(){
		$webset  = read_language('webset');
		$setting = M('setting')->where(array('name'=>'setting'))->find();
		$setting = unserialize($setting['value']);
		if($_FILES){
			$path = BasePath.DS.'uploads'.DS.'web_img'.DS;
			//删除
			if(isset($setting['logo'])){
				unlink($path.$setting['logo']);
			}
			$up_logo = new FileUpload();
			$up_logo->set('path',BasePath.DS.'uploads'.DS.'web_img');
			$up_logo->set('affix','logo_');
			$up_logo->upload('logo');
			$setting['logo'] = $up_logo->getFileName();
		}
		if($_POST){
			$setting['web_name']  = $_POST['web_name'];
			$setting['ICP'] 	  = $_POST['ICP'];
			$setting['web_phone'] = $_POST['web_phone'];
			$setting['web_email'] = $_POST['web_email'];
			$setting['web_open']  = $_POST['web_open'];
			$setting['reason']    = $_POST['reason'];
			$value = serialize($setting);
			$result = M('setting')->where(array('name'=>'setting'))->update(array('value'=>$value));
			if($result){
				show_message('修改成功','html','index.php?act=index&op=index');
			}else{
				show_message('修改失败','html','index.php?act=index&op=index');
			}
			//show_message($result);
		}
		self::output('webset',$webset);
		self::output('setting',$setting);
		self::display();
	}
	
	//欢迎页面，首页
	public function welcome(){
		$data = array();
		$data['mysql_v']  	= @mysql_get_server_info();
		$data['day7'] 			= date('Y-m-d',time()-3600*24*7);
		$data['day0'] 			= date('Y-m-d',time());
		$data['current_time'] 	= date('Y-m-d H:i:s',time());
		$data['system'] 		= PHP_OS;
		$data['php_v'] 			= PHP_VERSION;
	//	$data['cpu_num'] 		= $_SERVER['PROCESSOR_IDENTIFIER'];
		$data['ip'] 			= $_SERVER['SERVER_ADDR'];
		$data['server_name'] 	= $_SERVER['SERVER_NAME'];
		$data['server_software'] 	= $_SERVER['SERVER_SOFTWARE'];
		$data['root_dir'] 	= $_SERVER['DOCUMENT_ROOT'];
		$data['url'] 			= $_SERVER['HTTP_HOST'];
		$data['language']    	= $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		$data['php_run_state'] 	= php_sapi_name();
		
		$data['web_port']  		= $_SERVER['SERVER_PORT'];
		$data['gd']  			= function_exists('gd_info')?'支持':'不支持';
		$data['login']['login_num'] = M('admin_log')->where(array('u_id' => $_SESSION['area']['id'], 'admin_type' => 1 ))->count();
		$login 	= M('admin_log')->where(array( 'u_id' => $_SESSION['area']['id'] , 'admin_type' => 1 ))->limit(2)->order('id desc')->select();
		if(isset($login[1]) && !empty($login[1])){
			$data['login']['login_ip'] 	= $login[1]['ip'];
			$data['login']['login_time'] 	= date('Y-m-d H:i:s',$login[1]['create_time']);
		}
		
		self::output("data",$data);
		
		self::display();
	}
}
?>