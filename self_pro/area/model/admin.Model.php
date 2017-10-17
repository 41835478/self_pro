<?php
if(!defined('PROJECT_NAME')) die('project empty');

//后台用户model
class adminModel{
	
	//获取用户
	public function get_admin($admin_id){
		$data = M('admin')->where(array('admin_id' => $admin_id))->find();
		/*
		if(!empty($data) && !empty($data['con_weight'])){
			$data['con_weight'] = unserialize($data['con_weight']);
		}
		*/
		if(!empty($data['admin_logo'])){
			$data['admin_logo'] = get_img($data['admin_logo'],'admin');
			
		}
		
		return $data;
	}
	
	//获取用户权限
	public function get_weight($data){
		$where = array(
			'admin_list' => 'like %,'.$data['admin_id'].',%',
		);
		$group_weight = M('group')->where($where)->find();
		if(!empty($group_weight)){  //先拿组控制
			$weight = $group_weight['con_weight'];
			return $weight;
		}
		if($data['admin_pid'] > 0){
		//	$data['con_weight'] = unserialize($data['con_weight']);
			$menu = read_language('menu');
			$my_weight = array();
			if(!empty($data['con_weight'])){
				foreach($data['con_weight']['top'] as $key => $val){
					$my_weight['top'][$val] = $menu['top'][$val];
				}
				foreach($data['con_weight']['left'] as $k => $v){
					$list = explode(',',$v);
					foreach($list  as $lk => $lv){
						$my_weight['left'][$k][$lv] = $menu['left'][$k][$lv];
						$my_weight['left'][$k][$lv][2] = true;
					}
				}
			}
			return $my_weight;
		}
		if($data['admin_pid'] == 0){
			$weight = read_language('menu');
			foreach($weight['left'] as $key => $list){
				foreach($list as $k => $v){
					$weight['left'][$key][$k][2] = true;
				}
			}
			return $weight;
		}
		return false;
	}
	
	//是否是下级管理员
	public function is_d_admin($admin_id,$my_id){
		$d_admin = M('admin')->where(array('admin_id'=>$admin_id))->find();
		if($d_admin['admin_pid'] != $my_id){
			show_message('没有该权限','html','-1');
		}
	}
	/*
		$data1是下级,$data2是自己
	*/
	public function get_d_weight($data1,$data2){
		if(!is_array($data1) || !is_array($data2)){
			return false;
		}
		foreach($data2['left'] as $key => $list){
			foreach($list as $k => $v){
				if(!isset($data1['left'][$key][$k][2])){
					unset($data2['left'][$key][$k][2]);
				}
			}
		}
		return $data2;
	}
}