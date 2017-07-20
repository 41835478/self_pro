<?php
if(!defined('PROJECT_NAME')) die('project empty');
//匹配验证，需要的自己写，我只写了简单的验证规则
class preg{
	private $min_length = 0;
	private $max_length = 0;
	private $user = '/^(.*){1,31}$/';
	private $password = '/(.*){6,16}/';
	private $email = '/^([a-z][A-Z][0-9]){1}([a-z][A-Z][0-9]){8-12}@([a-z][A-Z][0-9]){2-4}\.([a-z][A-Z][0-9]){2,4}$/';
	private $phone = '/^([0-9]){11}$/';
	private $data = array();
	//验证
	public function verification($str,$rule=array(),$msg = ''){
		if(empty($rule)){
			return true;
		}
		$len = strlen($str);
		foreach($rule as $key => $val){
			if($val == '!empty'){
				empty($str) ? $this->data['msg_empty'] = $msg.'不允许是空的':'';
			}
			if((string)($key) == 'min_length'){
				$len < $val ? $this->data['msg_min_length'] = $msg.'低于最小长度'.$val:'';
				$this->min_length = $val;
			}
			if((string)($key) == 'max_length'){
				$len > $val ? $this->data['msg_max_length'] = $msg.'超过最大长度'.$val:'';
				$this->max_length = $val;
			}
		}
		if(in_array('username',$rule)){
			if(!$this->grep_match($this->user,$str)){
				$this->data['msg_username'] = '用户名验证错误';
			};
		}
		if(in_array('email',$rule)){
			if(!$this->grep_match($this->email,$str)){
				$this->data['msg_email'] = '邮箱验证错误';
			};
		}
		if(in_array('phone',$rule)){
			if(!$this->grep_match($this->phone,$str)){
				$this->data['msg_phone'] = '手机验证错误';
			};
		}
		if(in_array('password',$rule)){
			if(!$this->grep_match($this->password,$str)){
				$this->data['msg_password'] = '密码验证错误';
			};
		}
	}
	//验证函数
	public function grep_match($pattern , $subject, $matches = ''){
		$bool = preg_match($pattern , $subject, $matche);
		return $bool;
	}
	public function verify(){
		return $this->data;
	}
}
?>