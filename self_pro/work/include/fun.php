<?php
if(!defined('PROJECT_NAME')) die('project empty');
header("Content-type: text/html; charset=utf-8"); 
function space_replace(& $data,$type = ''){  //递归
	$str_replace1 = array(' ',"'",'"');
	$str_replace2 = array('&nbsp',"\'",'\"');
	if(is_array($data)){
		foreach($data as $key => $val){
			if(is_array($val)){
				space_replace($data[$key],$type);
			}
			if(is_string($val)){
				$data[$key] = str_replace($str_replace1,$str_replace2,$val);
			}
		}
	}
	if(is_string($data)){
		$data = str_replace($str_replace1,$str_replace2,$data);
	}
}
//防止sql注入，把空格干掉
space_replace($_GET,'get');
space_replace($_POST,'post');
space_replace($_REQUEST,'request');
//反向过滤
function r_space_replace(& $data,$type = ''){
	$str_replace11 = array('&nbsp;','&nbsp',"\'",'\"');
	$str_replace22 = array(' ',' ',"'",'"');
	if(is_array($data)){
		foreach($data as $key => $val){
			if(is_array($val)){
				r_space_replace($data[$key],$type);
			}
			if(is_string($val)){
				$data[$key] = str_replace($str_replace11,$str_replace22,$val);
			}
		}
	}
	if(is_string($data)){
		$data = str_replace($str_replace11,$str_replace22,$data);
	}
}

spl_autoload_register('auto_class');
function auto_class($class){  //自动注册类
	$path = BasePath.DS.WORK.DS.'include'.DS.$class.'.php';
	if(file_exists($path)){
		include $path;
	}
}
function s_trim($val,$str){
	$count = strlen($str);
	for($i=0;$i<$count;$i++){
		if($str{$i} == $val){
			$str{$i} = ' ';
		}else{
			break;
		}
	}
	for($i=$count-1;$i>0;$i--){
		if($str{$i} == $val){
			$str{$i} = ' ';
		}else{
			break;
		}
	}
	$str = trim($str);
	return $str;
}

function f_sort($data,$type = 'k',$field = ''){
	$arr = array();$arr2 = array();
	foreach($data as $key => $val){
		$arr[] = $val[$field];
	}
	if($type == 'k'){
		sort($arr);
	}
	if($type == 'r'){
		rsort($arr);
	}
	foreach($arr as $key => $val){
		foreach($data as $k => $v){
			if($val == $v[$field]){
				$arr2[] = $v;
				unset($data[$k]);
				break;
			}
		}
	}
	return $arr2;
}
//百度编辑器文本转换
function str_replace_baidu($str){
	$arr1 = array(
		'&nbsp;',
		'&nbsp',
		'\"',
	);
	$arr2 = array(
		' ',
		' ',
		"'",
	);
	$str = str_replace($arr1,$arr2,$str);
	return $str;
}

//订单号生成
function generate_order(){
	return date('YmdHis').rand(10000,99999).rand(10000,99999);
}

function get_data_time($type = '',$type1 = '',$type2 = ''){
	if(!empty($type)){
		if(!empty($_POST[$type1]) && !empty($_POST[$type2])){
			$data[$type] = date_en($_POST[$type1],$_POST[$type2]);
		}else if(empty($_POST[$type1]) && !empty($_POST[$type2])){
			$_POST[$type1] = date('Y-m-d');
			$data[$type] = date_en($_POST[$type1],$_POST[$type2]);
		}else if(!empty($_POST[$type1]) && empty($_POST[$type2])){
			$data[$type] = date_en($_POST[$type1],0);
		}else{
			$data[$type] = 0;
		}
		return $data[$type];
	}
	return null;
}

function get_setting($name = 'web_config'){
	if(!empty($name)){
		$setting = M('setting')->where(array('name'=>$name))->find();
		if(!empty($setting)){
			$setting = unserialize($setting['value']);
			return $setting;
		}
	}
	return null;
}

