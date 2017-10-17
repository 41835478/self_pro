<?php
if(!defined('PROJECT_NAME')) die('project empty');
//说明：顶部有15个，left数组对应15个数组  top对应控制器  left对应方法
//第二个可以用标签的属性，具体需要，自行修改
$language['top'] = array(
	'0'=>array('首页',array('style' => 'display:none')),
	'1'=>array('社区'),
	'2'=>array('资源'),
	'3'=>array('导航'),
	'4'=>array('管理员管理'),
	'5'=>array('用户管理'),
	'6'=>array('广告管理'),
	'7'=>array('系统设置'),
	'8'=>array('友情链接'),
	'9'=>array('短信配置'),
	'10'=>array('手机首页菜单'),
	);
//第三个可以用标签的属性
$language['left'] = array(
	'0' => array(
		'0'=> array('首页','?act=index&op=index',array()),
		'1'=> array('欢迎页','?act=index&op=welcome',array()),
	), 
	'1' => array(
		'0'=> array('社区列表','?act=community&op=community_list'),
		'1'=> array('虚拟社区','?act=community&op=community_flist'),
		'2'=> array('社区分类','?act=cat&op=cat_list'),
	), 
	'2' => array(
		'0'=> array('资源列表','?act=goods&op=goods_list'),
		'1'=> array('资源分类','?act=goods_cat&op=goods_cat_list'),
	), 
	'3' => array(
		'0'=> array('导航列表','?act=nav&op=nav_list'),
	), 
	'4' => array(
		'0'=> array('管理员列表','?act=admin&op=admin_list'),
		'1'=> array('管理员操作日志','?act=admin&op=admin_log_list'),
	), 
	'5' => array(
		'0'=> array('用户列表','?act=user&op=user_list'),
		'1'=> array('等级设定','?act=lv&op=lv_list'),
		'2'=> array('角色权限设置','?act=role&op=role_list'),
		'3'=> array('用户标签','?act=label&op=user_label_list'),
	),
	'6' => array(
		'0'=> array('广告列表','?act=adv&op=adv_list'),
	),
	'7' => array(
		'0'=> array('系统设置','?act=system&op=system_setting'),
		'1'=> array('系统变量','?act=value&op=value_list'),
		'2'=> array('地区列表','?act=area&op=area_list'),
		'3'=> array('支付配置','?act=payment&op=payment_index'),
	),
	'8' => array(
		'0'=> array('友情链接','?act=link&op=link_list'),
	),
	'9' => array(
		'0'=> array('短信配置','?act=short&op=short_message'),
	),
	'10' => array(
		'0'=> array('菜单列表','?act=mobile&op=mobile_menu'),
	),
);
?> 