<?php
if(!defined('PROJECT_NAME')) die('project empty');
class oneControl extends systemControl{
	
	//一元购物
	public function one_buy_list(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 10;
		$one_list = M('one_buy')->page($page,$num)->select();
		$count = M('one_buy')->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		
		self::output('data',$one_list);
		
		self::display('one_buy_list');
	}
	
	public function one_buy_edit(){
		
		if($_POST){
			$data = array();
			$data['name'] 		= empty($_POST['name'])? show_message('请填写名称','html','-1') : $_POST['name']; 
			$data['title']	 	= $_POST['title']; 
			$data['title2'] 	= $_POST['title2']; 
			$data['one_price']  = intval($_POST['one_price']) <= 0 ? show_message('请填写正确的价格','html','-1') : intval($_POST['one_price']); 
			$data['one_sort'] 	= $_POST['one_sort']; 
			$data['is_review'] 	= isset($_POST['is_review'])?1:2; 
			$data['one_desc'] 	= $_POST['one_desc']; 
			
			$logo = new FileUpload();
			$path = BasePath.DS.'uploads/one_buy/';
			$logo->set('path',$path);
			$logo->upload('one_img');
			$one_img = $logo->getFileName();
			if(!empty($one_img)){
				$data['one_img'] = $one_img;
			}
			$data['start_time'] = get_data_time('start_time','start_day','start_hour');
			$data['end_time'] = get_data_time('end_time','end_day','end_hour');
			
			if($data['start_time'] > 0 && $data['end_time'] > 0 && $data['end_time'] <= $data['start_time']){
				show_message('请选择正确的时间','html','-1');
			}
			
			$one_id = (isset($_POST['one_id']) && $_POST['one_id'] > 0)?intval($_POST['one_id']):'';
			$data['update_time'] = time();
			if(!empty($one_id)){
				$res = M('one_buy')->where(array('id'=>$one_id))->update($data);
			}else{
				$data['add_time'] = time();
				$res = M('one_buy')->insert($data);
			}
			
			if($res){
				show_message('操作成功','html','?act=one&op=one_buy_list');
			}else{
				show_message('操作失败','html','-1');
			}
			
		}
		
		if(isset($_GET['one_id']) && intval($_GET['one_id']) > 0){
			$data = M('one_buy')->where(array('id'=>intval($_GET['one_id'])))->find();
			$data['one_img'] = DS.UPLOADS.'one_buy'.DS.$data['one_img'];
			$data['start_time'] = date_un($data['start_time']);
			$data['start_day'] = $data['start_time']['day'];
			$data['start_hour'] = $data['start_time']['hour'];
			$data['end_time'] = date_un($data['end_time']);
			$data['end_day'] = $data['start_time']['day'];
			$data['end_hour'] = $data['start_time']['hour'];
			self::output('data',$data);
		}
		
		self::display('one_buy_edit');
	}
	
	public function one_buy_del(){
		$id = intval($_GET['one_id']);
		if($id > 0){
			$one_buy = M('one_buy')->where(array('id' => $id))->find();
			rm_file(DS.UPLOADS.'one_buy'.DS.$one_buy['one_img']);
			$res = M('one_buy')->where(array('id' => $id))->del();
			M('goods')->where(array('one_buy_id'=>$id))->update(array('one_buy_id'=>0));
			if($res){
				show_message('操作成功','html','?act=one&op=one_buy_list');
			}else{
				show_message('操作失败','html','-1');
			}
		}else{
			show_message('操作失败','html','-1');
		}
	}
	
	public function review_list(){
		self::display('review_list');
	}
	
	//一元夺宝
	public function one_indiana(){
		self::display('one_indiana');
	}
}
?>