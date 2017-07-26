<?php
if(!defined('PROJECT_NAME')) die('project empty');
class groupControl extends systemControl{
	public function group_list(){
		$page = isset($_GET['page'])?intval($_GET['page']):1;
		$num = 15;
		$where = array(
			'admin_id' => $_SESSION['admin_id'],
		);
		$data = M('group')->where($where)->page($page,$num)->select();
		$count = M('group')->count();
		$page = new page($count,$num,$page,URL.'/'.PROJECT.'/?act='.$_GET['act'].'&op='.$_GET['op'].'&page={page}',10);
		$page->conf = 345;
		self::output('page',$page->show());
		foreach($data as $key => $val){
			$data[$key]['add_time'] = date('Y-m-d',$val['add_time']);
			$data[$key]['update_time'] = date('Y-m-d',$val['update_time']);
		}
		self::output('data',$data);
		self::display('group_list');
	}

	public function group_edit(){
		if($_POST){
			$weight = read_language('menu');
			$data = array();
			$group_id = isset($_POST['group_id'])?$_POST['group_id']:'';
			
			$data['group_name'] = !empty($_POST['group_name']) ? $_POST['group_name'] : show_message('请填写组名称','html','-1');
			$data_list = array();
			foreach($_POST['t'] as $key => $val ){
				$tid = $val;
				if(isset($_POST['t_'.$tid ]) && !empty($_POST['t_'.$tid ])){
					$tid_arr = $_POST['t_'.$tid ];
					$left = array();
					foreach($tid_arr as $k => $v){
						if($v != ''){
							$left[$v] = $v;
						}
					}
					$data_list[$val] = $left;
					unset($left);
				}
			}
		//	var_dump($data_list);die;
			if(!empty($data_list)){
				$data_list = serialize($data_list);
			}
			$data['model_control'] = $data_list;
			$data['admin_id'] = $_SESSION['admin_id'];
			if($group_id > 0){
				$data['update_time'] = time();
				$res = M('group')->where(array('group_id'=>$group_id))->update($data);
			}else{
				$data['add_time'] = time();
				$res = M('group')->insert($data);
			}
			
			if($res){
				show_message('操作成功','html','?act=group&op=group_list');
			}else{
				show_message('操作失败','html','-1');
			}
		}
		$weight = read_language('menu');
		$group = '';
		$group_id = isset($_GET['group_id']) ? intval($_GET['group_id']) : '' ;
		if($group_id > 0){
			$group = M('group')->where(array('group_id'=>$group_id))->find();
			if(!empty($group['model_control'])){
				$select = unserialize($group['model_control']);
				foreach($select as $key => $val){
					$weight['top'][$key][2] = 1;
					foreach($val as $k => $v){
						$weight['left'][$key][$k][2] = 1;
					}
				}
			}
		}
	//	var_dump($weight);
		self::output('weight',$weight);
		self::output('data',$group);
		self::display('group_edit');
	}
	
	public function group_del(){
		$group_id = isset($_GET['group_id']) ? intval($_GET['group_id']) : '' ;
		if($group_id > 0){
			$res = M('group')->where(array('group_id'=>$group_id))->del();
		}
		
		if($res){
			show_message('操作成功','html','?act=group&op=group_list');
		}else{
			show_message('操作失败','html','-1');
		}
	}
	
}