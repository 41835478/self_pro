<?php
if(!defined('PROJECT_NAME')) die('project empty');
class settingControl extends systemControl{
	
	public function index(){
		if($_POST){
			if(isset($_POST['setting_type'])){
				$this->setting_type($_POST['setting_type']);
			}else{
				show_message('未知错误！','html','-1');
			}
		}
		$web_config = M('setting',true)->get_web_config(); 
		self::output('web_config',$web_config); //var_dump($web_config);die;
		self::display();
	}
	
	public function setting_type($type){
		switch($type){
			case 'web':
				$this->set_web();
			break;
			case 'pc':
				$this->set_pc();
			break;
			case 'mobile':
				$this->set_mobile();
			break;
			case 'wx':
				$this->set_wx();
			break;
			default:
				show_message('未知类型！','html','-1');
			break;
		}
	}
	//网站设置
	public function set_web(){
		$web_config = M('setting',true)->get_web_config();
		$data = array();
		$data['web_name'] 		= $_POST['web_name'];
		$data['web_url'] 		= $_POST['web_url'];
		$data['web_mobile']		= $_POST['web_mobile'];
		$data['web_QQ'] 		= $_POST['web_QQ'];
		$data['web_mail'] 		= $_POST['web_mail'];
		$data['web_desc'] 		= $_POST['web_desc'];
		$data['is_integral'] 	= isset($_POST['is_integral'])?'1':'2';
		$data['is_coupon'] 	= isset($_POST['is_coupon'])?'1':'2';
		$data['jifen_1'] 		= $_POST['jifen_1'];
		$data['jifen_2'] 		= $_POST['jifen_2'];
		$data['coupon_1'] 		= $_POST['coupon_1'];
		$data['coupon_2'] 		= $_POST['coupon_2'];
		$data['is_balance']		= isset($_POST['is_balance'])?'1':'2';
		$data['is_redbag']		= isset($_POST['is_redbag'])?'1':'2';
		$data['is_discount']	= isset($_POST['is_discount'])?'1':'2';
		$data['is_distribution']= isset($_POST['is_distribution'])?'1':'2';
		$data['register_redbag']= $_POST['register_redbag'];
		$data['num_float']		= isset($_POST['num_float'])?$_POST['num_float']:'1';
		$data['is_rebate']		= isset($_POST['is_rebate'])?$_POST['is_rebate']:'1';
		$data['is_register']	= isset($_POST['is_register'])?$_POST['is_register']:'1';
		$data['is_login']		= isset($_POST['is_login'])?$_POST['is_login']:'1';
		$data['is_captcha']		= isset($_POST['is_captcha'])?$_POST['is_captcha']:'1';
		$data['login_time']		= isset($_POST['login_time'])?$_POST['login_time']:'1200';
		$data['is_store']		= isset($_POST['is_store'])?$_POST['is_store']:'1';
		$data['store_time']		= isset($_POST['store_time'])?$_POST['store_time'] * 3600 : '3600';
		$data['store_day']		= isset($_POST['store_day'])?$_POST['store_day'] * 3600*24 : 3600*24*365;
		if($data['is_rebate'] == 2){
			if($_POST['rebate_price'] <= 0 || $_POST['rebate_price'] > 100){
				show_message('回扣比率错误，请填写1-100以内的数字','html','-1');
			}
		}
		$data['rebate_price']	= $_POST['rebate_price'];
		$data['rebate_unprice'] = $_POST['rebate_unprice'];
		$data['integral_set'] 	= $_POST['integral_set'];
		$data['integral_sum'] 	= $_POST['integral_sum'];
		$data['integral_price'] = $_POST['integral_price'];
		$data['copyright_information'] = $_POST['copyright_information'];
		$data['keep_record'] 	= $_POST['keep_record'];
		$data['is_close'] 		= $_POST['is_close'];
		$data['close_info'] 	= $_POST['close_info'];
		$data['min_freight'] 	= !empty($_POST['min_freight']) && intval($_POST['min_freight']) > 0 ? $_POST['min_freight'] : 0 ;
		
		//ico图片上传
		$ico = new FileUpload();
		$path = BasePath.DS;
		$ico_bool = $ico->set('fileType','ico')
						->set('allowtype',array('ico'))
						->set('path',$path)
						->set('newname','favicon.ico')
						->upload('web_ico');
		$ico_name = $ico->getFileName();
		if(!$ico_bool && !empty($_FILES['web_ico']['name'])){
			show_message('网站图标上传错误，请上传ico格式图片','html','-1');
		}
		if(!empty($ico_name)){
			$data['web_ico'] = URL.DS.$ico_name;
		}else if(isset($web_config['web_ico'])){
			$data['web_ico'] = $web_config['web_ico'];
		}
		//logo上传
		$web_logo = new FileUpload();
		$logo_path = BasePath.DS.UPLOADS.'web'.DS;
		$web_logo_bool = $web_logo->set('path',$logo_path)
								  ->upload('web_logo');
		$web_logo = $web_logo->getFileName();
		if(!empty($web_logo)){
			$data['web_logo'] = URL.DS.UPLOADS.'web'.DS.$web_logo;
		}else if(isset($web_config['web_logo'])){
			$data['web_logo'] = $web_config['web_logo'];
		}
		$data = serialize($data);
		$web_config = M('setting')->where(array('name'=>'web_config'))->find();
		if($web_config){
			$res = M('setting')->where(array('name'=>'web_config'))->update(array('value'=>$data));
		}else{
			$res = M('setting')->insert(array('value'=>$data,'name'=>'web_config'));
		}
		
		if($res){
			show_message('保存成功','html','?act=setting&op=index');
		}else{
			show_message('保存失败','html','-1');
		}
	}
	//设置电脑端
	public function set_pc(){
		var_dump($_POST);die;
	}
	//设置手机端
	public function set_mobile(){
		var_dump($_POST);die;
	}
	//设置微信
	public function set_wx(){
		var_dump($_POST);die;
	}
}
?>