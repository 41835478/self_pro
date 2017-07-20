<?php
if(!defined('PROJECT_NAME')) die('project empty');
//前台项目
!defined('PROJECT')?define('PROJECT','home'):'';
define('KEY','825f5a51fd0ba14fdfbaead0bf87a34e'); //md5加密key
define('SECRET_KEY','825f5a51fd0');  			  //这个不能修改
//android 手机验证
//echo $_SERVER['HTTP_USER_AGENT'];die;
//$is_mobile = '/Android|iPhone/';
//var_dump($_SERVER);die;
$is_mobile_bool = @preg_match($is_mobile,isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'');
$is_mobile_bool ? define('WEB',$config['mobile']) : define('WEB',$config['pc']);
//斜杠
define('DS','/');
//全局本站地址
define('URL',$config['URL']);
//当前地址
define('URL_VAL',$_SERVER['QUERY_STRING']);
//当前地址
define('CURRENT_URL','index.php?'.URL_VAL);
//项目位置
define('BasePath',__DIR__);
//核心代码地址
define('WORK','work');
//字符设置
define('CHARSET','utf-8');
//资源地址
define('RES',$config['URL'].DS.'res'.DS);
//js位置
define('RES_JS',RES.'js');
//插件目录
define('PLUGINS','plugins');
//模版css位置
define('CSS',URL.DS.PROJECT.DS.'tpl'.DS.WEB.DS.'css');
//模版images位置
define('IMG',DS.PROJECT.DS.'tpl'.DS.WEB.DS.'images');
//模版js位置
define('JS',URL.DS.PROJECT.DS.'tpl'.DS.WEB.DS.'js');
//其他
define('OTHER',URL.DS.PROJECT.DS.'tpl'.DS.WEB.DS.'other');
//模板
define('TPL',URL.DS.PROJECT.DS.'tpl'.DS.WEB.DS);
//自定义公用文件目录
define('COMMON', 'common');
//上传文件目录
define('UPLOADS', 'uploads'.DS);
?>