<?php
if(!defined('PROJECT_NAME')) die('project empty');
/*
	time 	2017-10-12
	auth	李凯
*/
class Model{
	private $config = null;
	private static $link = null;
	public function __construct(){
		global $config;
		$this->config = $config;
		self::connect($config);
		self::charset($config);
		//self::getInstance();
	}
	static public function connect($config){
		if(empty($config['host']) || empty($config['user']) || empty($config['db'])){
			$error = 'mysql host user pwd db error';
			show_message($error);
		} 
		if(!$config['port']){
			$config['port'] = 3306;
		}
		if(empty($config['driver'])){
			$error = 'mysql driver error';
			show_message($error);
		}

		switch ($config['driver']) {
			case 'mysql':
						$link = @mysql_connect($config['host'].':'.$config['port'],$config['user'],$config['pwd']);
						if(!$link){ // 链接localhost
						$link = @mysql_connect('localhost'.':'.$config['port'],$config['user'],$config['pwd']);
							if(!$link){
								show_message('sql link error');
							}
						}
						
						$db = @mysql_select_db($config['db'],$link);
						if(!$db){
							show_message('select db error');
						}
				break;
			case 'mysqli':
						$link = @mysqli_connect($config['host'].':'.$config['port'],$config['user'],$config['pwd'],$config['db']);
						if(!$link){ // 链接localhost
							$link = @mysqli_connect('localhost'.':'.$config['port'],$config['user'],$config['pwd'],$config['db']);
							if(!$link){
								show_message('sql link error');
							}
						}
						self::$link = $link;
				break;
			default :
						show_message('sql server error');
				break;
		}
		
	}
	
	static public function charset($config){

		switch ($config['driver']) {
			case 'mysql':
					if($config['charset'] == 'UTF-8' || $config['charset'] == 'UTF8' || $config['charset'] == 'utf-8' || $config['charset'] == 'utf8'){
						$query_string = " SET CHARACTER_SET_CLIENT = utf8,CHARACTER_SET_CONNECTION = utf8,CHARACTER_SET_DATABASE = utf8,CHARACTER_SET_RESULTS = utf8,CHARACTER_SET_SERVER = utf8,COLLATION_CONNECTION = utf8_general_ci,COLLATION_DATABASE = utf8_general_ci,COLLATION_SERVER = utf8_general_ci,sql_mode=''";
						mysql_query('SET NAMES UTF8');
					}else if(strtoupper($config['charset']) == 'gbk' || strtoupper($config['charset']) == 'GBK'){
						$query_string = " SET CHARACTER_SET_CLIENT = gbk,CHARACTER_SET_CONNECTION = gbk,CHARACTER_SET_DATABASE = gbk,CHARACTER_SET_RESULTS = gbk,CHARACTER_SET_SERVER = gbk,COLLATION_CONNECTION = gbk_chinese_ci,COLLATION_DATABASE = gbk_chinese_ci,COLLATION_SERVER = gbk_chinese_ci,sql_mode=''";
						mysql_query('SET NAMES GBK');
					}
					if(isset($query_string)){
						mysql_query($query_string);
					}
				break;
			case 'mysqli':
					if($config['charset'] == 'UTF-8' || $config['charset'] == 'UTF8' || $config['charset'] == 'utf-8' || $config['charset'] == 'utf8'){
						$query_string = " SET CHARACTER_SET_CLIENT = utf8,CHARACTER_SET_CONNECTION = utf8,CHARACTER_SET_DATABASE = utf8,CHARACTER_SET_RESULTS = utf8,CHARACTER_SET_SERVER = utf8,COLLATION_CONNECTION = utf8_general_ci,COLLATION_DATABASE = utf8_general_ci,COLLATION_SERVER = utf8_general_ci,sql_mode=''";
						mysqli_query(self::$link,'SET NAMES UTF8');
					}else if(strtoupper($config['charset']) == 'gbk' || strtoupper($config['charset']) == 'GBK'){
						$query_string = " SET CHARACTER_SET_CLIENT = gbk,CHARACTER_SET_CONNECTION = gbk,CHARACTER_SET_DATABASE = gbk,CHARACTER_SET_RESULTS = gbk,CHARACTER_SET_SERVER = gbk,COLLATION_CONNECTION = gbk_chinese_ci,COLLATION_DATABASE = gbk_chinese_ci,COLLATION_SERVER = gbk_chinese_ci,sql_mode=''";
						mysqli_query(self::$link,'SET NAMES GBK');
					}
					if(isset($query_string)){
						mysqli_query(self::$link,$query_string);
					}
				break;
			default:
					show_message('sql charset error');
				break;
		}
		
		
	}
	
	//实例化一个
	public function getInstance($table='')
	{
		
		$config = $this->config;
		$obj = null;
		if(empty($config['driver'])){
			$error = '$config[\'driver\'] is not set';
			show_message($error);
		}
		$path = BasePath.DS.WORK.DS.'include'.DS.'DB'.DS.$config['driver'].'.php';
		if(!file_exists($path)){
			$error = $path.' is exist';
			show_message($error);
		}
		include_once $path;
		if($config['driver']){
			$obj = new $config['driver']($table);
			return $obj;
		}else{
			$error = 'sql instance fail';
			show_message($error);
		}
		return $obj;
	}
}
?>