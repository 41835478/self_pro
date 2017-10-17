<?php
if(!defined('PROJECT_NAME')) die('project empty');
class advModel{
	public function get_adv($w = array()){
		$data = array();
		$where = array(
			'is_del' 	=> '0',
			'is_open' 	=> '1',
			'type' 		=> '0',
		);
		$adv = M('adv')->where($where)->select();
		$data = $adv;
		return $data;
	}
}