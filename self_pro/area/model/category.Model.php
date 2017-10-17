<?php
if(!defined('PROJECT_NAME')) die('project empty');
class categoryModel{
	public function get_category_info($cat_id,$images_state = 'url'){
		if(empty($cat_id) || intval($cat_id) <= 0){
			show_message('没有找到该商品','html','-1');
		}
		$category = M('category')->where(array('cat_id'=>$cat_id))->find();
		if(!empty($category)){
			//如果是网站就用网址的形式，不然就用路径的形式
			if($images_state == 'url'){
				$images_state = URL;
			}else if($images_state == 'path'){
				$images_state = BasePath;
			}
			if(!empty($category['cat_img'])){
				$category['cat_img'] = $images_state.DS.'uploads'.DS.'category'.DS.substr($category['cat_img'],0,8).DS.$category['cat_img'];
			}
			return $category;
		}
		return false;
	}
}