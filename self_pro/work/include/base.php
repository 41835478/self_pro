<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	time 	2017-10-12
	auth	李凯
*/
class base{
	public static function init(){
		setTimeZone(8); //时区设置
		session_start();
		self::run();  //执行控制器脚本
	}
	
	public static function run(){
		if(!isset($_GET['act'])){
			$_GET['act'] = 'index';
		}
		$class  = $_GET['act'].'Control';
		$path = BasePath.DS.PROJECT.DS.'control'.DS.$class.'.php'; //控制器路径
		
		if(!file_exists($path)){
			$error = $path.' null';
			show_message($error);
		}
		
		//判断是否有初始base控制器
		$basepath = BasePath.DS.PROJECT.DS.'control'.DS.'baseControl.php';
		if(file_exists($basepath)){
			include $basepath;
		}
		//引入控制器
		include $path;
		if(!class_exists($class)){
			$error = $class.' exists';
			show_message($error);
		}
		$control = new $class();
		$method = isset($_GET['op']) ? $_GET['op'] : 'index';
		
		if(!method_exists($class,$method)){
			$error = 'class '.$class.' function_exists '.$method.' exists';
			show_message($error);
		}
		
	//	var_dump($control);die;
		$control->$method();
	}
}
?>