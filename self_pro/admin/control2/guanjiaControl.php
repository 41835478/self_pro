<?php
if(!defined('PROJECT_NAME')) die('project empty');
class guanjiaControl extends systemControl{
	//商品列表
	public function guanjia_list(){
		$page = isset($_GET['page'])?$_GET['page']:1;
		$num = 10;
		$guanjia_list = M('guanjia')
					->join('left __AFFIX__admin','__AFFIX__guanjia.admin_id = __AFFIX__admin.admin_id')
					->join('left __AFFIX__store','__AFFIX__guanjia.store_id = __AFFIX__store.store_id')
					->page($page,$num)->select();
		$count = M('guanjia')->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		
		self::output('data',$guanjia_list);
		self::display('guanjia_list');
	}
	//添加和修改
	public function guanjia_edit(){
		if($_POST){
			$guanjia_id = (isset($_POST['guanjia_id']) && $_POST['guanjia_id'] > 0)?intval($_POST['guanjia_id']):'';
			//提交修改  搜索  商品提交
			$data = $this->commit();
			
			if(!empty($guanjia_id)){
				$res = M('guanjia')->where(array('guanjia_id'=>$guanjia_id))->update($data);
			}else{
				$admin_id = M('guanjia')->where(array('admin_id'=>$data['admin_id']))->find();
				if(!empty($admin_id)){
					show_message('不能重复添加','html','-1');
				}
				$data['create_time'] = time();
				$res = M('guanjia')->insert($data);
			}
			
			if($res){
				show_message('操作成功','html','?act=guanjia&op=guanjia_list');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		
		
		//查询是否有该商品
		if(isset($_GET['guanjia_id']) && intval($_GET['guanjia_id'])){
			$guanjia_id = intval($_GET['guanjia_id']);
			$data = M('guanjia')->where(array('guanjia_id'=>$_GET['guanjia_id']))->find();//
			$data['guanjia_logo'] = get_img($data['guanjia_logo'],'guanjia');
			self::output('data',$data);	
		}
		$guanjia = M('admin')->where(array('admin_type'=>2))->select();
		self::output('guanjia',$guanjia);	
		
		$store_list = M('store')->where(array('is_open'=>1))->select();
		self::output('store_list',$store_list);
		
		self::display('guanjia_edit');
	}
	
	//商品删除
	public function guanjia_del(){
		$guanjia_id = $_GET['guanjia_id'];
		if(intval($guanjia_id) > 0 ){
			//拿商品
			$guanjia = M('guanjia',true)->get_guanjia_info($guanjia_id,'path');
			if(!empty($guanjia['guanjia_img'])){
				rm_file($guanjia['guanjia_img']);
			}
			if(!empty($guanjia['guanjia_images']) && count($guanjia['guanjia_images']) > 0){
				foreach($guanjia['guanjia_images'] as $key => $val){
					rm_file($val);
				}
			}
			$res = M('guanjia')->where(array('guanjia_id'=>$guanjia_id))->del();
			if($res){
				show_message('删除成功','html','-1');
			}else{
				show_message('删除失败','html','-1');
			}
		}else{
			show_message('操作失败','html','-1');
		}
	}
	
	//商品提交
	public function commit(){
		$data['guanjia_name'] = !empty($_POST['guanjia_name'])?$_POST['guanjia_name']:show_message('请填写管家名称','html','-1');
		$data['guanjia_aihao'] 		= $_POST['guanjia_aihao'];
		$data['guanjia_age'] 		= $_POST['guanjia_age'];
		$data['guanjia_xingzuo'] 	= $_POST['guanjia_xingzuo'];
		$data['guanjia_xueli'] 		= $_POST['guanjia_xueli'];
		$data['guanjia_phone'] 		= $_POST['guanjia_phone'];
		$data['guanjia_biaoqian'] 	= $_POST['guanjia_biaoqian'];
		$data['guanjia_qianming'] 	= $_POST['guanjia_qianming'];
		$data['guanjia_xingbie'] 	= $_POST['guanjia_xingbie'];
		$data['is_renzheng'] 		= $_POST['is_renzheng'];
		$data['guanjia_shuzhi'] 	= $_POST['guanjia_shuzhi'];
		$data['admin_id'] 			= $_POST['admin_id'];
		$data['store_id'] 			= $_POST['store_id'];
		$logo = new FileUpload();
		$path = BasePath.DS.'uploads/guanjia/'.date('Ymd').'/';
		$logo->set('path',$path);
		$logo->upload('guanjia_logo');
		$guanjia_logo = $logo->getFileName();
		if(!empty($guanjia_logo)){
			$data['guanjia_logo'] = $guanjia_logo;
		}
		
		return $data;
	}
	
	public function guanjia_images_del(){
		if(intval($_POST['guanjia_id']) > 0){
			$guanjia_id = intval($_POST['guanjia_id']);
			$image = $_POST['image'];
			$guanjia = M('guanjia')->field('guanjia_images')->where(array('guanjia_id'=>$guanjia_id))->find();
			$guanjia['guanjia_images'] = explode(',',$guanjia['guanjia_images']);
			if(!empty($guanjia['guanjia_images'])){
				foreach($guanjia['guanjia_images'] as $key => $val){
					if($val == $image){
						rm_file(BasePath.DS.'uploads/guanjia/'.substr($image,0,19).DS.$image);
						unset($guanjia['guanjia_images'][$key]);
					}
				}
			}
			$guanjia['guanjia_images'] = implode(',',$guanjia['guanjia_images']);
			
			M('guanjia')->where(array('guanjia_id'=>$guanjia_id))->update($guanjia);
			echo json_encode(array('code'=>'1','msg'=>'图片已删除'));
		}else{
			echo json_encode(array('code'=>'-1','msg'=>'图片删除失败'));
		}
	}
}