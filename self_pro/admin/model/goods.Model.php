<?php
if(!defined('PROJECT_NAME')) die('project empty');
class goodsModel{
	public function get_goods_info($goods_id,$images_state = 'url'){
		if(empty($goods_id) || intval($goods_id) <= 0){
			show_message('没有找到该商品','html','-1');
		}
		$goods = M('goods')->where(array('goods_id'=>$goods_id))->find();
		if(!empty($goods)){
			//如果是网站就用网址的形式，不然就用路径的形式
			if($images_state == 'url'){
				$images_state = URL;
			}else if($images_state == 'path'){
				$images_state = BasePath;
			}
			if(!empty($goods['goods_img'])){
				$goods['goods_img'] = $images_state.DS.'uploads'.DS.'goods'.DS.substr($goods['goods_img'],0,8).DS.$goods['goods_img'];
			}
			if(!empty($goods['goods_images'])){
				$goods['goods_images'] = explode(',',$goods['goods_images']);
				foreach($goods['goods_images'] as $key => $val){
					$goods['goods_images'][$key] = $images_state.DS.'uploads'.DS.'goods'.DS.substr($val,0,8).DS.$val;
				}
			}
			if(!empty($goods['start_time'])){
				$start_time = array();
				$start_time = date_un($goods['start_time']);
				$goods['start_day'] = $start_time['day'];
				$goods['start_hour'] = $start_time['hour'];
			}
			if(!empty($goods['end_time'])){
				$end_time = array();
				$end_time = date_un($goods['end_time']);
				$goods['end_day'] = $end_time['day'];
				$goods['end_hour'] = $end_time['hour'];
			}
			if(!empty($goods['editorValue'])){
				$goods['editorValue'] = str_replace_baidu($goods['editorValue']);
			}
			
			return $goods;
		}
		return false;
	}
}