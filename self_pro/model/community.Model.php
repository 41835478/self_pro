<?php
if(!defined('PROJECT_NAME')) die('project empty');
class communityModel{
	
	//获取社区全部资源
	public function get_goods($u_ids = ''){
		$data = array();
		$where = array(
				'__AFFIX__goods.u_id'=> 'in '.$u_ids , 
				'__AFFIX__goods.is_del' => '0',
				);
		$goods = M('goods')
				->field('__AFFIX__goods.*,__AFFIX__user.name as nickname,__AFFIX__user.image as u_logo')
				->join('left __AFFIX__user','__AFFIX__goods.u_id = __AFFIX__user.id')
				->where($where)
				->order('create_time desc')
				->select();
		if(!empty($goods)){
			foreach($goods as & $val){
				$val['create_time2'] = d_time($val['create_time']);
			}
		}
		$data = $goods;
		return $data;
	}
	
	//获取社区全部求助信息
	public function get_helpinfo($u_ids = ''){
		$data = array();
		$helpInfo = M('helpInfo')
				->where(array('u_id'=> 'in '.$u_ids , 'is_del' => '0'))
				->order('create_time desc')
				->select();
		if(!empty($helpInfo)){
			foreach($helpInfo as & $val){
				$val['create_time2'] = d_time($val['create_time']);
			}
		}
		$data = $helpInfo;
		return $data;
	}
	//获取社区全部活动
	public function get_activity($u_ids = ''){
		$data = array();
		$activity = M('activity')
				->where(array('u_id'=> 'in '.$u_ids , 'is_del' => '0'))
				->order('create_time desc')
				->select();
		if(!empty($activity)){
			foreach($activity as & $val){
				$val['create_time2'] = d_time($val['create_time']);
			}
		}
		$data = $activity;
		return $data;
	}
}