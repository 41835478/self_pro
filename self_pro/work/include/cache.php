<?php
if(!defined('PROJECT_NAME')) die('project empty');
class cache{
	private $path = '';
	/*
	*$path 写入路径
	*/
	public function __construct($path){
		$path = BasePath.DS.PROJECT.DS.'cache'.DS.$path;
		$this->path = $path;
	}
	//写缓存
	public function w_cache($data=array()){
		if(empty($data) || !is_array($data)){
			return false;
		}
		if(file_exists($this->path)){
			return true;
		}else{
			mk_dir(dirname($this->path));
			$str = serialize($data);
			$str = en_key($str,KEY);
			$w = file_put_contents($this->path,$str,LOCK_EX);
			if($w){
				return true;
			}else{
				return false;
			}
		}
	}
	//读缓存
	public function r_cache(){
		if(!file_exists($this->path)){
			return false;
		}
		$str = file_get_contents($this->path);
		$str = de_key($str,KEY);
		$data = unserialize($str);
		if(empty($data)){
			return false;
		}
		return $data;
	}
	//清缓存
	public function c_cache($path = ''){
		if(!file_exists($path)){
			rm_dir(BasePath.DS.PROJECT.DS.'cache'.DS);
			//创建一个目录
			mkdir(BasePath.DS.PROJECT.DS.'cache');
		}else{
			rm_dir($path);
		}
	}
}

?>