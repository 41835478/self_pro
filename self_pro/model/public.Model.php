<?php
if(!defined('PROJECT_NAME')) die('project empty');
class publicModel{
	
	private $category = null;
	
	public function __construct(){
		$this->category = M('category');
		$this->article_class = M('article_class');
		$this->wx_menu = M('wx_menu');
	}
	
	public function get_category(){
		$cat_list = M('category')->field('cat_id,cat_pid,cat_name,add_time,is_home_show,is_show')->where(array('cat_pid'=>0))->select();
		$cat_child = M('category')->where('cat_pid > 0')->select();
		$arr = array();
		if(!empty($cat_child)){
			foreach($cat_child as $key => $val){
				$arr[$val['cat_pid']][] = $val;
			}
		}
		
		if(count($cat_list) > 0){
			foreach($cat_list as $key => $val){
				$cat_list[$key]['list'] = $this->get_return($val,$arr);
			}
			
			return $cat_list;
		}
		return null;
	}
	
	public function get_article(){
		$article_list = M('article_class')->field('class_id,class_pid,class_name,add_time,is_home_show,is_show')->where(array('class_pid'=>0))->select();
		$article_child = M('article_class')->where('class_pid > 0')->select();
		$arr = array();
		if(!empty($article_child)){
			foreach($article_child as $key => $val){
				$arr[$val['class_pid']][] = $val;
			}
		}
		
		if(count($article_list) > 0){
			foreach($article_list as $key => $val){
				$article_list[$key]['list'] = $this->get_article_return($val,$arr);
			}
			
			return $article_list;
		}
		return null;
	}
	
	public function get_navigation(){
		$cat_list = M('navigation')->field('cat_id,cat_pid,cat_name,add_time,is_home_show,is_show')->where(array('cat_pid'=>0))->select();
		$cat_child = M('navigation')->where('cat_pid > 0')->select();
		$arr = array();
		if(!empty($cat_child)){
			foreach($cat_child as $key => $val){
				$arr[$val['cat_pid']][] = $val;
			}
		}
		
		if(count($cat_list) > 0){
			foreach($cat_list as $key => $val){
				$cat_list[$key]['list'] = $this->get_return($val,$arr);
			}
			
			return $cat_list;
		}
		return null;
	}
	
	//获取分类
	public function get_return($arr,$arr2){
	//	$res = $this->category->field('cat_id,cat_name,cat_pid')->where(array('cat_pid'=>$arr['cat_id']))->select();
		$res = '';
		if(empty($arr2)){
			$res = $this->category->field('cat_id,cat_name,cat_pid,add_time,is_home_show,is_show')->where(array('cat_pid'=>$arr['cat_id']))->select();
		}else{
			if(isset($arr2[$arr['cat_id']])){
				$res = $arr2[$arr['cat_id']];
			}
		}
		
		if(!empty($res)){
			foreach($res as $k => $v){
				if(isset($arr['nbsp'])){
					$res[$k]['nbsp'] = '&nbsp;&nbsp;&nbsp;'.$arr['nbsp'];
					$v['nbsp'] = '&nbsp;&nbsp;&nbsp;'.$arr['nbsp'];
					$res[$k]['cat_name'] = $v['nbsp'].'┝&nbsp;'.$v['cat_name'];
				}else{
					$res[$k]['nbsp'] = '&nbsp;&nbsp;&nbsp;';
					$v['nbsp'] = '&nbsp;&nbsp;&nbsp;';
					$res[$k]['cat_name'] = $v['nbsp'].'┝&nbsp;'.$v['cat_name'];
				}
				$res[$k]['list'] = $this->get_return($v,$arr2);
			}
		}
		return $res;
	}
	
	//获取文章分类
	public function get_article_return($arr,$arr2){
	//	$res = $this->article_class->field('cat_id,cat_name,cat_pid')->where(array('cat_pid'=>$arr['cat_id']))->select();
		$res = '';
		if(empty($arr2)){
			$res = $this->article_class->field('class_id,class_name,class_pid,add_time,is_home_show,is_show')->where(array('class_pid'=>$arr['class_id']))->select();
		}else{
			if(isset($arr2[$arr['class_id']])){
				$res = $arr2[$arr['class_id']];
			}
		}
		
		if(!empty($res)){
			foreach($res as $k => $v){
				if(isset($arr['nbsp'])){
					$res[$k]['nbsp'] = '&nbsp;&nbsp;&nbsp;'.$arr['nbsp'];
					$v['nbsp'] = '&nbsp;&nbsp;&nbsp;'.$arr['nbsp'];
					$res[$k]['class_name'] = $v['nbsp'].'┝&nbsp;'.$v['class_name'];
				}else{
					$res[$k]['nbsp'] = '&nbsp;&nbsp;&nbsp;';
					$v['nbsp'] = '&nbsp;&nbsp;&nbsp;';
					$res[$k]['class_name'] = $v['nbsp'].'┝&nbsp;'.$v['class_name'];
				}
				$res[$k]['list'] = $this->get_return($v,$arr2);
			}
		}
		return $res;
	}
	
	public function get_wx_menu(){
		$wx_list = M('wx_menu')->field('wx_id,wx_pid,wx_name,add_time,is_home_show,is_show')->where(array('wx_pid'=>0))->select();
		$wx_child = M('wx_menu')->where('wx_pid > 0')->select();
		$arr = array();
		if(!empty($wx_child)){
			foreach($wx_child as $key => $val){
				$arr[$val['wx_pid']][] = $val;
			}
		}
		
		if(count($wx_list) > 0){
			foreach($wx_list as $key => $val){
				$wx_list[$key]['list'] = $this->get_wx_return($val,$arr);
			}
			
			return $wx_list;
		}
		return null;
	}
	
	//获取分类
	public function get_wx_return($arr,$arr2){
	//	$res = $this->wxegory->field('wx_id,wx_name,wx_pid')->where(array('wx_pid'=>$arr['wx_id']))->select();
		$res = '';
		if(empty($arr2)){
			$res = $this->wx_menu->field('wx_id,wx_name,wx_pid,add_time,is_home_show,is_show')->where(array('wx_pid'=>$arr['wx_id']))->select();
		}else{
			if(isset($arr2[$arr['wx_id']])){
				$res = $arr2[$arr['wx_id']];
			}
		}
		
		if(!empty($res)){
			foreach($res as $k => $v){
				if(isset($arr['nbsp'])){
					$res[$k]['nbsp'] = '&nbsp;&nbsp;&nbsp;'.$arr['nbsp'];
					$v['nbsp'] = '&nbsp;&nbsp;&nbsp;'.$arr['nbsp'];
					$res[$k]['wx_name'] = $v['nbsp'].'┝&nbsp;'.$v['wx_name'];
				}else{
					$res[$k]['nbsp'] = '&nbsp;&nbsp;&nbsp;';
					$v['nbsp'] = '&nbsp;&nbsp;&nbsp;';
					$res[$k]['wx_name'] = $v['nbsp'].'┝&nbsp;'.$v['wx_name'];
				}
				$res[$k]['list'] = $this->get_wx_return($v,$arr2);
			}
		}
		return $res;
	}
	
	
}