//时间正运算
function date_en($d1,$d2){
	if($d2 == 0){
		$time = strtotime($d1);
	}else{
		$time = strtotime($d1 . ' ' . $d2);
	}
	return $time;
}
//时间逆运算
function date_un($times){
	$time['day'] = date('Y-m-d',$times);
	$time['hour'] = date('H:i:s',$times);
	return $time;
}

//获取图片路径
function get_img($file_name = '',$type = ''){
	
	if(empty($file_name) || empty($type)){
		return false;
	}
	switch($type){
		case 'admin':
			$img = '../'.UPLOADS.'img'.DS.$file_name;
			break;
		case 'store':
			$img = DS.UPLOADS.DS.'store'.DS.substr($file_name,0,8).DS.$file_name;
			break;
		case 'goods':
			$img = DS.UPLOADS.DS.'goods'.DS.substr($file_name,0,8).DS.$file_name;
			break;
		case 'adv':
			$img = DS.UPLOADS.DS.'adv'.DS.substr($file_name,0,8).DS.$file_name;
			break;
		case 'guanjia':
			$img = DS.UPLOADS.DS.'guanjia'.DS.substr($file_name,0,8).DS.$file_name;
			break;
		default:
			$img = DS.UPLOADS.DS.$type.DS.substr($file_name,0,8).DS.$file_name;
			if(file_exists(BasePath.$img)){
				return $img;
			}else{
				return false;
			}
			break;
	}
	return $img;
	
	//return false;
};
//读取语言
function read_language($language){
	global $config;
	$path = BasePath.DS.PROJECT.DS.'language'.DS.$config['language'].DS.$language.'_language.php';
	if(!file_exists($path)){
		$error = $path.' empty';
		show_message($error);
	}
	$language = array();
	include $path;
	return $language;
}

//富文本标题替换
function preg_grep_str($str){
	$arr1 = array(
	//	'<p>',
	//	'</p>',
		'#p#',
		'#e#',
		'&nbsp;',
		'&nbsp',
	);
	$arr2 = array(
	//	'',
	//	'',
		'<div class="super_title">',
		'</div><p>',
		' ',
		' ',
	);
	$str = str_replace($arr1,$arr2,$str);
	return $str;
}

//生成静态html
function static_html($arr){
//	$path = BasePath.DS.'html'.DS.$arr['n_url'].DS.$arr['path'].DS.'index.html';
	$path = $arr['path'];
	if(!file_exists($path)){
		mk_dir(dirname($path));
	}
	$r = file_put_contents($path,$arr['str'],LOCK_EX);
}

function getIp( )
{
	if ( isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] && $_SERVER['HTTP_CLIENT_IP'] != "unknown" )
	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
		return $ip;
	}
	if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && $_SERVER['HTTP_X_FORWARDED_FOR'] != "unknown" )
	{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		return $ip;
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	return $ip;
}


function shop_encrypt( $txt, $key = "" )
{
		if ( empty( $key ) || empty( $txt ) )
		{
				return $txt;
		}
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
		$ikey = "-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
		$nh1 = rand( 0, 64 );
		$nh2 = rand( 0, 64 );
		$nh3 = rand( 0, 64 );
		$ch1 = $chars[$nh1];
		$ch2 = $chars[$nh2];
		$ch3 = $chars[$nh3];
		$nhnum = $nh1 + $nh2 + $nh3;
		$knum = 0;
		$i = 0;
		while ( isset( $key[$i] ) )
		{
				$knum += ord( $key[$i++] );
		}
		$mdKey = substr( md5( md5( md5( $key.$ch1 ).$ch2.$ikey ).$ch3 ), $nhnum % 8, $knum % 8 + 16 );
		$txt = base64_encode( $txt );
		$txt = str_replace( array( "+", "/", "=" ), array( "-", "_", "." ), $txt );
		$tmp = "";
		$j = 0;
		$k = 0;
		$tlen = strlen( $txt );
		$klen = strlen( $mdKey );
		$i = 0;
		for ( ;	$i < $tlen;	++$i	)
		{
				$k = $k == $klen ? 0 : $k;
				$j = ( $nhnum + strpos( $chars, $txt[$i] ) + ord( $mdKey[$k++] ) ) % 64;
				$tmp .= $chars[$j];
		}
		$tmplen = strlen( $tmp );
		$tmp = substr_replace( $tmp, $ch3, $nh2 % ++$tmplen, 0 );
		$tmp = substr_replace( $tmp, $ch2, $nh1 % ++$tmplen, 0 );
		$tmp = substr_replace( $tmp, $ch1, $knum % ++$tmplen, 0 );
		return $tmp;
}

