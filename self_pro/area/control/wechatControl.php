
<?php
if(!defined('PROJECT_NAME')) die('project empty');
class wechatControl extends sysControl{
	
	public function test(){
		include_once BasePath.DS.'payment/alipay/wappay/pay.php';
	//	include_once BasePath.DS.'payment/wx_pay/example/self_zhifu.php';
	}
	
	private $wx_menu = null;
	
	public function __construct(){
		parent::__construct();
		$this->wx_menu = M('wx_menu');
	}
	//商品分类
	public function wechat_menu (){
		
		//获取子分类
		$wx_list = M('public',true)->get_wx_menu();
		
		self::output('data',$wx_list);
		self::display('wechat_menu');
	}
	
	//添加或修改分类
	public function wechat_edit(){
		if($_POST){
			$wx_id = (isset($_POST['wx_id']) && $_POST['wx_id'] > 0)?intval($_POST['wx_id']):'';
			//提交修改  搜索  商品提交
			$data = $this->commit();
			
			if(!empty($wx_id)){
				$res = M('wx_menu')->where(array('wx_id'=>$wx_id))->update($data);
			}else{
				$data['add_time'] = time();
				$res = M('wx_menu')->insert($data);
			}
			
			if($res){
				show_message('操作成功','html','?act=wechat&op=wechat_menu');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		
		//获取子分类
		$wx_list = M('public',true)->get_wx_menu();
			
		self::output('wx_list',$wx_list);	
		
		
		//查询是否有该分类
		if(isset($_GET['wx_id']) && intval($_GET['wx_id'])){
			$wx_id = intval($_GET['wx_id']);
			$data = M('wx_menu',true)->get_wx_menu_info($wx_id);
			self::output('data',$data);	
		}
		
		self::display('wechat_edit');
	}
	
	//获取分类
	/*
	public function get_wx_menu($arr,$arr2){
	//	$res = $this->wx_menu->field('wx_id,wx_name,wx_pid')->where(array('wx_pid'=>$arr['wx_id']))->select();
		$res = '';
		if(empty($arr2)){
			$res = $this->wx_menu->field('wx_id,wx_name,wx_pid')->where(array('wx_pid'=>$arr['wx_id']))->select();
		}else{
			if(isset($arr2[$arr['wx_id']])){
				$res = $arr2[$arr['wx_id']];
			}
		}
		
		if(!empty($res)){
			foreach($res as $k => $v){
				if(isset($arr['nbsp'])){
					$res[$k]['nbsp'] = '&nbsp;&nbsp;&nbsp;'.$arr['nbsp'];
					$v['nbsp'] = '&nbsp;&nbsp;&nbsp;'.$arr['nbsp'];
					$res[$k]['wx_name'] = $v['nbsp'].'┝&nbsp;'.$v['wx_name'];
				}else{
					$res[$k]['nbsp'] = '&nbsp;&nbsp;&nbsp;';
					$v['nbsp'] = '&nbsp;&nbsp;&nbsp;';
					$res[$k]['wx_name'] = $v['nbsp'].'┝&nbsp;'.$v['wx_name'];
				}
				$res[$k]['list'] = $this->get_wx_menu($v,$arr2);
			}
		}
		return $res;
	}
	*/
	
	//删除
	public function wechat_del(){
		$wx_id = $_GET['wx_id'];
		if(intval($wx_id) > 0 ){
			//拿商品
			$wx_menu = M('wx_menu',true)->get_wx_menu_info($wx_id,'path');
			if(!empty($wx_menu['wx_img'])){
				rm_file($wx_menu['wx_img']);
			}
			$res = M('wx_menu')->where(array('wx_id'=>$wx_id))->del();
			if($res){
				show_message('删除成功','html','-1');
			}else{
				show_message('删除失败','html','-1');
			}
		}else{
			show_message('操作失败','html','-1');
		}
	}
	
	public function commit(){
		$data['wx_name'] 		= !empty($_POST['wx_name'])?$_POST['wx_name']:show_message('请填写分类名称','html','-1');
		$data['wx_jname'] 		= $_POST['wx_jname'];
		$data['wx_url'] 		= $_POST['wx_url'];
		$data['wx_pid'] 		= intval($_POST['wx_pid']);
		$data['wx_label'] 		= intval($_POST['wx_label']);
		$data['is_show'] 		= isset($_POST['is_show'])?1:2;
		$data['is_home_show'] 	= isset($_POST['is_home_show'])?1:2;
		$data['wx_desc'] 		= intval($_POST['wx_desc']);
		$data['menu_type'] 		= $_POST['menu_type'];
		$data['field1'] 		= $_POST['field1'];
		$data['field2'] 		= $_POST['field2'];
		if($data['menu_type'] == 'click'){
			$data['wx_url'] = '';
		}
		if($data['menu_type'] == 'miniprogram'){
			
		}
		$logo = new FileUpload();
		$path = BasePath.DS.'uploads/wx_menu/'.date('Ymd').'/';
		$logo->set('path',$path);
		$logo->upload('wx_img');
		$wx_img = $logo->getFileName();
		if(!empty($wx_img)){
			$data['wx_img'] = $wx_img;
		}
		return $data;
	}
	
	//删除分类图片
	public function wx_menu_images_del(){
		if(intval($_POST['wx_id']) > 0){
			$wx_id = intval($_POST['wx_id']);
			$wx_menu = M('wx_menu')->field('wx_img')->where(array('wx_id'=>$wx_id))->find();
			rm_file(BasePath.DS.'uploads/wx_menu/'.substr($goods['wx_img'][$num],0,19).DS.$goods['wx_img']);
			$wx_menu['wx_img'] = '';
			M('wx_menu')->where(array('wx_id'=>$wx_id))->update($wx_menu);
			echo json_encode(array('code'=>'1','msg'=>'图片已删除'));
		}else{
			echo json_encode(array('code'=>'-1','msg'=>'图片删除失败'));
		}
	}
	
	public function wechat_start(){
		//一级菜单只有三个
		$yiji = M('wx_menu')->where(array('wx_pid'=>0))->limit(3)->select();
		$menu = array();
		if(!empty($yiji)){
			foreach($yiji as $key => $val){
				$a1 = array();
				$a1['name'] = $val['wx_name'];
				$erji = M('wx_menu')->where(array('wx_pid'=>$val['wx_id']))->limit(5)->select();
				if(!empty($erji)){
					foreach($erji as $k => $v){
						$a2 = array();
						$a2['key'] ='wx_hyq_'.$v['wx_id'];
						$a2['name'] = $v['wx_name'];
						$a2['type'] = $v['menu_type'];
						if(!empty($v['wx_url'])){
							$a2['url'] = $v['wx_url'];
						}
						if($v['menu_type'] == 'miniprogram'){
							$a1['appid'] = $v['wx_url'];
							$a1['pagepath'] = $v['field1'];
						}
						$a1['sub_button'][] = $a2;
					}
				}else{
					$a1['key'] ='wx_hyq_'.$val['wx_id'];
					$a1['type'] = $val['menu_type'];
					if($val['menu_type'] == 'miniprogram'){
						$a1['appid'] = $val['wx_url'];
						$a1['pagepath'] = $val['field1'];
					}
					if(!empty($val['wx_url'])){
						$a1['url'] = $val['wx_url'];
					}
				}
				$menu[] = $a1;
			}
		}
		$wx_menu['button'] = $menu;
	//	var_dump($wx_menu);die;
		$wechat = M('payment_config')->where(array('payment_type'=>'wx'))->find();
		if($wechat['is_open'] != 1){
			die;
		}
		$config = unserialize($wechat['value']);
		include BasePath.DS."plugins".DS."wechat".DS."wechat.class.php";
		
		$options = array(
				'token'=> trim($config['token']), //填写你设定的key
				'encodingaeskey'=> trim($config['EncodingAESKey']), //填写加密用的EncodingAESKey，如接口为明文模式可忽略
				'appid'=>trim($config['app_id']), //填写高级调用功能的app id
				'appsecret'=>trim($config['appsecret']), //填写高级调用功能的密钥
			);
		
		$weObj = new Wechat($options);
		$this->weixin = $weObj;
	//	$weObj->valid();
		$res = $weObj->createMenu($wx_menu);
		
		if($res){
			show_message('操作成功','html','?act=wechat&op=wechat_menu');
		}else{
			show_message('操作失败','html','-1');
		}
	}
}