<?php
if(!defined('PROJECT_NAME')) die('project empty');
  /** 
    二维码生成
  */
class qr_code { 
	
	public $png_temp_dir = '';
	public $errorCorrectionLevel = 'Q'; //qQ H M L 
	public $matrixPointSize = 4;  //1 - 10
	public $data = 'PHP QR Code :)';  //
	public $img = '';
	//public $img_path = '';
	
	public function __construct($data='',$errorCorrectionLevel='',$matrixPointSize=''){
		$this->png_temp_dir = BasePath.DS.'uploads'.DS.'qrcode'.DS;
		if(!empty($errorCorrectionLevel)){
			$this->errorCorrectionLevel = $errorCorrectionLevel;
		}
		if(!empty($matrixPointSize)){
			$this->matrixPointSize = $matrixPointSize;
		}
		if(!empty($data)){
			$this->data = $data;
		}
	//	var_dump($this->png_temp_dir);die;
		include BasePath.DS.'plugins'.DS.'phpqrcode'.DS.'index.php';
	}
	
	public function set($key,$val){
		$this->$key = $val;
		return $this;
	}
	public function get($key){
		if(isset( $this->$key)){
			return $this->$key;
		}
		return false;
	}
	
	//获取二维码
	public function get_img(){
		return $this->img;
	}
	
	//直接显示
	public function show(){
		echo $this->img;
	}
}