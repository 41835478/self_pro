<?php
if(!defined('PROJECT_NAME')) die('project empty');
class control{
	private static $obj = '';
	public  static $output = array();
	private static $left = '';
	private static $header = '';
	private static $footer = '';
	private static $other_page = '';  //附加页面
	public  static $page = ''; //页面地址；
	private static $showdisplay = false;
	private static $cache = '';
	private static $file = array();
	private static $files = array();
	private static $form = array();
	private static $editor = array();
	private static $select_data = array();
	
	public function __construct(){
		self::is_login();
	}
	public static function _unset($val){
		if(isset(self::$output[$val])){
			unset(self::$output[$val]);
			return true;
		}else{
			return false;
		}
	}
	public static function set_cache($name){
		if(!empty($name)){
			self::$cache = $name;
		}else{
			show_message('cache affix empty');
		}
	}
	public static function cache(){
		$path = $_GET['act'].DS.self::$cache.$_GET['act'].'_'.$_GET['op'];
		$cache = new cache($path);
		$data = $cache->r_cache();
		if(!empty($data)){
			self::$output = $data;
			return true;
		}else{
			return false;
		}
	}
	//后台是否登录
	public static function is_login(){
		/*
		if(!isset($_SESSION['login_state']) && $_GET['act'] != 'login' && defined('ADMIN') && ADMIN == true		//后台登录
		){
			header('Location:index.php?act=login&op=index');
		}
		*/
	}
	
	//实例化一个
	public static function getInstance( )
	{
		if ( self::$obj === NULL || !self::$obj instanceof control )
		{
			self::$obj = new control();
		}
		return self::$obj;
	}
	/*
	第一个是url地址，第二个是表单属性，第三个是查询的数据,第四个是提交方式,第五个是类型list或者edit
	第一个参数是字段，第二个参数是自定义名称，第三个是属性，第四个是附加属性，第五个是包含外部文件
	
	self::from($url,array(
		array('text','id','ID','value',$attr = array()),
		array('radio','id','ID',$valus = array(),$attr = array()),
	),'post','edit');
	*/
	static public function form($action = '' , $data = array() , $data2 = array() , $method = 'post' , $page = 'public_form'){
		self::$select_data = & $data2;
		$form = '';
		if(!empty($data)){
			foreach($data as $key => $val){
				
				switch($val[0]){
					case 'text':
						$form .= self::createtext($val);
					break;
					case 'password':
						$form .= self::createpassword($val);
					break;
					case 'label':
						$form .= self::createlabel($val);
					break;
					case 'radio':
						$form .= self::createradio($val);
					break;
					case 'checkbox':
						$form .= self::createcheckbox($val);
					break;
					case 'textarea':
						$form .= self::createtextarea($val);
					break;
					case 'selected':
						$form .= self::createselected($val);
					break;
					case 'file':
						$form .= self::createfile($val);
					break;
					case 'files':
						$form .= self::createfiles($val);
					break;
					case 'editor':
						$form .= self::createeditor($val);
					break;
				}
				/*
				if(isset($val[5]) && file_exists($val[5])){
					include_once $val[5];
				}
				*/
			}
		}
		//处理form表单方法
		$met = '';
		switch($method){
			case 'post':
				$met = 'method="post" enctype="multipart/form-data"';
			break;
			case 'get':
				$met = 'method="get" enctype="multipart/form-data"';
			break;
		}
		if(!empty(self::$file)){
			self::output('file_abcdefghijkl',self::$file);
		}
		
		self::output('method',$met);
		self::output('form',$form);
		self::display($page);
	}
	
