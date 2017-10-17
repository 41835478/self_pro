<?php
if(!defined('PROJECT_NAME')) die('project empty');
class navigationModel{
	public function get_navigation_info($cat_id,$images_state = 'url'){
		if(empty($cat_id) || intval($cat_id) <= 0){
			show_message('û���ҵ�����Ʒ','html','-1');
		}
		$navigation = M('navigation')->where(array('cat_id'=>$cat_id))->find();
		if(!empty($navigation)){
			//�������վ������ַ����ʽ����Ȼ����·������ʽ
			if($images_state == 'url'){
				$images_state = URL;
			}else if($images_state == 'path'){
				$images_state = BasePath;
			}
			if(!empty($navigation['cat_img'])){
				$navigation['cat_img'] = $images_state.DS.'uploads'.DS.'navigation'.DS.substr($navigation['cat_img'],0,8).DS.$navigation['cat_img'];
			}
			return $navigation;
		}
		return false;
	}
}