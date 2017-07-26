<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	广告
*/
class advControl extends systemControl{
	
	public function adv_list(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 10;
		$adv_list = M('adv')->page($page,$num)->select();
		$count = M('adv')->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		
		self::output('data',$adv_list);
		self::display('adv_list');
	}
	
	public function adv_edit(){
		if($_POST){
			$data = array();
			$data['title'] 	= !empty($_POST['title']) ? $_POST['title'] : show_message('请填写名称','html','-1'); ;
			$data['type'] 	= $_POST['type'];
		//	$data['urls'] 	= $_POST['urls'];
			$data['adv_desc'] = $_POST['adv_desc'];
			$data['width'] 	= intval($_POST['width']);
			$data['height'] = intval($_POST['height']);
			$data['label'] 	= intval($_POST['label']);
			if(intval($_POST['width']) <= 0){
				show_message('请填写宽度','html','-1');
			}
			if(intval($_POST['height']) <= 0){
				show_message('请填写高度','html','-1');
			}
			
			//图片广告
			if($data['type'] == 'img'){
				if(!empty($_POST['urls'])){
					$data['urls'] = 'http://'.str_replace('http://','',$_POST['urls']);
				}
				$images = new FileUpload();
				$path = BasePath.DS.'uploads/adv/'.date('Ymd').'/';
				$images->set('path',$path);
				$images->upload('images');
				$class_img = $images->getFileName();
				if(!empty($class_img)){
					$data['images'] = $class_img;
				}
			}
			
			//轮播图
			if($data['type'] == 'take_turns'){
				$data['is_show_num'] 			= isset($_POST['is_show_num']) ? 1 : 2 ;
				$data['is_L_AND_R'] 			= isset($_POST['is_L_AND_R']) ? 1 : 2;
				$data['is_show_bottom'] 		= isset($_POST['is_show_bottom']) ? 1 : 2;
				$data['is_show_bottom_move'] 	= $_POST['is_show_bottom_move'];
				$data['adv_mode'] 				= $_POST['adv_mode'];
				$data['urls'] 					= implode(',',$_POST['urls']);
				//多文件上传
				$adv_images = new FileUpload();
				$images_path = BasePath.DS.'uploads/adv/'.date('Ymd').'/';
				if(!empty($_FILES['images'])){
					foreach($_FILES['images']['name'] as $key => $val){
						if(empty($_FILES['images']['name'][$key])){
							unset($_FILES['images']['name'][$key]);
						}
					}
				}
				$adv_images->set('path',$images_path);
				$adv_images->upload('images');
				$adv_arr = $adv_images->getFileName();
				if(!empty($adv_arr)){
					if(isset($_GET['adv_id']) && intval($_GET['adv_id']) > 0){
						$adv = M('adv')->field('images')->where(array('adv_id'=>$_GET['adv_id']))->find();
						if(!empty($adv['images'])){
							$adv['images'] = $adv['images'].','.implode(',',$adv_arr);
							$data['images'] = $adv['images'];
						}else{
							$data['images'] = implode(',',$adv_arr);
						}
					}else{
						if(!is_array($adv_arr)){
							$data['images'] = $adv_arr;
						}else{
							$data['images'] = implode(',',$adv_arr);
						}
					}
				}
			}
			
			
			$adv_id = isset($_POST['adv_id']) && intval($_POST['adv_id']) > 0 ? intval($_POST['adv_id']) : 0 ;
			if($adv_id){
				$res = M('adv')->where(array('adv_id'=>$adv_id))->update($data);
			}else{
				$data['add_time'] = $data['date_time'] = time();
				$res = M('adv')->insert($data);
			}
			if($res){
				show_message('操作成功','html','?act=adv&op=adv_list');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		$adv_id = isset($_GET['adv_id']) && intval($_GET['adv_id']) > 0 ? intval($_GET['adv_id']) : 0;
		if( $adv_id > 0 ){
			$adv = M('adv')->where(array('adv_id'=>$adv_id))->find();
			if($adv['type'] == 'img'){
				$adv['images'] = DS.'uploads/adv/'.substr($adv['images'],0,8).DS.$adv['images'];
			}
			if($adv['type'] == 'take_turns'){
				if(!empty($adv['images'])){
					$adv['images'] = explode(',',$adv['images']);
					foreach($adv['images'] as $key => $val){
						$adv['images'][$key] = DS.'uploads/adv/'.substr($val,0,8).DS.$val;
					}
				}
				if(!empty($adv['urls'])){
					$adv['urls'] =explode(',',$adv['urls']);
					foreach($adv['urls'] as $key => $val){
						$adv['urls'][$key] = $val;
					}
				}
			}
			self::output('data',$adv);
		}
		self::display('adv_edit');
	}
	
	public function adv_images_del(){
		if(intval($_POST['adv_id']) > 0){
			$adv_id = intval($_POST['adv_id']);
			$image = $_POST['image'];
			$adv = M('adv')->field('images')->where(array('adv_id'=>$adv_id))->find();
			$adv['images'] = explode(',',$adv['images']);
			if(!empty($adv['images'])){
				foreach($adv['images'] as $key => $val){
					if($val == $image){
						rm_file(BasePath.DS.'uploads/adv/'.substr($image,0,8).DS.$image);
						unset($adv['images'][$key]);
					}
				}
			}
			$adv['images'] = implode(',',$adv['images']);
			
			M('adv')->where(array('adv_id'=>$adv_id))->update($adv);
			echo json_encode(array('code'=>'1','msg'=>'图片已删除'));
		}else{
			echo json_encode(array('code'=>'-1','msg'=>'图片删除失败'));
		}
	}
}
?>