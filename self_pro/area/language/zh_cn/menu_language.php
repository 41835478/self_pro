<?php
if(!defined('PROJECT_NAME')) die('project empty');
//说明：顶部有15个，left数组对应15个数组  top对应控制器  left对应方法
//第二个可以用标签的属性，具体需要，自行修改
$language['top'] = array(
	'0'=>array('首页',array('style' => 'display:none')),
	'1'=>array('社区'),
	'2'=>array('资源'),
	'3'=>array('活动'),
	'4'=>array('求助'),
	'5'=>array('用户管理'),
	/*
	'3'=>array('导航'),
	'4'=>array('管理员管理'),
	'5'=>array('用户管理'),
	'6'=>array('系统设置'),
	'7'=>array('友情链接'),
	'8'=>array('短信配置'),
	*/
	);
//第三个可以用标签的属性
$language['left'] = array(
	'0' => array(
		'0'=> array('首页','?act=index&op=index',array()),
		'1'=> array('欢迎页','?act=index&op=welcome',array()),
	), 
	'1' => array(
		'0'=> array('社区','?act=community&op=community_list'),
	//	'1'=> array('虚拟社区','?act=community&op=community_flist'),
		'2'=> array('社区分类','?act=cat&op=cat_list'),
	), 
	'2' => array(
		'0'=> array('资源列表','?act=goods&op=goods_list'),
		'2'=> array('资源分类','?act=goods_cat&op=goods_cat_list'),
	), 
	'3' => array(
		'0'=> array('活动列表','?act=activity&op=activity_list'),
	), 
	'4' => array(
		'0'=> array('活动列表','?act=helpInfo&op=helpInfo_list'),
	), 
	'5' => array(
		'0'=> array('用户列表','?act=user&op=user_list'),
	),
);
?> 