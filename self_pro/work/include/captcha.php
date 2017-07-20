<?php
//验证码类
class captcha {
 private $charset = '0123456789';//随机因子
 private $charset2 = '+-';//随机因子
 private $code;//验证码
 private $code2;//验证码
 private $codelen = 3;//验证码长度
 private $width = 130;//宽度
 private $height = 50;//高度
 private $img;//图形资源句柄
 private $font;//指定的字体
 private $fontsize = 20;//指定字体大小
 private $fontcolor;//指定字体颜色
 //构造方法初始化
 public function __construct() {
	$this->font = dirname(__FILE__).'/font/'.rand(1,6).'.ttf';//注意字体路径要写对，否则显示不了图片
 }
 //生成随机码
 private function createCode() {
	 
  $_len = strlen($this->charset)-1;
  for ($i=0;$i<$this->codelen;$i++) {
   $this->code .= $this->charset[mt_rand(0,$_len)];
  }
 }
 
 //生成随机码
 private function createCode2() {
  $_len = strlen($this->charset)-1;
  $_len2 = strlen($this->charset2)-1;
  for ($i=0;$i<$this->codelen;$i++) {
   if($i == (int)($this->codelen/2)){
	  $this->charset2 = $this->charset2[mt_rand(0,$_len2)];
	  $this->code2 .= $this->charset2;
   }else{
	  $this->code2 .= $this->charset[mt_rand(0,$_len)]; 
   }
  }
  if($this->charset2 == '-'){
	$code = explode('-',$this->code2);
	if($code[1] > $code[0]){
	  $this->code2 =  $code[1].'-'.$code[0];
	}
  }
 }
 
 //生成背景
 private function createBg() {
  $this->img = imagecreatetruecolor($this->width, $this->height);
  $color = imagecolorallocate($this->img, mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));
  imagefilledrectangle($this->img,0,$this->height,$this->width,0,$color);
 }
 //生成文字
 private function createFont() {
  $_x = $this->width / $this->codelen;
  for ($i=0;$i<$this->codelen;$i++) {
   $this->fontcolor = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
   imagettftext($this->img,$this->fontsize,mt_rand(-30,30),$_x*$i+mt_rand(1,5),$this->height / 1.4,$this->fontcolor,$this->font,$this->code[$i]);
  }
 }
 
 //生成文字
 private function createFont2() {
  $_x = $this->width / $this->codelen;
  for ($i=0;$i<$this->codelen;$i++) {
   $this->fontcolor = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
   imagettftext($this->img,$this->fontsize,mt_rand(0,0),$_x*$i+mt_rand(0,0),$this->height / 1.4,$this->fontcolor,$this->font,$this->code2[$i]);
  }
 }
 //生成线条、雪花
 private function createLine() {
  //线条
  for ($i=0;$i<10;$i++) {
   $color = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
   imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
  }
  //雪花
  for ($i=0;$i<25;$i++) {
   $color = imagecolorallocate($this->img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
   imagestring($this->img,mt_rand(1,5),mt_rand(0,$this->width),mt_rand(0,$this->height),'*',$color);
  }
 }
 //输出
 private function outPut() {
  header('Content-type:image/png');
  imagepng($this->img);
  imagedestroy($this->img);
 }
 //对外生成
 public function doimg() {
  $this->createBg();
  $this->createCode();
  $this->createFont();
  $this->createLine();
  $this->outPut();
 }
 
 //对外生成
 public function doimg2() {
  $this->createBg();
  $this->createCode2();
  $this->createFont2();
//  $this->createLine();
  $this->outPut();
 }
 
 //获取验证码
 public function getCode() {
  return strtolower($this->code);
 }
 
 public function getCode2() {
	 $code = array();
	 $code = explode($this->charset2,$this->code2);
	 $num = '';
	 switch($this->charset2){
		 case '+':
		 $num = $code[0] + $code[1];
		 break;
		 case '-':
		 $num = $code[0] - $code[1];
		 break;
		 case 'x':
		 $num = $code[0] * $code[1];
		 break;
		 case '/':
		 $num = $code[0] / $code[1];
		 break;
	 }
	return strtolower($num);
 }
}
?>