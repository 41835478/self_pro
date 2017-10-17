<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	time 	2017-10-12
	auth	李凯
	防xss攻击
*/
include 'security.php';
include 'fun.php';  //引入通用函数
include 'control.php';
include 'base.php';
$base = new base();
$base::init();
?>