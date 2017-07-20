<?php
if(!defined('PROJECT_NAME')) die('project empty');
class storeModel{
	
	//首页获取店铺
	public function get_store_index_list(){
		$store_list = M('store')->where(array('is_open'=>1))->order('label asc')->select();
		if(!empty($store_list)){
			foreach($store_list as $key => $val){
				//获取图片
				if(!empty($val['store_imgs'])){
					$images = explode(',',$val['store_imgs']);
					$images2 = array();
					if(count($images) > 3){
						$images2[] = $images[0];
						$images2[] = $images[1];
						$images2[] = $images[2];
					}else{
						$images2 = $images;
					}
					foreach($images2 as $k => $v){
						$images2[$k] = get_img($v,'store');
					}
					$store_list[$key]['store_imgs'] = $images2;
				}
			}
		}
		return $store_list;
	}
}