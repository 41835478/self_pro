<?php
if(!defined('PROJECT_NAME')) die('project empty');
class duihuanControl extends systemControl{
	
	public function duihuan_list(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 10;
		$where = array(
			'is_del' => 0,
		);
		$duihuan_list = M('duihuanma')
						->where($where)
						->page($page,$num)
						->select();
		$count = M('duihuanma')
				->where($where)
				->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		
		self::output('data',$duihuan_list);
		self::display('duihuan_list');
	}
	
	//添加或编辑
	public function duihuan_edit(){
		if($_POST){
			$data = array();
			$data['d_price'] = $_POST['d_price'];
			if($data['d_price'] < 0){
				show_message('价格错误','html','-1');
			}
			$data['is_use'] = 0;
			$data['is_del'] = 0;
			$data['d_code'] = $this->get_code(15);
			if(isset($_POST['d_id']) && $_POST['d_id'] > 0){
				$res = M('duihuanma')->where(array('d_id' => $_POST['d_id']))->update($data);
			}else{
				$data['add_time'] = time();
				$res = M('duihuanma')->add($data);
			}
			
			if($res){
				show_message('操作成功','html','-2');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		self::display('duihuan_edit');
	}
	
	public function get_code($num = 15){
		$abc = 'abcdefghijkmnpqrstuvwxyz123456789';
		$str = '';
		for($i = 0 ; $i < $num ;$i++){
			$n = rand(0,strlen($abc));
			$str .= $abc[$n];
		}
		$res = M('duihuanma')->where(array('d_code' => $str))->find();
		if(!empty($res)){
			return $this->get_code($num);
		}else{
			return $str;
		}
	}
	
	public function duihuan_del(){
		$d_id = intval($_GET['d_id']);
		if($d_id > 0){
			
			$res = M('duihuanma')->where(array('d_id' => $d_id))->update(array('is_del' => 1));
			
			if($res){
				show_message('操作成功','html','-2');
			}else{
				show_message('操作失败','html','-1');
			}
		}
	}
	
	//查看
	public function chakan(){
		$d_id = intval($_GET['d_id']);
		if($d_id > 0){
			$data = M('duihuanma')->where(array('d_id' => $d_id))->find();
			$user = M('user')->where(array('user_id' => $data['user_id']))->find();
			self::output('data',$data);
			self::output('user',$user);
			self::display('duihuan_see');
		}
		
	}
}
?>