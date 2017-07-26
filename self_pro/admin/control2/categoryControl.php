
<?php
if(!defined('PROJECT_NAME')) die('project empty');
class categoryControl extends systemControl{
	
	private $category = null;
	
	public function __construct(){
		parent::__construct();
		$this->category = M('category');
	}
	//商品分类
	public function category_list(){
		
		//获取子分类
		$cat_list = M('public',true)->get_category();
		
		self::output('data',$cat_list);
		self::display('category_list');
	}
	
	//添加或修改分类
	public function category_edit(){
		if($_POST){
			$cat_id = (isset($_POST['cat_id']) && $_POST['cat_id'] > 0)?intval($_POST['cat_id']):'';
			//提交修改  搜索  商品提交
			$data = $this->commit();
			
			if(!empty($cat_id)){
				$res = M('category')->where(array('cat_id'=>$cat_id))->update($data);
			}else{
				$data['add_time'] = time();
				$res = M('category')->insert($data);
			}
			
			if($res){
				show_message('操作成功','html','?act=category&op=category_list');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		
		//获取子分类
		$cat_list = M('public',true)->get_category();
			
		self::output('cat_list',$cat_list);	
		
		
		//查询是否有该分类
		if(isset($_GET['cat_id']) && intval($_GET['cat_id'])){
			$cat_id = intval($_GET['cat_id']);
			$data = M('category',true)->get_category_info($cat_id);
			self::output('data',$data);	
		}
		
		self::display('category_edit');
	}
	
	//获取分类
	/*
	public function get_category($arr,$arr2){
	//	$res = $this->category->field('cat_id,cat_name,cat_pid')->where(array('cat_pid'=>$arr['cat_id']))->select();
		$res = '';
		if(empty($arr2)){
			$res = $this->category->field('cat_id,cat_name,cat_pid')->where(array('cat_pid'=>$arr['cat_id']))->select();
		}else{
			if(isset($arr2[$arr['cat_id']])){
				$res = $arr2[$arr['cat_id']];
			}
		}
		
		if(!empty($res)){
			foreach($res as $k => $v){
				if(isset($arr['nbsp'])){
					$res[$k]['nbsp'] = '&nbsp;&nbsp;&nbsp;'.$arr['nbsp'];
					$v['nbsp'] = '&nbsp;&nbsp;&nbsp;'.$arr['nbsp'];
					$res[$k]['cat_name'] = $v['nbsp'].'┝&nbsp;'.$v['cat_name'];
				}else{
					$res[$k]['nbsp'] = '&nbsp;&nbsp;&nbsp;';
					$v['nbsp'] = '&nbsp;&nbsp;&nbsp;';
					$res[$k]['cat_name'] = $v['nbsp'].'┝&nbsp;'.$v['cat_name'];
				}
				$res[$k]['list'] = $this->get_category($v,$arr2);
			}
		}
		return $res;
	}
	*/
	
	//删除
	public function category_del(){
		$cat_id = $_GET['cat_id'];
		if(intval($cat_id) > 0 ){
			//拿商品
			$category = M('category',true)->get_category_info($cat_id,'path');
			if(!empty($category['cat_img'])){
				rm_file($category['cat_img']);
			}
			$res = M('category')->where(array('cat_id'=>$cat_id))->del();
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
		$data['cat_name'] 		= !empty($_POST['cat_name'])?$_POST['cat_name']:show_message('请填写分类名称','html','-1');
		$data['cat_jname'] 		= $_POST['cat_jname'];
		$data['cat_pid'] 		= intval($_POST['cat_pid']);
		$data['cat_label'] 		= intval($_POST['cat_label']);
		$data['is_show'] 		= isset($_POST['is_show'])?1:2;
		$data['is_home_show'] 	= isset($_POST['is_home_show'])?1:2;
		$data['cat_desc'] 		= intval($_POST['cat_desc']);

		$logo = new FileUpload();
		$path = BasePath.DS.'uploads/category/'.date('Ymd').'/';
		$logo->set('path',$path);
		$logo->upload('cat_img');
		$cat_img = $logo->getFileName();
		if(!empty($cat_img)){
			$data['cat_img'] = $cat_img;
		}
		return $data;
	}
	
	//删除分类图片
	public function category_images_del(){
		if(intval($_POST['cat_id']) > 0){
			$cat_id = intval($_POST['cat_id']);
			$category = M('category')->field('cat_img')->where(array('cat_id'=>$cat_id))->find();
			rm_file(BasePath.DS.'uploads/category/'.substr($goods['cat_img'][$num],0,19).DS.$goods['cat_img']);
			$category['cat_img'] = '';
			M('category')->where(array('cat_id'=>$cat_id))->update($category);
			echo json_encode(array('code'=>'1','msg'=>'图片已删除'));
		}else{
			echo json_encode(array('code'=>'-1','msg'=>'图片删除失败'));
		}
	}
}