function shop_decrypt( $txt, $key = "" )
{
		if ( empty( $key ) || empty( $txt ) )
		{
				return $txt;
		}
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
		$ikey = "-x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rm";
		$knum = 0;
		$i = 0;
		$tlen = strlen( $txt );
		while ( isset( $key[$i] ) )
		{
				$knum += ord( $key[$i++] );
		}
		$ch1 = $txt[$knum % $tlen];
		$nh1 = strpos( $chars, $ch1 );
		$txt = substr_replace( $txt, "", $knum % $tlen--, 1 );
		$ch2 = $txt[$nh1 % $tlen];
		$nh2 = strpos( $chars, $ch2 );
		$txt = substr_replace( $txt, "", $nh1 % $tlen--, 1 );
		$ch3 = $txt[$nh2 % $tlen];
		$nh3 = strpos( $chars, $ch3 );
		$txt = substr_replace( $txt, "", $nh2 % $tlen--, 1 );
		$nhnum = $nh1 + $nh2 + $nh3;
		$mdKey = substr( md5( md5( md5( $key.$ch1 ).$ch2.$ikey ).$ch3 ), $nhnum % 8, $knum % 8 + 16 );
		$tmp = "";
		$j = 0;
		$k = 0;
		$tlen = strlen( $txt );
		$klen = strlen( $mdKey );
		$i = 0;
		for ( ;	$i < $tlen;	++$i	)
		{
				$k = $k == $klen ? 0 : $k;
				$j = strpos( $chars, $txt[$i] ) - $nhnum - ord( $mdKey[$k++] );
				while ( $j < 0 )
				{
						$j += 64;
				}
				$tmp .= $chars[$j];
		}
		$tmp = str_replace( array( "-", "_", "." ), array( "+", "/", "=" ), $tmp );
		return trim( base64_decode( $tmp ) );
}
//I方法
function I(){
	if(isset($_POST) && !empty($_POST)){
		r_space_replace($_POST,'post');
	}
	if(isset($_GET) && !empty($_GET)){
		r_space_replace($_GET,'get');
	}
}

