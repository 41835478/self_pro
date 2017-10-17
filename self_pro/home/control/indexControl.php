<?php
if(!defined('PROJECT_NAME')) die('project empty');
class indexControl extends baseControl{
	
	public function index(){
		self::display('index');
	}
}
?>