	//文件上传
	static public function createfile($data){
		
		self::setotherpage('upload_file');
		$str = '';
		
		if(!empty($data) && $data[0] == 'file'){
			
			$attr = '';
			if(isset($data[4]) && !empty($data[4])){
				$attr = self::createattr($data[4]);
			}
			$content = isset(self::$select_data[$data[1]]) ? self::$select_data[$data[1]] : '';
			//src="'.$value.'"
			$str = '<tr><td>'.$data[2].':</td><td><div style="margin-bottom:10px;"><img '.$attr.' style="max-height:150px;max-width:150px;"  id="img_'.$data[1].'" src="'.$content.'"></div><div class="file_abcdefghijkl" id="'.$data[1].'">选择文件</div><input id="i'.$data[1].'" name="'.$data[1].'" type="hidden" value="'.$content.'"></td></tr>';
		}
		self:$file[] = $data[1];
		return $str;
	}
	
	//多文件上传
	static public function createfiles($data){
		
		self::setotherpage('upload_file');
		$str = '';
		
		if(!empty($data) && $data[0] == 'files'){
			
			$attr = '';
			if(isset($data[4]) && !empty($data[4])){
				$attr = self::createattr($data[4]);
			}
			$value = isset(self::$select_data[$data[1]]) ? self::$select_data[$data[1]] : '';
			//src="'.$value.'"
			$img_value = '';
			if(!empty($value)){
				$images = explode(',',$value);
				foreach($images as $key => $val){
					$img_value .= '<div style="float:left"><div class="image_deahjkl" onclick="image_delqwertyuiopasdfghjklzxcvbnm(\''.$val.'\',this)">X</div><img '.$attr.' style="max-height:150px;max-width:150px;" src="'.$val.'"></div>';
				}
			}
			$c = "\'";
			$img_rep = '<div style="float:left"><div class="image_deahjkl" onclick="image_delqwertyuiopasdfghjklzxcvbnm('.$c.'___IMAGES___'.$c.',this)">X</div><img '.$attr.' style="max-height:150px;max-width:150px;" src="___IMAGES___"></div>';
			self::output('images_abcdefghijklmnopqdasdsa',$img_rep);
			$str = '<tr><td>'.$data[2].':</td><td><div style="overflow:hidden" id="image_'.$data[1].'_box">'.$img_value.'</div><div class="file_abcdefghijklmn" id="'.$data[1].'">选择文件</div><input id="i'.$data[1].'" name="'.$data[1].'" type="hidden" value="'.$value.'"></td></tr>';
		}
		
		self:$file[] = $data[1];
		return $str;
	}
	//创建input文本
	static public function createtext($data){
		$str = '';
		if(!empty($data) && $data[0] == 'text'){
			$attr = '';
			if(isset($data[4]) && !empty($data[4])){
				$attr = self::createattr($data[4]);
			}
			$content = isset(self::$select_data[$data[1]]) ? self::$select_data[$data[1]]: '';
			$str = '<tr><td>'.$data[2].':</td><td><div class="layui-input-inline"><input '.$attr.' class="layui-input" type="text" name="'.$data[1].'" value="'.$content.'"  ></div></td></tr>';
		}
		return $str;
	}
	
	//创建富文本
	static public function createeditor($data){
		include_once BasePath.DS.PLUGINS.DS.'kindeditor/test/editor.php';
		$str = '';
		if(!empty($data) && $data[0] == 'editor'){
			$attr = '';
			if(isset($data[4]) && !empty($data[4])){
				$attr = self::createattr($data[4]);
			}
			$content = isset(self::$select_data[$data[1]]) ? self::$select_data[$data[1]]: '';
			$str = '<tr><td>'.$data[2].':</td><td><textarea class="select_editor_label" '.$attr.' id="'.$data[1].'" name="'.$data[1].'" style="width:90%;height:250px;visibility:hidden;">'.$content.'</textarea></td></tr>';
		}
		return $str;
	}
	//创建input文本
	static public function createlabel($data){
		$str = '';
		if(!empty($data) && $data[0] == 'label'){
			$attr = '';
			if(isset($data[4]) && !empty($data[4])){
				$attr = self::createattr($data[4]);
			}
			$content = isset(self::$select_data[$data[1]]) ? self::$select_data[$data[1]]: '';
			$str = '<tr><td>'.$data[2].':</td><td><div class="layui-input-inline"><input '.$attr.' class="layui-input input-label" readonly="readonly" type="text" name="'.$data[1].'" value="'.$content.'"  ></div></td></tr>';
		}
		return $str;
	}
	
