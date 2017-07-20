<?php
if(!defined('PROJECT_NAME')) die('project empty');
class categoryModel{
	public function get_category_info($cat_id,$images_state = 'url'){
		if(empty($cat_id) || intval($cat_id) <= 0){
			show_message('û���ҵ�����Ʒ','html','-1');
		}
		$category = M('category')->where(array('cat_id'=>$cat_id))->find();
		if(!empty($category)){
			//�������վ������ַ����ʽ����Ȼ����·������ʽ
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