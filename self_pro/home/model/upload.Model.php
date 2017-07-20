<?php
if(!defined('PROJECT_NAME')) die('project empty');
class uploadModel{
	
	//上传
	public function upload(){
		//年月日时分+名字+ip +MD5 不会重名
		$ddd = date('Ymd');
		$path = BasePath.DS.'uploads'.DS.'fankui'.DS.$ddd.DS;
		
		$name = $_FILES['file']['name'];
		$aff = explode('.',$name);
		$file_type = end($aff);
		if(substr($name,0,5) == 'image'){
			$file_type = 'jpg';
		}
		$file_name = md5(date('YmdHi').$name.get_ip()).'.'.$file_type;
		if(!file_exists($path)){
			mkdir($path,0777);
		}
		
		if(preg_match("/png|jgeg|jpg|gif|bmp|JPG/",$file_type) == 0){
			echo json_encode(array('code'=>'-1','文件格式错误'));die;
		}
		
		//echo echo json_encode(array('code'=>'-1','path'=>$file_name));
		$up_file = new FileUpload();
		$is_up_file = $up_file
				->set('all_type',true)
		//		->set('allowtype',array("png","jgeg","jpg","gif","bmp"))
				->set('path',$path)
				->set('newname',$file_name)
				->upload('file');
		//echo json_encode(array('code'=>'1','path'=>$_FILES['file']['tmp_name']));die;
		if($is_up_file){
		//	echo json_encode(array('code'=>'1','path'=>preg_match("/png|jgeg|jpg|gif|bmp|JPG/",$file_type)));die;
			echo json_encode(array('code'=>'1','path'=>DS.'uploads'.DS.'fankui'.DS.$ddd.DS.$file_name));die;
		}else{
			echo json_encode(array('code'=>'-1','path'=>'undefined'));die;
		}
	}
}