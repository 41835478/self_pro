<?php
if(!defined('PROJECT_NAME')) die('project empty');
header("Content-type: text/html; charset=utf-8");
define('INTERFACE_TYPE','json');
include (__dir__).'/../config.ini.php';
include (__dir__).'/../global.ini.php';
include BasePath.DS.WORK.DS.'include'.DS.'security.php';
include BasePath.DS.WORK.DS.'include'.DS.'fun.php';
setTimeZone(8); //时区设置
session_start();
?>