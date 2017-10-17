<?php
if(!defined('PROJECT_NAME')) die('project empty');
//微信接口
class wechatControl extends baseControl{
	
	public $weixin = null;
	
	public function __construct(){
		$type = $this->init();
		$this->run($type);
	}
	
	public function init(){
		$wechat = M('config')->where(array('name'=>'wx_pay'))->find();
		
		if($wechat['is_open'] != 0){
			die;
		}
		$config = unserialize($wechat['value']);
		include BasePath.DS."plugins".DS."wechat".DS."wechat.class.php";
		
		$options = array(
				'token'=> trim($config['token']), //填写你设定的key
				'encodingaeskey'=> trim($config['EncodingAESKey']), //填写加密用的EncodingAESKey，如接口为明文模式可忽略
				'appid'=>trim($config['app_id']), //填写高级调用功能的app id
				'appsecret'=>trim($config['appsecret']), //填写高级调用功能的密钥
			);
		$weObj = new Wechat($options);
		$this->weixin = $weObj;
		$weObj->valid();//明文或兼容模式可以在接口验证通过后注释此句，但加密模式一定不能注释，否则会验证失败
		$type = $weObj->getRev()->getRevType();
		
		return $type;
	}
	
	private function run($type){
	//	file_put_contents(BasePath.DS.'aaa.txt',$type);
		switch($type) {
			case Wechat::MSGTYPE_TEXT:
					$str = '如预订上遇到任何疑问可添加我们客服微信：yangzai0712,黑眼圈潮趴馆竭诚为您服务！';
					$this->weixin->text($str)->reply();
					break;
			case Wechat::MSGTYPE_EVENT:  //事件
					$event_type = $this->weixin->getRev()->getRevEvent();  //event_type 是数组
					$this->event($event_type['event']);
					break;
			case Wechat::MSGTYPE_IMAGE:
					break;
			default:
					$this->weixin->text("出错了")->reply();
		}
	}
	
	//EVENT事件处理
	private function event($event){
	//	$this->weixin->text(Wechat::EVENT_SUBSCRIBE.'-'.$event)->reply();
		switch($event) {
			case Wechat::EVENT_SUBSCRIBE:  //关注
					$getRevFrom = $this->weixin->getRevFrom();  //openid
				//	$getRevTo = $this->weixin->getRevTo();		//原始ID
					$user = M('user')->where(array('openid'=>$getRevFrom))->find();
					$access_token = $this->weixin->checkAuth();
					$url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$getRevFrom.'&lang=zh_CN';
					$wx_user = $this->weixin->http_get($url);
					$wx_user = json_decode($wx_user,true);
					$data = array(
						'subscribe' => $wx_user['subscribe'],
						'image'=>	$wx_user['headimgurl'],
					);
					$data['openid']		= $wx_user['openid'];
					$data['name'] 	= str_replace("'",'’',$wx_user['nickname']);
					$data['u_sex'] 	= $wx_user['sex'];  //1男 2 女
					$data['city'] 		= $wx_user['city'];   
					$data['province'] 	= $wx_user['province'];   
					$data['remark'] 	= str_replace("'",'’',$wx_user['remark']);  
					$data['groupid'] 	= $wx_user['groupid']; 
					if($user){
						M('user')->where(array('openid'=>$getRevFrom))->update($data);
					}else{
						M('user')->add($data);
					}
					/*
					$huifu = M('setting')->where(array('name'=>'wx_config'))->find();
					$huifu = unserialize($huifu['value']);
					if(!empty($huifu['guanzhuhuifu'])){
						$this->weixin->text(trim($huifu['guanzhuhuifu']))->reply();
					}
					*/
					break;
			case Wechat::EVENT_UNSUBSCRIBE:  //取消关注
					$getRevFrom = $this->weixin->getRevFrom();  //openid
					if($getRevFrom){
						$update = array(
							'subscribe'=> 0
						);
						M('user')->where(array('openid'=>$getRevFrom))->update($update);
					}
					break;
			default :
					$this->weixin->text("出错了")->reply();
					break;
		}
	}
	
}
?>