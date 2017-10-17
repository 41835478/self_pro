<?php
if(!defined('PROJECT_NAME')) die('project empty');
class uploadControl extends sysControl{
	public function web_upload(){
		M('upload',true)->upload();
	}
	
	public function image_del(){
		exit(json_encode(array('code'=>true)));die;
		$file_path = $_POST['file_path'];
		if(file_exists(BasePath.$file_path)){
			$res = rm_file(BasePath.$file_path);
			exit(json_encode(array('code'=>$res)));
		}
		exit(json_encode(array('code'=>'-1')));
	}
}
?>