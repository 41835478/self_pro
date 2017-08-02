<?php
if(!defined('PROJECT_NAME')) die('project empty');
class systemControl extends sysControl{
	
	public function system_setting(){
		self::display("system_setting");
	}
	
	public function web_conf(){
		if($_POST){
			var_dump($_POST);die;
		}
	}
}
?>