<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	缓存管理
*/
class cacheControl extends sysControl{
	
	//清除缓存
	public function clearcache (){
		$data = $_POST['data'];
		if($data == 'all'){
			if(isset($_SESSION)){
				foreach($_SESSION as $key => $val){
					if($key != 'admin'){
						unset($_SESSION[$key]);
					}
				}
			}
			if(isset($_COOKIE)){
				unset($_COOKIE);
			}
		}
		echo json_encode(array('code' => '1','msg' => '清除成功'));die;
	}
}
?>