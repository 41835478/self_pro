<?php
if(!defined('PROJECT_NAME')) die('project empty');
class userModel{
	//获取用户信息
	public function find($id = ''){
		if(empty($id)){
			return null;
		}
		$data = array();
		$where = array(
			'id' => $id,
		);
		$user = M('user')->where($where)->find();
		$label = array();
		if(!empty($user['label2'])){
			$label2 = explode(',',$user['label2']);
			$label = $label2;
		}
		if(!empty($user) && !empty($user['u_label'])){
			$labels = M('user_label')->where(array('is_del' => '0' , 'id' => 'in '.$user['u_label']))->select();
			if(!empty($label)){
				$label3 = array();
				foreach( $labels as $key => $val){
					$label[] = $val['name'];
					$label3[] = $val['name'];
				}
				$user['u_label']['list'] = $label3;
				$user['u_label3'] = $label;
			}
		}
		
		if($user['c_id'] > 0){
			$community_where = array(
				'id' => $user['c_id'],
			);
			$community = M('community')->where($community_where)->find();
			if(!empty($community)){
				$user['community'] = $community;
			}
		}
		$guanzhu_where = array(
			'is_del'  => '0',
			'is_open' => '1',
			'u_id' 	  => $id,
		);
		$guanzhu = M('userAuser')->where($guanzhu_where)->count();
		
		$guanzhu_where = array(
			'is_del'  => '0',
			'is_open' => '1',
			'p_id' 	  => $id,
		);
		
		$fensi = M('userAuser')->where($fensi_where)->count();
		$user['guanzhu'] = $guanzhu;
		$user['fensi'] = $fensi;
		$data = $user;
		return $data;
	}
	
	//获取用户资源
	public function get_goods($id = ''){
		$where = array(
			'is_del' 	=> '0',
			'is_show'	=>	'1',
			'u_id'		=>	$id,
		);
		$goods = M('goods')
					->where($where)
					->order('create_time desc')
					->limit(999)
					->select();
		if(!empty($goods)){
			foreach($goods as & $val){
				if(!empty($val['images'])){
					$val['images'] = explode(',',$val['images']);
				}
			}
		}
		$data = $goods;
		return $data;
	}
}