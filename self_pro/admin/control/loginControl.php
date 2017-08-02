<?php

if(!defined('PROJECT_NAME')) die('project empty');
class loginControl extends Control{
	public function login(){
		self::display('login');
	}
}
?>