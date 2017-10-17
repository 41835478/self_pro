<?php
if(!defined('PROJECT_NAME')) die('project empty');
class article_classModel{
	public function get_article_info($article_id,$images_state = 'url'){
		if(empty($article_id) || intval($article_id) <= 0){
			show_message('û���ҵ�����Ʒ','html','-1');
		}
		$article = M('article_class')->where(array('class_id'=>$article_id))->find();
		if(!empty($article)){
			//�������վ������ַ����ʽ����Ȼ����·������ʽ
			if($images_state == 'url'){
				$images_state = URL;
			}else if($images_state == 'path'){
				$images_state = BasePath;
			}
			if(!empty($article['class_img'])){
				$article['class_img'] = $images_state.DS.'uploads'.DS.'article'.DS.substr($article['class_img'],0,8).DS.$article['class_img'];
			}
			return $article;
		}
		return false;
	}
}