	//创建input密码文本
	static public function createpassword($data){
		$str = '';
		if(!empty($data) && $data[0] == 'password'){
			$attr = '';
			if(isset($data[4]) && !empty($data[4])){
				$attr = self::createattr($data[4]);
			}
			$content = isset(self::$select_data[$data[1]]) ? self::$select_data[$data[1]]: '';
			$str = '<tr><td>'.$data[2].':</td><td><input '.$attr.' class="layui-input" type="password" name="'.$data[1].'" value="'.$content.'"  ></td></tr>';
		}
		return $str;
	}
	
	//创建单选
	static public function createradio($data){
		$str = '';
		if(!empty($data) && $data[0] == 'radio'){
			$attr = '';
			if(isset($data[4]) && !empty($data[4])){
				$attr = self::createattr($data[4]);
			}
			$radio = '';
			if(is_array($data[3])){
				foreach($data[3] as $key => $val){
					if(isset(self::$select_data[$data[1]]) && $key == self::$select_data[$data[1]]){
						$radio .= '<input '.$attr.' type="radio" checked="checked" name="'.$data[1].'" value="'.$key.'" >'.$val.' ';
					}else{
						$radio .= '<input '.$attr.' type="radio" name="'.$data[1].'" value="'.$key.'" >'.$val.' ';
					}
					
				}
			}
			$str = '<tr><td>'.$data[2].':</td><td>'.$radio.'</td></tr>';
		}
		return $str;
	}
	
	//创建多选
	static public function createcheckbox($data){
		$str = '';
		if(!empty($data) && $data[0] == 'checkbox'){
			$attr = '';
			if(isset($data[4]) && !empty($data[4])){
				$attr = self::createattr($data[4]);
			}
			$radio = '';
			if(is_array($data[3])){
				foreach($data[3] as $key => $val){
					$selecked = array();
					if(isset(self::$select_data[$data[1]])){
						$selecked = explode(',',self::$select_data[$data[1]]);
					}
					if(in_array($key,$selecked)){
						$radio .= '<input '.$attr.' type="checkbox" name="'.$data[1].'" checked="checked" value="'.$key.'" >'.$val.' ';
					}else{
						$radio .= '<input '.$attr.' type="checkbox" name="'.$data[1].'" value="'.$key.'" >'.$val.' ';
					}
				}
			}
			$str = '<tr><td>'.$data[2].':</td><td>'.$radio.'</td></tr>';
		}
		return $str;
	}
	
	//创建textarea文本
	static public function createtextarea($data){
		$str = '';
		if(!empty($data) && $data[0] == 'textarea'){
			$attr = '';
			if(isset($data[4]) && !empty($data[4])){
				$attr = self::createattr($data[4]);
			}
			$content = isset(self::$select_data[$data[1]]) ? self::$select_data[$data[1]]: '';
			$str = '<tr><td>'.$data[2].':</td><td><textarea '.$attr.' class="layui-textarea" name="'.$data[1].'" >'.$content.'</textarea></td></tr>';
		}
		return $str;
	}
	
	//创建select选项
	static public function createselected($data){
		$str = '';
		if(!empty($data) && $data[0] == 'selected'){
			$attr = '';
			if(isset($data[4]) && !empty($data[4])){
				$attr = self::createattr($data[4]);
			}
			$selected = '';
			if(is_array($data[3])){
				$selected .= '<select '.$attr.' style="min-width:190px;height: 38px; line-height: 38px;border: 1px solid #e6e6e6;" name="'.$data[1].'" >';
				foreach($data[3] as $key => $val){
					if($key == self::$select_data[$data[1]]){
						$selected .= '<option selected="selected" value="'.$key.'">'.$val.'</option>';
					}else{
						$selected .= '<option value="'.$key.'">'.$val.'</option>';
					}
					
				}
				$selected .= '</select>';
			}
			$str = '<tr><td>'.$data[2].':</td><td>'.$selected.'</td></tr>';
		}
		return $str;
	}
	
