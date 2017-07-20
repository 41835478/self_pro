<?php
if(!defined('PROJECT_NAME')) die('project empty');
class goodsControl extends baseControl{
	private $classes = null;
	private $lable = null;
	public function __construct(){
		parent::__construct();
		//添加方法就行，这样可以控制顶部
		/*
		$is_header = array('index');
		if(in_array($_GET['op'] , $is_header)){
			self::setheader('header_index');
		}
		*/
		if(isset($_SESSION['user'])){
			$this->user = $_SESSION['user'];
		}else{
			require_once(BasePath.DS.'payment/wx_pay/example/WxPay.JsApiPay.php');
			$tools = new JsApiPay();
			$openId = $tools->GetOpenid();
			$user = M('user')->where(array('openid'=>$openId))->find();
			$this->openId = $openId;
			$this->user = $user;
			$_SESSION['user'] = $user;
		}
	}
	
	public function index(){
		$setting = get_setting();
		var_dump($setting);die;
		$goods_id = intval($_GET['id']);
		if($goods_id > 0){
			
		}else{
		//没有此商品
			
		}
		$goods = M('goods')->where(array('goods_id'=>$goods_id))->find();
		if(!empty($goods)){
			self::output('data',$goods);
		}
		self::display('goods');
	}
	
	public function shangpinzulin(){
		$store_id = intval($_GET['store_id']);
		$order_id = intval($_GET['order_id']);
		if($store_id > 0 && $order_id > 0){
			$where = array(
				'is_del' => 0,
				'is_show' => 1,
				'store_id' => $store_id,
			);
			$goods = M('shangpinzulin')->where($where)->select();
			if(!empty($goods)){
				foreach($goods as$key => $val){
					$goods[$key]['z_img'] = get_img($val['z_img'],'goodszl');
				}
			}
			self::output('data',$goods);
			self::output('store_id',$store_id);
			self::output('order_id',$order_id);
			self::display('shangpinzulin');
		}else{
			show_message('页面错误','html','-1');
		}
	}
}
?>