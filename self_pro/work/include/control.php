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
	private static $time_data = array();
	
	public function __construct(){
	//	self::is_login();
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
	/*
	public static function is_login(){
		
		if(!isset($_SESSION['login_state']) && $_GET['act'] != 'login' && defined('ADMIN') && ADMIN == true		//后台登录
		){
			header('Location:index.php?act=login&op=index');
		}
		
	}
	*/
	//实例化一个
	public static function getInstance( )
	{
		if ( self::$obj === NULL || !self::$obj instanceof control )
		{
			self::$obj = new control();
		}
		return self::$obj;
	}
	
	static public function form_top($data = array()){
		$form_top = array(
			'selected' 	=> false,
			'start_time' => false,
			'end_time' 	=> false,
			'keyword' 	=> false,
			'all_del' 	=> false,
			'add' 		=> false,
			'search' 	=> false,
			'export' 	=> false,
			'self' 		=> false,
		);
		if(!empty($data)){
			foreach($data as $key => $val){
				$t = is_integer($key) ? $val : $key ;
				switch($t){
					case 'selected':
					$selected = '';
					if(!empty($val) && is_array($val)){
						foreach($val as $k => $v){
							$e = explode('/',$k); 
							$selected .= '<div class="layui-input-inline"><select style="display:none;width:100%;height: 38px; line-height: 38px;border: 1px solid #e6e6e6;" name="'.$e[0].'" class="__web-inspector-hide-shortcut__">';
								foreach($v as $kk => $vv){
									if(isset($e[1]) && !empty($e[1]) && $e[1] == $kk){
										$selected .= '<option selected="selected" value="'.$kk.'">'.$vv.'</option>';
									}else{
										$selected .= '<option value="'.$kk.'">'.$vv.'</option>';
									}
								}
							$selected .= '</select></div>';
						}
					}
					
					$form_top['selected'] = $selected;
					break;
					case 'start_time':
					$val = $val != 'start_time' && $val != false ? date('Y-m-d H:i:s',$val) : KEY;
					$form_top['start_time'] = $val;
					break;
					case 'end_time':
					$val = $val != 'end_time' && $val != false ? date('Y-m-d H:i:s',$val) : KEY;
					
					$form_top['end_time'] = $val;
					break;
					case 'keyword':
					$val = $val != 'keyword' ? $val : KEY;
					if($val == ''){
						$val = KEY;
					}
					$form_top['keyword'] = $val;
					break;
					case 'all_del':
					$form_top['all_del'] = $val;
					break;
					case 'add':
					$form_top['add'] = $val;
					break;
					case 'export':
					$form_top['export'] = $val;
					break;
					case 'search':
					$form_top['search'] = true;
					break;
					case 'self':
					//这个是数组第一个是名称，第二个是数组，用来做属性，第三个是包含，需要弄页面可以重新弄一个页面做js处理
					$attr ='';
					if(isset($val[1]) && !empty($val[1])){
						$attr = self::createattr($val[1]);
					}
					if(isset($val[2]) && !empty($val[2])){
						require_once($val[2]);
					}
					$form_top['self'] = '<a '.$attr.' class="layui-btn" >'.$val[0].'</a>';
					break;
				}
				
			}
			self::output('form_top_hujdfisahjhj',$form_top);
		}
	}
	
	/*
		数据
	*/
	static public function form_list($field,$data,$id = 'id',$page = 'public_form_list'){
		$form_list = '';
		if(!empty($field) && is_array($field)){
			$th = '<tr>';
			foreach($field as $key => $val){
				switch($val[0]){
					case 'checkbox':
						self::setotherpage('checked');
						$th .= '<th><input  class="all_checked_abc" id="all_checked_abc" type="checkbox" >'.$val[2].'</th>';
					break;
					default:
						$th .= '<th>'.$val[2].'</th>';
					break;
				}
			}
			$th .= '</tr>';
			$form_list .= $th;
		}
		if(!empty($data) && is_array($data)){
			$td = '';
			foreach($data as $key => $val){
				$td .= '<tr>';
				foreach($field as $k => $v){
					switch($v[0]){
						case 'checkbox': //主键给个复选框
							$td .= '<th><input value="'.$val[$id].'" class="checked" type="checkbox" >'.$val[$v[1]].'</th>';
						break;
						case 'label':  //普通标签直接显示
							$td .= '<td>'.$val[$v[1]].'</td>';
						break;
						case 'time':  //时间转换
							$val[$v[1]] = isset($val[$v[1]]) ? date('Y-m-d H:i:s',$val[$v[1]]) : '';
							$td .= '<td>'.$val[$v[1]].'</td>';
						break;
						case 'image':  //图片放地址
							$td .= '<td><a target="_blank" href="'.$val[$v[1]].'">'.$val[$v[1]].'</a></td>';
						break;
						case 'radio':
							$td .= '<td>';
							if(is_array($v[3]) && isset( $v[3][$val[$v[1]]] )){
								$td .= $v[3][$val[$v[1]]];
							}
							$td .= '</td>';
						//	$td .= '<td><a target="_blank" href="'.$val[$v[1]].'">'.$val[$v[1]].'</a></td>';
						break;
						case 'href':  //普通标签直接显示
							$td .= '<td><a target="_blank" href="'.$val[$v[1]].'">'.$val[$v[1]].'</a></td>';
						break;
						case 'menu':
							$menu = $v[1];
							$td .= '<td>';
							foreach($menu as $kk => $vv){
								$attr = '';
								if(isset($vv[2]) && !empty($vv[2])){
									$attr = self::createattr($vv[2]);
								}
							//	$vv[1] = str_replace('__ID__',$val[$zhujian],$vv[1]);
								$td .= '<a '.$attr.' class="layui-btn" href="'.$vv[1].'" >'.$vv[0].'</a>';
							}
							$td .= '</td>';
						break;
					}
				}
				$td .= '</tr>';
				//此句是把这个字符串改成id号
				$td = str_replace('__ID__',$val[$id],$td);
			}
			$form_list .= $td;
		}
		self::output('form_list',$form_list);
		self::display($page); 
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
					case 'hidden':
						$form .= self::createhidden($val);
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
					case 'time':
						$form .= self::createtime($val);
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
		
		if(!empty(self::$time_data)){
			self::output('time_abcdefghijkl',self::$time_data);
		}
		
		self::output('method',$met);
		self::output('form',$form);
		if($action == 'this' || $action == ''){
			$action = 'action="?act='.$_GET['act'].'&op='.$_GET['op'].'"';
		}else{
			$action = 'action="'.$action.'"';
		}
		self::output('form_url',$action);
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
	
	//创建input文本
	static public function createtime($data){
		$str = '';
		if(!empty($data) && $data[0] == 'time'){
			$attr = '';
			if(isset($data[3]) && !empty($data[3])){
				$attr = self::createattr($data[3]);
			}
			$content = isset(self::$select_data[$data[1]]) ? self::$select_data[$data[1]]: '';
			if(!empty($content)){
				$content = date('Y-m-d H:i:s',$content);
			}
			$str = '<tr><td>'.$data[2].':</td><td><div class="layui-input-inline"><input '.$attr.' placeholder="'.$content.'" id= "'.$data[1].'" class="layui-input" type="text" name="'.$data[1].'" value="'.$content.'"  ></div></td></tr>';
		}
		self::$time_data[] = $data[1];
		
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
	
	//创建hidden文本
	static public function createhidden($data){
		$str = '';
		if(!empty($data) && $data[0] == 'hidden'){
			$attr = '';
			if(isset($data[3]) && !empty($data[3])){
				$attr = self::createattr($data[3]);
			}
			$content = isset(self::$select_data[$data[1]]) ? self::$select_data[$data[1]]: '';
			$str = '<input '.$attr.' type="hidden" name="'.$data[1].'" value="'.$content.'"  >';
		}
		return $str;
	}
	
	//创建input文本
	static public function createtext($data){
		$str = '';
		if(!empty($data) && $data[0] == 'text'){
			$attr = '';
			if(isset($data[3]) && !empty($data[3])){
				$attr = self::createattr($data[3]);
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
			if(isset($data[3]) && !empty($data[3])){
				$attr = self::createattr($data[3]);
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
			if(isset($data[3]) && !empty($data[3])){
				$attr = self::createattr($data[3]);
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
			if(isset($data[3]) && !empty($data[3])){
				$attr = self::createattr($data[3]);
			}
			$content = isset(self::$select_data[$data[1]]) ? self::$select_data[$data[1]]: '';
			$str = '<tr><td>'.$data[2].':</td><td><input '.$attr.' class="layui-input" type="password" name="'.$data[1].'" ></td></tr>';
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
						$radio .= '<input '.$attr.' style="display:none" type="radio" checked="checked" name="'.$data[1].'" value="'.$key.'" title="'.$val.'">';
					}else{
						$radio .= '<input '.$attr.' style="display:none" type="radio" name="'.$data[1].'" value="'.$key.'" title="'.$val.'">';
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
						$radio .= '<input '.$attr.' style="display:none" type="checkbox" name="'.$data[1].'"  checked="checked" value="'.$key.'" title="'.$val.'">';
					}else{
						$radio .= '<input '.$attr.' style="display:none" type="checkbox" name="'.$data[1].'"   value="'.$key.'" title="'.$val.'">';
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
			if(isset($data[3]) && !empty($data[3])){
				$attr = self::createattr($data[3]);
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
				$selected .= '<select '.$attr.' style="display:none;min-width:190px;height: 38px; line-height: 38px;border: 1px solid #e6e6e6;" name="'.$data[1].'" >';
				foreach($data[3] as $key => $val){
					if(isset(self::$select_data[$data[1]]) && $key == self::$select_data[$data[1]]){
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