//$type = true 就去model层
function M($table='',$type=false){
	$model = $table.'Model';
	//文件下的model
	$path = BasePath.DS.PROJECT.DS.'model'.DS.$table.'.Model.php';
	//公共model
	$basepath_path = BasePath.DS.'model'.DS.$table.'.Model.php';
	if($type && !file_exists($path) && !file_exists($basepath_path)){
		$error = $path.' null';
		show_message($error);
	}
	if($type && file_exists($basepath_path)){
		include_once $basepath_path;
		return new $model();
	}
	if($type && file_exists($path)){
		include_once $path;
		return new $model();
	}
	
	$model = new Model();
	return $model->getInstance($table);
}
function setTimeZone( $time_zone='' )
{
	$zonelist = array( "-12" => "Pacific/Kwajalein", "-11" => "Pacific/Samoa", "-10" => "US/Hawaii", "-9" => "US/Alaska", "-8" => "America/Tijuana", "-7" => "US/Arizona", "-6" => "America/Mexico_City", "-5" => "America/Bogota", "-4" => "America/Caracas", "-3.5" => "Canada/Newfoundland", "-3" => "America/Buenos_Aires", "-2" => "Atlantic/St_Helena", "-1" => "Atlantic/Azores", "0" => "Europe/Dublin", "1" => "Europe/Amsterdam", "2" => "Africa/Cairo", "3" => "Asia/Baghdad", "3.5" => "Asia/Tehran", "4" => "Asia/Baku", "4.5" => "Asia/Kabul", "5" => "Asia/Karachi", "5.5" => "Asia/Calcutta", "5.75" => "Asia/Katmandu", "6" => "Asia/Almaty", "6.5" => "Asia/Rangoon", "7" => "Asia/Bangkok", "8" => "Asia/Shanghai", "9" => "Asia/Tokyo", "9.5" => "Australia/Adelaide", "10" => "Australia/Canberra", "11" => "Asia/Magadan", "12" => "Pacific/Auckland" );
	if ( function_exists( "date_default_timezone_set" ) )
	{
		if ( !empty( $zonelist[$time_zone] ) )
		{
				date_default_timezone_set( $zonelist[$time_zone] );
		}
		else
		{
				date_default_timezone_set( "Asia/Shanghai" );
		}
	}
}
function mk_dir( $dir, $mode = 0777 )
{
		if ( is_dir( $dir ) || @mkdir( $dir, $mode ) )
		{
				@chmod($dir,$mode);
				return TRUE;
		}
		if ( !mk_dir( dirname( $dir ), $mode ) )
		{
				return FALSE;
		}
		mkdir( $dir, $mode );
		return @chmod($dir,$mode);
}

//递归删除文件目录
function rm_dir($path){
	if(file_exists($path) && is_dir($path)){
		$dir = scandir($path);
		foreach($dir as $key => $val){
			if($val == '.' || $val == '..'){
				continue;
			}
			if(!is_dir($path.DS.$val)){
				unlink($path.DS.$val);
			}else if(is_dir($path.DS.$val)){
				rm_dir($path.DS.$val);
				rmdir($path.DS.$val);
			}
		}
	}
}
//删除文件
function rm_file($file_name){
	$res = @unlink($file_name);
	return $res;
}
//获取文件路径
function get_path($file_name,$type=''){
	if(empty($type)){
		return false;
	}
	switch($type){
		case 'admin_logo':
			$file_path = BasePath.DS.'uploads'.DS.'img'.DS.$file_name;
			break;
		default:
			return false;
			break;
	}
	if(!empty($file_path)){
		return $file_path;
	}
	return false;
}
//中文字符串隐藏
function hide_repalce($str,$l_len = 1,$r_len=1, $type='',$code='utf-8') {
    mb_internal_encoding($code);
	if($l_len != $r_len && empty($type)){
		$r_len = $l_len;
	}
    $len = mb_strlen($str);
	if($len == 2){  //字符长度只有两个
		return mb_substr($str, 0, $l_len) . str_repeat('*', $len - 1);
	}
	if($len < $l_len+$r_len){
		return hide_repalce($str,$l_len-1,$r_len-1);
	}
    return mb_substr($str, 0, $l_len) . str_repeat('*', $len - ($l_len+$r_len)) . mb_substr($str, $len - $r_len, $len);
}
//后期在改
function show_message($msg = '',$type='',$header=''){
	if(defined('INTERFACE_TYPE') && INTERFACE_TYPE=='json'){  //如果是接口用json返回
		if(is_array($msg))die(json_encode($msg));
		if(is_string($msg))die(json_encode(array('msg'=>$msg)));
	}
	switch ($type){
		case 'html':
			if($header == '-1'){
				$html = '<div>'.$msg.'</div><div id="msg"></div><script> var i = 4; setInterval(function(){ i--; if(i<=1){ history.go(-1); };document.getElementById("msg").innerHTML=i+"秒返回"; },1000);</script>';
			}else if($header == '-2'){
				$html = '<div>'.$msg.'</div><div id="msg"></div><script> var i = 4; setInterval(function(){ i--; if(i<=1){ history.go(-2); };document.getElementById("msg").innerHTML=i+"秒返回"; },1000);</script>';
			}else{
				$html = '<div>'.$msg.'</div><div id="msg"></div><script> var i = 4; setInterval(function(){ i--; if(i<=1){ window.location.href = \''.$header.'\'; };document.getElementById("msg").innerHTML=i+"秒返回"; },1000);</script>';
			}
			echo $html;die;
			break;
		default:
			die($msg);
			break;
		;
	}
	die($msg);
}
//写入静态html
/*
function static_html($url){
	$str = file_get_contents($url);
	if(!empty($str)){
		$file_name = basename($url);
	}else{
		return false;
	}
}
*/

