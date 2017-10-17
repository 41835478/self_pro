<?php
if(!defined('PROJECT_NAME')) die('project empty');
class navModel{
	public function get_nav($w = array()){
		$data = array();
		$where = array(
		);
		$nav = M('mobile_menu')
				->where($where)
				->order('m_sort asc')
				->select();
		$data = $nav;
		return $data;
	}
}