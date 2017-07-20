<?php
if(!defined('PROJECT_NAME')) die('project empty');
class settingModel{
	//获取页面配置
	public function get_web_config(){
		$web_config = M('setting')->where(array('name'=>'web_config'))->find();
		$web_config = unserialize($web_config['value']);
		return $web_config;
	}
	//获取微信配置
	public function get_wx_config(){
		$wx_config = M('setting')->where(array('name'=>'wx_config'))->find();
		$wx_config = unserialize($wx_config['value']);
		return $wx_config;
	}
}