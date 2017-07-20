<?php
if(!defined('PROJECT_NAME')) die('project empty');
class advModel{
	
	//获取广告
	public function find($id = ''){
		if(intval($id) > 0){
			$data = M('adv')->where(array('adv_id' => $id))->find();
			if(!empty($data['images'])){
				$data['images'] = explode(',',$data['images']);
				foreach($data['images'] as $key => $val){
					$data['images'][$key] = get_img($val,'adv');
				}
			}
		}
		return $data;
	}
	
}