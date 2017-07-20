<?php
$time1 = microtime();
//我把提交的字符串中的空格替换成了&nbsp //拿数据的时候如果要修改的话，反替换一下
require_once 'public.php';
require_once 'config.ini.php';
require_once 'global.ini.php';
require_once WORK.DS.'include'.DS.'init.php';

if($config['debug']){ //测试一下使用时间
	$time2 = microtime();
	echo $time2-$time1;
}

?>