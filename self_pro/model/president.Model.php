<?php
if(!defined('PROJECT_NAME')) die('project empty');
class presidentModel{
	public function get_president($w = array()){
		$data = array();
		// 4,5  4副社长 5社长
		$where = array(
			'is_del' 	=> '0',
			'role_id' 	=> 'in 4,5',
		);
		$user = M('user')
				->field('id,name,image,u_label2')
				->where($where)
				->order('create_time desc')
				->select();
		if(!empty($user)){
			foreach($user as & $val){
				if(!empty($val['u_label2'])){
					$val['u_label2'] = explode(',',$val['u_label2']);
				}
			}
		}
		$data = $user;
		return $data;
	}
}