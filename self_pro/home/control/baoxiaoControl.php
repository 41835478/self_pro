<?php
if(!defined('PROJECT_NAME')) die('project empty');
class baoxiaoControl extends baseControl{
	
	public function __construct(){
		if(!isset($_SESSION['admin_state'])){
			show_message('账户错误','html','index.php?act=login&op=login2');
		}
	}
	
	public function baoxiao_reg(){
		$page = isset($_GET['page']) && intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
		$num = 10;
		$where = array(
			'my_id' => $_SESSION['user_id'],
		);
		$data = M('baoxiao')
				->where($where)
				->page($page,$num)
				->select();
		$count = M('baoxiao')->where($where)->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		if(!empty($data)){
			foreach($data as $key => $val){
				if($val['is_use'] == 0){
					$data[$key]['is_use'] = '已提交';
				}
				if($val['is_use'] == 1){
					$data[$key]['is_use'] = '已通过';
				}
				if($val['is_use'] == 2){
					$data[$key]['is_use'] = '未通过';
				}
			}
		}
		self::output('data',$data);
		self::display('baoxiao_reg');
	}
	
	public function baoxiao(){
		if($_POST){
			$data = array();
			$data['my_id'] 		= $_SESSION['user_id'];
			if(empty($_POST['username'])){
				show_message('请填写姓名','html','-1');
			}
			$data['b_name'] 	= $_POST['username'];
			$data['b_price'] 	= $_POST['price'];
			$data['b_type'] 	= $_POST['leibie'];
			if(empty($_POST['beizhu'])){
				show_message('请填写备注','html','-1');
			}
			$data['b_beizhu'] 	= $_POST['beizhu'];
			$data['b_images'] 	= $_POST['images'];
			$data['create_time'] = time();
			$res = M('baoxiao')->add($data);
			if($res){
				show_message('操作成功','html','-2');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		self::display('baoxiao');
	}
	
	
}
?>