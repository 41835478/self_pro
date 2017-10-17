<?php
if(!defined('PROJECT_NAME')) die('project empty');
$config['debug'] 	= false;
$config['home']  	= 'home'; //前台文件夹名称
$config['admin'] 	= 'admin'; //后台文件夹名称
$config['URL'] 		= 'http://'.$_SERVER['HTTP_HOST'];
$config['version'] 	= '2016.01.12';
$config['driver'] 	= 'mysql';
//数据库
$config['host'] 	= '127.0.0.1';
$config['user'] 	= 'root';
$config['pwd']  	= 'yushelian1709';
$config['db']   	= 'ysl';
$config['charset'] 	= 'UTF-8';
$config['port']		= '3306';

$config['language'] = 'zh_cn';

//前缀或者后缀
$config['affix']	= 'ysl_';
$config['left_affix']	= '';
$config['right_affix']	= '';

$config['session']	= true;
$config['mobile']	= isset($tpl_mobile)? $tpl_mobile : 'mobile';
$config['pc']		= isset($tpl_pc)? $tpl_pc : 'pc';;
/*  目前没有这些功能  */
$config['cache']	= false;

$config['redis']	= true;

//$config['memcache']	= true;

$config['memcache']['prefix']      = '';
$config['memcache'][1]['port']     = 11211;
$config['memcache'][1]['host']     = '127.0.0.1';
$config['memcache'][1]['pconnect'] = 0;

$config['static']	= true;

//压缩
$config['compress'] = false;
//是否开启nodejs
$config['nodejs']	= false;

//cookie前缀
$config['cookie_pre'] = '3BFF_';

?>