function _curl($type,$url,$data = array()){
	
	if($type=='post' || $type=='POST'){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$put = curl_exec($ch);
	　　curl_close($ch);
		if(!empty($put)){
			return $put;
		}
	}else if($type=='get' || $type=='GET'){
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$put = curl_exec($ch);
		curl_close($ch);
		if(!empty($put)){
			return $put;
		}
	}
	return false;
}
/**
 * 校验日期格式是否正确
 *
 * @param string $date 日期
 * @param string $formats 需要检验的格式数组
 * @return boolean
 */
function checkDateIsValid($date, $formats = array("Y-m-d", "Y/m/d")) {
    $unixTime = strtotime($date);
    if (!$unixTime) { //strtotime转换不对，日期格式显然不对。
        return false;
    }
 
    //校验日期的有效性，只要满足其中一个格式就OK
    foreach ($formats as $format) {
        if (date($format, $unixTime) == $date) {
            return true;
        }
    }
     
    return false;
}

function is_date($date, $formats = array("Y-m-d", "Y/m/d")){
	return checkDateIsValid($date,$formats);
}
//下拉框选择查询
function selected($where = array()){
	if(!empty($where)){
		$data = array();
		foreach($where as $key => $val){
			$data[$val] = isset($_POST[$val]) && !empty($_POST[$val]) ? $val.'/'.$_POST[$val] : $val.'/';
		}
		return $data;
	}
	return false;
}
//查询
function search($where=array(),$other=''){
	$keywords = isset($_GET['keywords'])?$_GET['keywords']:'';
	$str = '';
	if(!empty($other)){
		$other = ' '.$other.' ';
	}
	if(is_string($where) && !empty($keywords)){
		$data = explode('|',$where);
		$str .= $other.' ( '.implode(' like "%'.$keywords.'%" or ',$data).' like "%'.$keywords.'%" ) ';
	}
	if(is_array($where) && !empty($keywords)){
		$str .= $other.' ( '.implode(' like "%'.$keywords.'%" or ',$where).' ) ';
	}
	return $str;
}

//获取文件后缀
function get_file_type( $str )
{
	$a = explode( ".", $str );
	return end( $a );
}
//获取文件格式
function ft($str){
	return get_file_type( $str );
}
//格式化价格
function PriceFormat( $price ,$len = 2)
{
	$price_format = number_format( $price, $len , ".", "" );
	return $price_format;
}
function pf($price ,$len = 2){
	return PriceFormat( $price ,$len);
}
//复写加密
function en_key($txt, $key = ""){  
	return shop_encrypt($txt, $key );
}
//复写解密
function de_key($txt, $key = ""){  
	return shop_decrypt($txt, $key );
}
//或取ip
function get_ip(){  
	return getIp();
}
//默认上海时区
function setdefaulttimezone($time_zone = ''){ 
	setTimeZone($time_zone);
}
//重置一下中国上海时区
setdefaulttimezone(); 
?>