	//设置属性
	static public function createattr($d){
		$attr = '';
		if(isset($d) && !empty($d) && is_array($d)){
			foreach($d as $kk => $vv){
				$attr .= $kk.'="'.$vv.'" ';
			}
		}
		
		return $attr;
	}
	
	//设置变量
	static public function output($val,$val2){
		self::getInstance();
		self::$output[$val] = $val2;
	}
	static public function ls(){
		self::$showdisplay = true;
	}
	static public function display($page='',$layout=''){
	
		$output = & self::$output; //这样可以减少内存吧
		$arr1 = array('&nbsp;','&nbsp','&amp;','&amp'); $arr2 = array(' ',' ',' ',' ');
		foreach( $output as $ok => $ov ){
			
			if(is_array($ov)){
				foreach($ov as $kk => $vv){
					$output[$ok][$kk] = str_replace($arr1,$arr2,$output[$ok][$kk]);
				}
			}else{
				$output[$ok] = str_replace($arr1,$arr2,$output[$ok]);
			}
		}
		
		if(!empty($page)){
		//	$page = str_replace('.php','',basename($page));
			$page = str_replace('.php','',$page);
			self::$page = BasePath.DS.PROJECT.DS.'tpl'.DS.WEB.DS.$page.'.php';
		}else{
			self::$page = BasePath.DS.PROJECT.DS.'tpl'.DS.WEB.DS.$_GET['act'].'_'.$_GET['op'].'.php';
		}
		
		//设置编码
		@header( "Content-type: text/html; charset=".CHARSET );
		if(!empty(self::$header)){
			if(file_exists(self::$header)){
				include_once self::$header;
			}else{
				$error = self::$header.' null';
				show_message($error);
			}
		}
		
		if(!empty(self::$left)){
			if(file_exists(self::$left)){
				include_once self::$left;
			}else{
				$error = self::$left.' null';
				show_message($error);
			}
		}
		if(!empty(self::$other_page)){
			if(file_exists(self::$other_page)){
				include_once self::$other_page;
			}else{
				$error = self::$other_page.' null';
				show_message($error);
			}
		}
		if(!file_exists(self::$page)){
			$error = self::$page.' null';
			show_message($error);
		}
		include_once self::$page;
		
		//显示页面的位置
		if(self::$showdisplay){
			$error = self::$page;
			show_message($error);
		}
		
		if(!empty(self::$footer)){
			if(file_exists(self::$footer)){
				include_once self::$footer;
			}else{
				$error = self::$footer.' null';
				show_message($error);
			}
		}
		global $config;
		if($config['cache']){
			$cache = new cache($_GET['act'].DS.self::$cache.$_GET['act'].'_'.$_GET['op']);
			$cache->w_cache($output);
		}
	}
	
	static public function setheader($page=''){
		if($page == 'none'){
			return 'not set header';
		}
		self::$header = self::setlayout('header',$page);
	}
	
	static public function setfooter($page=''){
		if($page == 'none'){
			return 'not set footer';
		}
		self::$footer = self::setlayout('footer',$page);
	}
	
	static public function setotherpage($page=''){
		if($page == 'none'){
			return 'not set otherpage';
		}
		self::$other_page = self::setlayout('',$page);
	}
	
	static public function setleft($page=''){
		if($page == 'none'){
			return 'not set left';
		}
		self::$left = self::setlayout('left',$page);
	}
	
	static private function setlayout($type='',$path_name=''){
		if(!empty($path_name)){
			$path_name = str_replace('.php','',basename($path_name));
			$path = str_replace('//','/',BasePath.DS.PROJECT.DS.'tpl'.DS.WEB.DS.$type.DS.$path_name.'.php');
			return $path;
		}
	} 
}


?>