<?php
if(!defined('PROJECT_NAME')) die('project empty');
class indexControl extends systemControl{
	
	public function index(){
		$data = array();
		$data['mysql_v']  	= @mysql_get_server_info();
		$data['day7'] 			= date('Y-m-d',time()-3600*24*7);
		$data['day0'] 			= date('Y-m-d',time());
		$data['current_time'] 	= date('Y-m-d H:i:s',time());
		$data['system'] 		= PHP_OS;
		$data['php_v'] 			= PHP_VERSION;
	//	$data['cpu_num'] 		= $_SERVER['PROCESSOR_IDENTIFIER'];
		$data['url'] 			= $_SERVER['HTTP_HOST'];
		$data['language']    	= $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		$data['php_run_state'] 	= php_sapi_name();
		
		$data['web_port']  		= $_SERVER['SERVER_PORT'];
		$data['gd']  			= function_exists('gd_info')?'支持':'不支持';
		$day7 = strtotime(date('Y-m-d',time()-3600*24*7)); //一个礼拜前的时间
		//新进用户数
		$new_user_num = M('user')->where(array('add_time'=>'>'.$day7))->count();
		//用户数
		$all_user_num = M('user')->count();
		//商品数
		$goods_where = array(
			'is_show'  => 1,
			'goods_type'  => 2,
		//	'end_time' => '>'.time(),
		);
		$all_goods = M('goods')
					->where(array('is_show' =>1,'end_time' => '>'.time()))
				//	->where(array('end_time' => '0'),'OR')
					->count();
		//商铺数，
		$store_where = array(
			'is_open' => 1,
		);
		$all_store = M('store')->where($store_where)->count();
		$data['new_user_num'] = $new_user_num;
		$data['all_user_num'] = $all_user_num;
		$data['all_goods'] = $all_goods;
		$data['all_store'] = $all_store;
	//	var_dump($new_user_num);die;
		self::output("data",$data);
		
		self::display("index");
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
}
?>