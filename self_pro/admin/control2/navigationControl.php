<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	导航
*/
class navigationControl extends systemControl{
	
	private $navigation = null;
	
	public function __construct(){
		parent::__construct();
		$this->navigation = M('navigation');
	}
	//导航分类
	public function navigation_list(){
		
		//获取子分类
		$cat_list = M('public',true)->get_navigation();
		
		self::output('data',$cat_list);
		self::display('navigation_list');
	}
	
	//添加或修改分类
	public function navigation_edit(){
		if($_POST){
			$cat_id = (isset($_POST['cat_id']) && $_POST['cat_id'] > 0)?intval($_POST['cat_id']):'';
			//提交修改  搜索  导航提交
			$data = $this->commit();
			
			if(!empty($cat_id)){
				$res = M('navigation')->where(array('cat_id'=>$cat_id))->update($data);
			}else{
				$data['add_time'] = time();
				$res = M('navigation')->insert($data);
			}
			
			if($res){
				show_message('操作成功','html','?act=navigation&op=navigation_list');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		
		//获取子分类
		$cat_list = M('public',true)->get_navigation();
			
		self::output('cat_list',$cat_list);	
		
		
		//查询是否有该分类
		if(isset($_GET['cat_id']) && intval($_GET['cat_id'])){
			$cat_id = intval($_GET['cat_id']);
			$data = M('navigation',true)->get_navigation_info($cat_id);
			self::output('data',$data);	
		}
		
		self::display('navigation_edit');
	}
	
	//获取分类
	/*
	public function get_navigation($arr,$arr2){
	//	$res = $this->navigation->field('cat_id,cat_name,cat_pid')->where(array('cat_pid'=>$arr['cat_id']))->select();
		$res = '';
		if(empty($arr2)){
			$res = $this->navigation->field('cat_id,cat_name,cat_pid')->where(array('cat_pid'=>$arr['cat_id']))->select();
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
				$res[$k]['list'] = $this->get_navigation($v,$arr2);
			}
		}
		return $res;
	}
	*/
	
	//删除
	public function navigation_del(){
		$cat_id = $_GET['cat_id'];
		if(intval($cat_id) > 0 ){
			//拿导航
			$navigation = M('navigation',true)->get_navigation_info($cat_id,'path');
			if(!empty($navigation['cat_img'])){
				rm_file($navigation['cat_img']);
			}
			$res = M('navigation')->where(array('cat_id'=>$cat_id))->del();
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
		$data['cat_url'] 		= $_POST['cat_url'];
		$data['cat_pid'] 		= intval($_POST['cat_pid']);
		$data['cat_label'] 		= intval($_POST['cat_label']);
		$data['is_show'] 		= isset($_POST['is_show'])?1:2;
		$data['is_home_show'] 	= isset($_POST['is_home_show'])?1:2;
		$data['cat_desc'] 		= intval($_POST['cat_desc']);

		$logo = new FileUpload();
		$path = BasePath.DS.'uploads/navigation/'.date('Ymd').'/';
		$logo->set('path',$path);
		$logo->upload('cat_img');
		$cat_img = $logo->getFileName();
		if(!empty($cat_img)){
			$data['cat_img'] = $cat_img;
		}
		return $data;
	}
	
	//删除分类图片
	public function navigation_images_del(){
		if(intval($_POST['cat_id']) > 0){
			$cat_id = intval($_POST['cat_id']);
			$navigation = M('navigation')->field('cat_img')->where(array('cat_id'=>$cat_id))->find();
			rm_file(BasePath.DS.'uploads/navigation/'.substr($goods['cat_img'][$num],0,19).DS.$goods['cat_img']);
			$navigation['cat_img'] = '';
			M('navigation')->where(array('cat_id'=>$cat_id))->update($navigation);
			echo json_encode(array('code'=>'1','msg'=>'图片已删除'));
		}else{
			echo json_encode(array('code'=>'-1','msg'=>'图片删除失败'));
		}
	}
}