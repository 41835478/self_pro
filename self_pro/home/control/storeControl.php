<?php
if(!defined('PROJECT_NAME')) die('project empty');
class storeControl extends user_storeControl{
	public function __construct(){
		//添加方法就行，这样可以控制顶部
		$is_header = array('index','register_store');
		if(in_array($_GET['op'] , $is_header)){
			self::setheader('header_store');
		}
	}
	
	
	
	//商家入驻
	public function register_store(){
		
		$config = get_setting();
		if($config['is_store'] != 1){
			show_message('本站已禁止商家入驻，请联系客服','html','-1');
		}
		$user_id = $_SESSION['user_id'];
		//如果没有注册
		if(!$this->is_register($user_id)){
			//提交审核
			$this->register($user_id); 
			self::display('store_register');
		}else{
			self::display('store_register');
		}
	}
	
	//申请入驻
	public function register($user_id){
		if($_POST){
			$data = array();
			
			$data['store_name'] = !empty($_POST['store_name'])?$_POST['store_name']:show_message('请输入商铺名称','html','-1');
			$data['true_name'] = !empty($_POST['true_name'])?$_POST['true_name']:show_message('请输入真实姓名','html','-1');
			$data['card_id'] = !empty($_POST['card_id'])?$_POST['card_id']:show_message('身份证号输入不正确','html','-1');
			if(strlen($data['card_id']) != 18){  //身份证号18位
				show_message('身份证号输入不正确','html','-1');
			}
			$data['phone'] = !empty($_POST['phone'])?$_POST['phone']:show_message('请输入手机号','html','-1');
			$data['store_address'] = !empty($_POST['store_address'])?$_POST['store_address']:show_message('请输入地址','html','-1');
			$data['store_xx_address'] = !empty($_POST['store_xx_address'])?$_POST['store_xx_address']:show_message('请输入详细地址','html','-1');
			$data['store_title'] = !empty($_POST['store_title'])?$_POST['store_title']:'';
			$data['store_desc'] = !empty($_POST['store_desc'])?$_POST['store_desc']:'';
			
			$store_path = BasePath.DS.UPLOADS.DS.'store'.DS.$user_id.DS;
			//商铺logo
			$store_logo = new FileUpload();
			$store_logo->set('path',$store_path)
					   ->setmaxsize('2MB')
					   ->set('newname','store_logo.jpg')
					   ->upload('store_logo');
			$data['store_logo'] = $store_logo->getFileName();
			//身份证正面
			$card_z = new FileUpload();
			$card_z->set('path',$store_path)
					   ->setmaxsize('2MB')
					   ->set('newname','card_z.jpg')
					   ->upload('card_z');
			$data['card_z'] = $card_z->getFileName();
			//身份证反面
			$card_f = new FileUpload();
			$card_f->set('path',$store_path)
					   ->setmaxsize('2MB')
					   ->set('newname','card_f.jpg')
					   ->upload('card_f');
			$data['card_f'] = $card_f->getFileName();
			
			//商铺背景图
			$store_background = new FileUpload();
			$store_background->set('path',$store_path)
					   ->setmaxsize('2MB')
					   ->set('newname','store_background.jpg')
					   ->upload('store_background');
			$data['store_background'] = $store_background->getFileName();
			
			//商铺组图
			$store_imgs = new FileUpload();
			$store_imgs->set('path',$store_path)
					   ->setmaxsize('2MB')
					   ->upload('store_imgs');
			$data['store_imgs'] = $store_imgs->getFileName();
			if(is_array($data['store_imgs'])){
				$data['store_imgs'] = implode(',',$data['store_imgs']);
			}
			
			$data['add_time'] = time();
			$data['update_time'] = time();
			$data['store_state'] = 2;  	//审核中
			$data['is_open'] = 2;     	//关闭
			$data['is_self'] = 2;       //非自营
			$data['u_id'] = $user_id;
			
			$res = M('store')->insert($data);
			if($res){
				show_message('提交成功','html','?act=setting&op=index');
			}else{
				show_message('提交失败','html','-1');
			}
		}
	}
	
	//是否有商铺
	public function is_register($user_id){
		$user = M('store')->where(array('u_id'=>$user_id))->find();
		if(empty($user)){
			return false;
		}else{
			return true;
		}
	}
	
	
	//商家第一个页面
	public function index(){
		
		self::display('user_index');
	}
}
?>