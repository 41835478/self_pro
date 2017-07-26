<?php
if(!defined('PROJECT_NAME')) die('project empty');
class paymentControl extends systemControl{
	
	public function payment_list(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 10;
		$payment_list = M('payment_config')->page($page,$num)->select();
		$count = M('payment_config')->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		self::output('data',$payment_list);
		self::display('payment_list');
	}
	
	public function payment_edit(){
		
		if($_POST){
			$id = intval($_POST['id']);
			$data = array();
			$data['name'] = $_POST['name'];
			$data['chinese_name'] = $_POST['chinese_name'];
			$data['is_open'] = isset($_POST['is_open'])?1:2;
			$data_array = $_POST['data_array'];
			$data_array = explode('|',$data_array);
			$arr = array();
			foreach($data_array as $key => $val){
				$arr[$val] = $_POST[$val];
			}
			$data['value'] = serialize($arr);
			
			$res = M('payment_config')->where(array('id'=>$id))->update($data);
			if($res){
				show_message('操作成功','html','?act=payment&op=payment_list');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		
		$payment_id = intval($_GET['id']) > 0 ? intval($_GET['id']) : 0 ;
		$payment = M('payment_config')->where(array('id'=>$payment_id))->find();
		
		if(!empty($payment['value'])){
			$payment['value'] = unserialize($payment['value']);
			foreach($payment['value'] as $key => $val){
				$payment[$key] = $val;
			}
		}
		
		self::output('data',$payment);
		$payment_type = '';
		switch($payment['payment_type']){
			case 'wx':
				$payment_type = $payment['payment_type'];
				break;
			case 'ali':
				$payment_type = $payment['payment_type'];
				break;
			default :
				break;
		}
		self::output('pay_type',$payment_type);
		self::display('payment_edit');
	}
}
?>