<?php
if(!defined('PROJECT_NAME')) die('project empty');
class uploadControl extends baseControl{
	public function web_upload(){
		M('upload',true)->upload();
	}
}
?>